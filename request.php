<?php
//headers
header("Access-Control-Allow-Origin: https://ualk.mx/ingeniat/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
//jwt
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

include "config/config.php";
include "config/utils.php";
$dbConn =  connect($db);
 
//get posted data
$data = json_decode(file_get_contents("php://input"));
 
//get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
 
//Verificamos que no este vacio
if($jwt){
 
    //si la decodifica correctamente
    try {
        
        //Conencion a DB
        include_once 'config/database.php';
        include_once 'objects/posts.php';
        $database = new Database();
        $db = $database->getConnection();
        
        //instanciar objeto
        $posts = new Posts($db);
        
        //obtener los datos
        $data = json_decode(file_get_contents("php://input"));
        
        //establecemos los valores
        $posts->id = $data->id;
        $posts->title = $data->title;
        $posts->status = $data->status;
        $posts->content = $data->content;
        //$posts->user_id = $data->user_id;
        
        //Buscamos el nivel de acceso
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $nivel_de_acceso = $decoded->data->nivel_de_acceso;
        $posts->nivel_de_acceso = $nivel_de_acceso;
        
        //Id del usuario
        $user_id = $decoded->data->id;
        $posts->user_id = $user_id;
        
        //Validamos el nivel de acceso del token
        if(!empty($posts->nivel_de_acceso) && $posts->validate_token()){
        
            //Mostrar
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                
                //Si esta vacio el id muestra todos los registros
                if(empty($posts->id)){
                    
                    //Generamos la consulta
                    $sql = $dbConn->prepare("SELECT * FROM posts WHERE status = 0");
                    $sql->execute();
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    
                    //Contamos los registros
                    $num = $sql->rowCount();
                     
                    //Validamos que no este vacio
                    if($num>0){
                    
                        //código de respuesta
                        http_response_code(200);
                        
                        //Muestra la información
                        echo json_encode( $sql->fetchAll()  );
                        exit();
                        
                    }
                    
                    //Si esta vacio
                    else{
                    
                        //código de respuesta
                        http_response_code(400);
                    
                        //Falta de permisos
                        echo json_encode(array("message" => "Actualmente no existen registros."));
                    
                    }
                    
                }
                
                //Si no esta vacio muestra el registro solicitado
                else{
                    
                    //Validamos si tiene permiso
                    if($posts->nivel_de_acceso >= 1){
                    
                        //Generamos la consulta
                        $sql = $dbConn->prepare("SELECT * FROM posts WHERE status = 0 AND id=:id");
                        $sql->bindValue(':id', $posts->id);
                        $sql->execute();
                        
                        //Contamos los registros
                        $num = $sql->rowCount();
                     
                        //Validamos que no este vacio
                        if($num>0){
                        
                            //código de respuesta
                            http_response_code(200);
                            
                            //Muestra la información
                            echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
                            exit();
                        
                        }
                        
                        //Si esta vacio
                        else{
                            
                            //código de respuesta
                            http_response_code(400);
                         
                            //Falta de permisos
                            echo json_encode(array("message" => "No hay registros con la información ingresada."));
                            
                        }
                    
                    }else{
                     
                        //código de respuesta
                        http_response_code(400);
                     
                        //Falta de permisos
                        echo json_encode(array("message" => "No tienes permisos para consultar un post."));
                    }
                    
                }
            
            }
            
            //Agregar
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                //Validamos si tiene permiso
                if($posts->nivel_de_acceso == 2 or $posts->nivel_de_acceso == 3 or $posts->nivel_de_acceso == 4){
                
                    //Validamos que este toda la información necesaria para la consulta
                    if(!empty($posts->title)  && !empty($posts->content) && $posts->create_post()){
                     
                        //código de respuesta
                        http_response_code(200);
                     
                        //Mensaje de aprovación
                        echo json_encode(array("message" => "Post creado."));
                    }
                     
                    //Si no tiene toda la informacion
                    else{
                     
                        //código de respuesta
                        http_response_code(400);
                     
                        //Mensaje de error
                        echo json_encode(array("message" => "No se pudo crear el post."));
                    }
                
                }else{
                 
                    //código de respuesta
                    http_response_code(400);
                 
                    //Falta de permisos
                    echo json_encode(array("message" => "No tienes permisos para agregar un post."));
                }
            
            }
            
            //Actualizar
            if($_SERVER['REQUEST_METHOD'] == 'PUT'){
                
                //Validamos si tiene permiso
                if($posts->nivel_de_acceso == 3 or $posts->nivel_de_acceso == 4){
                 
                    //Validamos que este toda la información necesaria para la consulta
                    if(!empty($posts->id) && !empty($posts->title) && !empty($posts->content) && !empty($posts->user_id) && $posts->update_post()){
                     
                        //código de respuesta
                        http_response_code(200);
                     
                        //Mensaje de aprovación
                        echo json_encode(array("message" => "El post fué actualizado."));
                    }
                     
                    //Si no tiene toda la informacion
                    else{
                     
                        //código de respuesta
                        http_response_code(400);
                     
                        //Mensaje de error
                        echo json_encode(array("message" => "No se pudo actualizar el post."));
                    }
                
                }else{
                 
                    //código de respuesta
                    http_response_code(400);
                 
                    //Falta de permisos
                    echo json_encode(array("message" => "No tienes permisos para actualizar un post."));
                }
            
            }
            
            //Eliminar
            if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
                
                //Validamos si tiene permiso
                if($posts->nivel_de_acceso == 4){
            	
                    //Validamos que este toda la información necesaria para la consulta
                    if(!empty($posts->id) && $posts->delete_post()){
                     
                        //código de respuesta
                        http_response_code(200);
                     
                        //Mensaje de aprovación
                        echo json_encode(array("message" => "El post fue eliminado."));
                    }
                     
                    //Si no tiene toda la informacion
                    else{
                     
                        //código de respuesta
                        http_response_code(400);
                     
                        //Mensaje de error
                        echo json_encode(array("message" => "No se pudo eliminar el post."));
                    }
                
                }else{
                 
                    //código de respuesta
                    http_response_code(400);
                 
                    //Falta de permisos
                    echo json_encode(array("message" => "No tienes permisos para eliminar un post."));
                }
            
            }
            
            //En caso de que ninguna de las opciones anteriores se haya ejecutado
            header("HTTP/1.1 400 Bad Request");
        
        }
        
        //Si el token esta corrupto
        else{
             
            //Falta de permisos
            http_response_code(400);
             
            //Token inválido
            echo json_encode(array("message" => "Token inválido."));
            
        }
 
    }
 
    //Si falla la decodificación falla, Token inválido
    catch (Exception $e){
     
        //código de respuesta
        http_response_code(401);
     
        //Negar el acceso y mostrar mensaje de error
        echo json_encode(array("message" => "Accesso denegado.", "error" => $e->getMessage()));
        
    }
    
}

//si jwt está vacío muestra un mensaje de error 
else{
 
    //código de respuesta
    http_response_code(401);
 
    //Negar el acceso
    echo json_encode(array("message" => "Accesso denegado."));
}