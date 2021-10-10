<?php
// required headers
header("Access-Control-Allow-Origin: https://ualk.mx/ingeniat/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
//Conexion a DB
include_once 'config/database.php';
include_once 'objects/posts.php';
$database = new Database();
$db = $database->getConnection();
 
//Objeto
$posts = new Posts($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
 
//Valores
$posts->title = $data->title;
$posts->status = $data->status;
$posts->content = $data->content;
$posts->user_id = $data->user_id;
 
//Validamos la informacion
if(!empty($posts->title) && !empty($posts->status) && !empty($posts->content) && !empty($posts->user_id) && $posts->update_post()){
 
    //Código de respuesta
    http_response_code(200);
 
    //Mensaje
    echo json_encode(array("message" => "User was created."));
}
 
//Si no esta toda la informacion
else{
 
    ///Código de respuesta
    http_response_code(400);
 
    //Mensaje de error
    echo json_encode(array("message" => "Unable to create user."));
}
?>