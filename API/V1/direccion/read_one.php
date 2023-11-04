<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/direccion.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare direccion object
$direccion = new Direccion($db);
 
// set ID property of record to read
$direccion->id_direccion = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of direccion to be edited
$direccion->readOne();
 
if($direccion->id_direccion!=null){
    // create array
    $direccion_arr = array(
        
"id_direccion" => $direccion->id_direccion,
"foto" => html_entity_decode($direccion->foto),
"id_persona" => $direccion->id_persona,
"descripcion" => html_entity_decode($direccion->descripcion)
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "direccion found","document"=> $direccion_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user direccion does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "direccion does not exist.","document"=> ""));
}
?>
