<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/telefono.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare telefono object
$telefono = new Telefono($db);
 
// get id of telefono to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of telefono to be edited
$telefono->id_telefono = $data->id_telefono;

if(
!isEmpty($data->id_persona)
&&!isEmpty($data->telefono)
){
// set telefono property values

if(!isEmpty($data->id_persona)) { 
$telefono->id_persona = $data->id_persona;
} else { 
$telefono->id_persona = '';
}
if(!isEmpty($data->telefono)) { 
$telefono->telefono = $data->telefono;
} else { 
$telefono->telefono = '';
}
 
// update the telefono
if($telefono->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the telefono, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update telefono","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update telefono. Data is incomplete.","document"=> ""));
}
?>
