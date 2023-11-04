<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asistencia_evento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare asistencia_evento object
$asistencia_evento = new Asistencia_Evento($db);
 
// set ID property of record to read
$asistencia_evento->id_asistencia_evento = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of asistencia_evento to be edited
$asistencia_evento->readOne();
 
if($asistencia_evento->id_asistencia_evento!=null){
    // create array
    $asistencia_evento_arr = array(
        
"id_asistencia_evento" => $asistencia_evento->id_asistencia_evento,
"nombre" => html_entity_decode($asistencia_evento->nombre),
"id_evento" => $asistencia_evento->id_evento,
"foto" => html_entity_decode($asistencia_evento->foto),
"id_persona" => $asistencia_evento->id_persona,
"modalidad" => html_entity_decode($asistencia_evento->modalidad),
"asistencia" => $asistencia_evento->asistencia,
"fecha" => $asistencia_evento->fecha
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "asistencia_evento found","document"=> $asistencia_evento_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user asistencia_evento does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "asistencia_evento does not exist.","document"=> ""));
}
?>
