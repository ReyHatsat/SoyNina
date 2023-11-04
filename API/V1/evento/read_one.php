<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/evento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare evento object
$evento = new Evento($db);
 
// set ID property of record to read
$evento->id_evento = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of evento to be edited
$evento->readOne();
 
if($evento->id_evento!=null){
    // create array
    $evento_arr = array(
        
"id_evento" => $evento->id_evento,
"tipo" => html_entity_decode($evento->tipo),
"id_tipo_evento" => $evento->id_tipo_evento,
"nombre" => html_entity_decode($evento->nombre),
"activo" => $evento->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "evento found","document"=> $evento_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user evento does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "evento does not exist.","document"=> ""));
}
?>
