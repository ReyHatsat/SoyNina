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
 
// get id of area_voluntariado to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of area_voluntariado to be edited
$area_voluntariado->id_area_voluntariado = $data->id_area_voluntariado;

if(
!isEmpty($data->nombre)
){
// set area_voluntariado property values

if(!isEmpty($data->nombre)) { 
$area_voluntariado->nombre = $data->nombre;
} else { 
$area_voluntariado->nombre = '';
}
 
// update the area_voluntariado
if($area_voluntariado->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the area_voluntariado, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update area_voluntariado","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update area_voluntariado. Data is incomplete.","document"=> ""));
}
?>
