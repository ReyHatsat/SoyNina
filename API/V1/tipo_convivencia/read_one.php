<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_convivencia.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare tipo_convivencia object
$tipo_convivencia = new Tipo_Convivencia($db);
 
// set ID property of record to read
$tipo_convivencia->id_tipo_convivencia = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of tipo_convivencia to be edited
$tipo_convivencia->readOne();
 
if($tipo_convivencia->id_tipo_convivencia!=null){
    // create array
    $tipo_convivencia_arr = array(
        
"id_tipo_convivencia" => $tipo_convivencia->id_tipo_convivencia,
"tipo_convivencia" => $tipo_convivencia->tipo_convivencia,
"activo" => $tipo_convivencia->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_convivencia found","document"=> $tipo_convivencia_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user tipo_convivencia does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "tipo_convivencia does not exist.","document"=> ""));
}
?>
