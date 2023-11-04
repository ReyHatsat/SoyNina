<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/area_trabajo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare area_trabajo object
$area_trabajo = new Area_Trabajo($db);
 
// get area_trabajo id
$data = json_decode(file_get_contents("php://input"));
 
// set area_trabajo id to be deleted
$area_trabajo->id_area_trabajo = $data->id_area_trabajo;
 
// delete the area_trabajo
if($area_trabajo->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Area_Trabajo was deleted","document"=> ""));
    
}
 
// if unable to delete the area_trabajo
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete area_trabajo.","document"=> ""));
}
?>
