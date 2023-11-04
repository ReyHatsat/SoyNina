<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_evento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare tipo_evento object
$tipo_evento = new Tipo_Evento($db);
 
// set ID property of record to read
$tipo_evento->id_evento = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of tipo_evento to be edited
$tipo_evento->readOne();
 
if($tipo_evento->id_evento!=null){
    // create array
    $tipo_evento_arr = array(
        
"id_evento" => $tipo_evento->id_evento,
"tipo" => html_entity_decode($tipo_evento->tipo),
"activo" => $tipo_evento->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_evento found","document"=> $tipo_evento_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user tipo_evento does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "tipo_evento does not exist.","document"=> ""));
}
?>
