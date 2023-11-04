<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_moneda.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare tipo_moneda object
$tipo_moneda = new Tipo_Moneda($db);
 
// set ID property of record to read
$tipo_moneda->id_tipo_moneda = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of tipo_moneda to be edited
$tipo_moneda->readOne();
 
if($tipo_moneda->id_tipo_moneda!=null){
    // create array
    $tipo_moneda_arr = array(
        
"id_tipo_moneda" => $tipo_moneda->id_tipo_moneda,
"tipo_moneda" => html_entity_decode($tipo_moneda->tipo_moneda),
"activo" => $tipo_moneda->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_moneda found","document"=> $tipo_moneda_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user tipo_moneda does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "tipo_moneda does not exist.","document"=> ""));
}
?>
