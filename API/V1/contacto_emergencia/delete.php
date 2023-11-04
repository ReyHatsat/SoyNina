<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/contacto_emergencia.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare contacto_emergencia object
$contacto_emergencia = new Contacto_Emergencia($db);
 
// get contacto_emergencia id
$data = json_decode(file_get_contents("php://input"));
 
// set contacto_emergencia id to be deleted
$contacto_emergencia->id_contacto_emergencia = $data->id_contacto_emergencia;
 
// delete the contacto_emergencia
if($contacto_emergencia->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Contacto_Emergencia was deleted","document"=> ""));
    
}
 
// if unable to delete the contacto_emergencia
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete contacto_emergencia.","document"=> ""));
}
?>
