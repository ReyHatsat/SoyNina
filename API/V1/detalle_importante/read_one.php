<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/detalle_importante.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare detalle_importante object
$detalle_importante = new Detalle_Importante($db);
 
// set ID property of record to read
$detalle_importante->id_detalle_importante = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of detalle_importante to be edited
$detalle_importante->readOne();
 
if($detalle_importante->id_detalle_importante!=null){
    // create array
    $detalle_importante_arr = array(
        
"id_detalle_importante" => $detalle_importante->id_detalle_importante,
"foto" => html_entity_decode($detalle_importante->foto),
"id_persona" => $detalle_importante->id_persona,
"tipo_detalle" => $detalle_importante->tipo_detalle,
"id_tipo_detalle" => $detalle_importante->id_tipo_detalle,
"detalle" => html_entity_decode($detalle_importante->detalle),
"tratamiento" => html_entity_decode($detalle_importante->tratamiento),
"activo" => $detalle_importante->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "detalle_importante found","document"=> $detalle_importante_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user detalle_importante does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "detalle_importante does not exist.","document"=> ""));
}
?>
