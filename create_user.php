<?php
// required headers
header("Access-Control-Allow-Origin: https://ualk.mx/ingeniat/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
//Conexion a DB
include_once 'config/database.php';
include_once 'objects/user.php';
$database = new Database();
$db = $database->getConnection();
 
//Objeto
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
//Valores
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;
$user->access_level = $data->access_level;
 
//Crear usuario
if(!empty($user->firstname) && !empty($user->email) && !empty($user->password) && !empty($user->access_level) && $user->create()){
 
    //Código de respuesta
    http_response_code(200);
 
    //Mensaje
    echo json_encode(array("message" => "User was created."));
}
 
//Si no esta toda la informacion para crearlo
else{
 
    //Código de respuesta
    http_response_code(400);
 
    //Mensaje de error
    echo json_encode(array("message" => "Unable to create user."));
}
?>