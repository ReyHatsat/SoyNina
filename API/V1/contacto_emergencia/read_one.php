<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/contacto_emergencia.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare contacto_emergencia object
$contacto_emergencia = new Contacto_Emergencia($db);
 
// set ID property of record to read
$contacto_emergencia->id_contacto_emergencia = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of contacto_emergencia to be edited
$contacto_emergencia->readOne();
 
if($contacto_emergencia->id_contacto_emergencia!=null){
    // create array
    $contacto_emergencia_arr = array(
        
"id_contacto_emergencia" => $contacto_emergencia->id_contacto_emergencia,
"nombre" => $contacto_emergencia->nombre,
"id_parentesco" => $contacto_emergencia->id_parentesco,
"foto" => html_entity_decode($contacto_emergencia->foto),
"id_persona" => $contacto_emergencia->id_persona,
"foto" => html_entity_decode($contacto_emergencia->foto),
"id_contacto" => $contacto_emergencia->id_contacto
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "contacto_emergencia found","document"=> $contacto_emergencia_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user contacto_emergencia does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "contacto_emergencia does not exist.","document"=> ""));
}
?>
