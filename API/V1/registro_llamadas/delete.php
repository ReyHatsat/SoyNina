<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/registro_llamadas.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare registro_llamadas object
$registro_llamadas = new Registro_Llamadas($db);
 
// get registro_llamadas id
$data = json_decode(file_get_contents("php://input"));
 
// set registro_llamadas id to be deleted
$registro_llamadas->id_registro = $data->id_registro;
 
// delete the registro_llamadas
if($registro_llamadas->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Registro_Llamadas was deleted","document"=> ""));
    
}
 
// if unable to delete the registro_llamadas
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete registro_llamadas.","document"=> ""));
}
?>
