<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asistencia_sororo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare asistencia_sororo object
$asistencia_sororo = new Asistencia_Sororo($db);
 
// set ID property of record to read
$asistencia_sororo->id_asistencia_sororo = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of asistencia_sororo to be edited
$asistencia_sororo->readOne();
 
if($asistencia_sororo->id_asistencia_sororo!=null){
    // create array
    $asistencia_sororo_arr = array(
        
"id_asistencia_sororo" => $asistencia_sororo->id_asistencia_sororo,
"funcion" => html_entity_decode($asistencia_sororo->funcion),
"id_voluntario" => $asistencia_sororo->id_voluntario,
"fecha" => $asistencia_sororo->fecha,
"circulo_sororo" => $asistencia_sororo->circulo_sororo,
"capacitacion" => $asistencia_sororo->capacitacion
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "asistencia_sororo found","document"=> $asistencia_sororo_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user asistencia_sororo does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "asistencia_sororo does not exist.","document"=> ""));
}
?>
