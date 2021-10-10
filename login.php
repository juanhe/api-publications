<?php
//headers
header("Access-Control-Allow-Origin: https://ualk.mx/ingeniat/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
//Conencion a DB
include_once 'config/database.php';
include_once 'objects/user.php';
$database = new Database();
$db = $database->getConnection();
 
//Objeto
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
//Valores
$user->email = $data->email;
$email_exists = $user->emailExists();
 
//Generamos json web token
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
//Verificamos email y password
if($email_exists && password_verify($data->password, $user->password)){
 
    $token = array(
       "iat" => $issued_at,
       "exp" => $expiration_time,
       "iss" => $issuer,
       "data" => array(
           "id" => $user->id,
           "firstname" => $user->firstname,
           "lastname" => $user->lastname,
           "email" => $user->email,
           "nivel_de_acceso" => $user->access_level
       )
    );
 
    //Código de respuesta
    http_response_code(200);
 
    //Generamos jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt
            )
        );
 
}
 
// login failed
else{
 
    //Código de respuesta
    http_response_code(401);
 
    //Mensaje de error
    echo json_encode(array("message" => "Login failed."));
}
?>