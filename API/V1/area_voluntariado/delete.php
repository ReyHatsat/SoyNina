<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/area_voluntariado.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare area_voluntariado object
$area_voluntariado = new Area_Voluntariado($db);
 
// get area_voluntariado id
$data = json_decode(file_get_contents("php://input"));
 
// set area_voluntariado id to be deleted
$area_voluntariado->id_area_voluntariado = $data->id_area_voluntariado;
 
// delete the area_voluntariado
if($area_voluntariado->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Area_Voluntariado was deleted","document"=> ""));
    
}
 
// if unable to delete the area_voluntariado
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete area_voluntariado.","document"=> ""));
}
?>
