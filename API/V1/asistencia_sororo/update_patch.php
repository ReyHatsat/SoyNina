<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asistencia_sororo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare asistencia_sororo object
$asistencia_sororo = new Asistencia_Sororo($db);
 
// get id of asistencia_sororo to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of asistencia_sororo to be edited
$asistencia_sororo->id_asistencia_sororo = $data->id_asistencia_sororo;

if(!isEmpty($asistencia_sororo->id_asistencia_sororo)){
 
// update the asistencia_sororo
if($asistencia_sororo->update_patch($data)){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the asistencia_sororo, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update asistencia_sororo","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update asistencia_sororo. Data is incomplete.","document"=> ""));
}
?>
