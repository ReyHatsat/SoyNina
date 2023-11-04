<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_ocupacion.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare tipo_ocupacion object
$tipo_ocupacion = new Tipo_Ocupacion($db);
 
// get id of tipo_ocupacion to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of tipo_ocupacion to be edited
$tipo_ocupacion->id_tipo_ocupacion = $data->id_tipo_ocupacion;

if(!isEmpty($tipo_ocupacion->id_tipo_ocupacion)){
 
// update the tipo_ocupacion
if($tipo_ocupacion->update_patch($data)){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the tipo_ocupacion, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update tipo_ocupacion","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update tipo_ocupacion. Data is incomplete.","document"=> ""));
}
?>
