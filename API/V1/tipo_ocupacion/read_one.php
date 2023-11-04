<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_ocupacion.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare tipo_ocupacion object
$tipo_ocupacion = new Tipo_Ocupacion($db);
 
// set ID property of record to read
$tipo_ocupacion->id_tipo_ocupacion = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of tipo_ocupacion to be edited
$tipo_ocupacion->readOne();
 
if($tipo_ocupacion->id_tipo_ocupacion!=null){
    // create array
    $tipo_ocupacion_arr = array(
        
"id_tipo_ocupacion" => $tipo_ocupacion->id_tipo_ocupacion,
"tipo_ocupacion" => $tipo_ocupacion->tipo_ocupacion,
"activo" => $tipo_ocupacion->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_ocupacion found","document"=> $tipo_ocupacion_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user tipo_ocupacion does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "tipo_ocupacion does not exist.","document"=> ""));
}
?>
