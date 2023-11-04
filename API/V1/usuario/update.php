<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/usuario.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare usuario object
$usuario = new Usuario($db);
 
// get id of usuario to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of usuario to be edited
$usuario->id_usuario = $data->id_usuario;

if(
!isEmpty($data->id_persona)
&&!isEmpty($data->nombre_usuario)
&&!isEmpty($data->login_salt)
&&!isEmpty($data->login_password)
){
// set usuario property values

if(!isEmpty($data->id_persona)) { 
$usuario->id_persona = $data->id_persona;
} else { 
$usuario->id_persona = '';
}
if(!isEmpty($data->nombre_usuario)) { 
$usuario->nombre_usuario = $data->nombre_usuario;
} else { 
$usuario->nombre_usuario = '';
}
if(!isEmpty($data->login_salt)) { 
$usuario->login_salt = $data->login_salt;
} else { 
$usuario->login_salt = '';
}
if(!isEmpty($data->login_password)) { 
$usuario->login_password = $data->login_password;
} else { 
$usuario->login_password = '';
}
 
// update the usuario
if($usuario->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the usuario, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update usuario","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update usuario. Data is incomplete.","document"=> ""));
}
?>
