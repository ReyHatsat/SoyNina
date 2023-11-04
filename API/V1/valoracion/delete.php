<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/valoracion.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare valoracion object
$valoracion = new Valoracion($db);
 
// get valoracion id
$data = json_decode(file_get_contents("php://input"));
 
// set valoracion id to be deleted
$valoracion->id_valoracion = $data->id_valoracion;
 
// delete the valoracion
if($valoracion->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Valoracion was deleted","document"=> ""));
    
}
 
// if unable to delete the valoracion
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete valoracion.","document"=> ""));
}
?>
