<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asistencia_evento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare asistencia_evento object
$asistencia_evento = new Asistencia_Evento($db);
 
// get asistencia_evento id
$data = json_decode(file_get_contents("php://input"));
 
// set asistencia_evento id to be deleted
$asistencia_evento->id_asistencia_evento = $data->id_asistencia_evento;
 
// delete the asistencia_evento
if($asistencia_evento->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Asistencia_Evento was deleted","document"=> ""));
    
}
 
// if unable to delete the asistencia_evento
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete asistencia_evento.","document"=> ""));
}
?>
