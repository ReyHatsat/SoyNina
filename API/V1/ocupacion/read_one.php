<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/ocupacion.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare ocupacion object
$ocupacion = new Ocupacion($db);
 
// set ID property of record to read
$ocupacion->id_ocupacion = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of ocupacion to be edited
$ocupacion->readOne();
 
if($ocupacion->id_ocupacion!=null){
    // create array
    $ocupacion_arr = array(
        
"id_ocupacion" => $ocupacion->id_ocupacion,
"foto" => html_entity_decode($ocupacion->foto),
"id_persona" => $ocupacion->id_persona,
"tipo_ocupacion" => $ocupacion->tipo_ocupacion,
"id_tipo_ocupacion" => $ocupacion->id_tipo_ocupacion,
"lugar_ocupacion" => html_entity_decode($ocupacion->lugar_ocupacion),
"puesto" => $ocupacion->puesto,
"activo" => $ocupacion->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "ocupacion found","document"=> $ocupacion_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user ocupacion does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "ocupacion does not exist.","document"=> ""));
}
?>
