<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/informacion_socioeconomica.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare informacion_socioeconomica object
$informacion_socioeconomica = new Informacion_Socioeconomica($db);
 
// get id of informacion_socioeconomica to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of informacion_socioeconomica to be edited
$informacion_socioeconomica->id_informacion_socioeconomica = $data->id_informacion_socioeconomica;

if(!isEmpty($informacion_socioeconomica->id_informacion_socioeconomica)){
 
// update the informacion_socioeconomica
if($informacion_socioeconomica->update_patch($data)){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the informacion_socioeconomica, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update informacion_socioeconomica","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update informacion_socioeconomica. Data is incomplete.","document"=> ""));
}
?>
