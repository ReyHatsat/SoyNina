<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_detalle.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare tipo_detalle object
$tipo_detalle = new Tipo_Detalle($db);
 
// set ID property of record to read
$tipo_detalle->id_tipo_detalle = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of tipo_detalle to be edited
$tipo_detalle->readOne();
 
if($tipo_detalle->id_tipo_detalle!=null){
    // create array
    $tipo_detalle_arr = array(
        
"id_tipo_detalle" => $tipo_detalle->id_tipo_detalle,
"tipo_detalle" => $tipo_detalle->tipo_detalle,
"activo" => $tipo_detalle->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_detalle found","document"=> $tipo_detalle_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user tipo_detalle does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "tipo_detalle does not exist.","document"=> ""));
}
?>
