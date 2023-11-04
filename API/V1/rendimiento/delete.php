<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/rendimiento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare rendimiento object
$rendimiento = new Rendimiento($db);
 
// get rendimiento id
$data = json_decode(file_get_contents("php://input"));
 
// set rendimiento id to be deleted
$rendimiento->id_rendimiento = $data->id_rendimiento;
 
// delete the rendimiento
if($rendimiento->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Rendimiento was deleted","document"=> ""));
    
}
 
// if unable to delete the rendimiento
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete rendimiento.","document"=> ""));
}
?>
