<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/transporte.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare transporte object
$transporte = new Transporte($db);
 
// set ID property of record to read
$transporte->id_transporte = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of transporte to be edited
$transporte->readOne();
 
if($transporte->id_transporte!=null){
    // create array
    $transporte_arr = array(
        
"id_transporte" => $transporte->id_transporte,
"tipo_transporte" => $transporte->tipo_transporte,
"activo" => $transporte->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "transporte found","document"=> $transporte_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user transporte does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "transporte does not exist.","document"=> ""));
}
?>
