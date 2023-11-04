<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/detalle_importante.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare detalle_importante object
$detalle_importante = new Detalle_Importante($db);
 
// get detalle_importante id
$data = json_decode(file_get_contents("php://input"));
 
// set detalle_importante id to be deleted
$detalle_importante->id_detalle_importante = $data->id_detalle_importante;
 
// delete the detalle_importante
if($detalle_importante->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Detalle_Importante was deleted","document"=> ""));
    
}
 
// if unable to delete the detalle_importante
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete detalle_importante.","document"=> ""));
}
?>
