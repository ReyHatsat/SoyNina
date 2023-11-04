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
 
// get asistencia_sororo id
$data = json_decode(file_get_contents("php://input"));
 
// set asistencia_sororo id to be deleted
$asistencia_sororo->id_asistencia_sororo = $data->id_asistencia_sororo;
 
// delete the asistencia_sororo
if($asistencia_sororo->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Asistencia_Sororo was deleted","document"=> ""));
    
}
 
// if unable to delete the asistencia_sororo
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete asistencia_sororo.","document"=> ""));
}
?>
