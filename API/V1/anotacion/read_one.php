<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/anotacion.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare anotacion object
$anotacion = new Anotacion($db);
 
// set ID property of record to read
$anotacion->id_anotacion = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of anotacion to be edited
$anotacion->readOne();
 
if($anotacion->id_anotacion!=null){
    // create array
    $anotacion_arr = array(
        
"id_anotacion" => $anotacion->id_anotacion,
"foto" => html_entity_decode($anotacion->foto),
"id_persona" => $anotacion->id_persona,
"descripcion" => html_entity_decode($anotacion->descripcion)
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "anotacion found","document"=> $anotacion_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user anotacion does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "anotacion does not exist.","document"=> ""));
}
?>
