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
        
        //Mostrar
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            
            //Generamos la consulta
            $sql = $dbConn->prepare("SELECT `posts`.`id`, `posts`.`title`, `posts`.`content`, `posts`.`created`, `users`.`firstname`, `users`.`nivel_de_acceso` FROM `posts` INNER JOIN `users` ON `posts`.`user_id` = `users`.`id` WHERE `posts`.`status` = 0");
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
        
        //En caso de que ninguna de las opciones anteriores se haya ejecutado
        header("HTTP/1.1 400 Bad Request");
        
 
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