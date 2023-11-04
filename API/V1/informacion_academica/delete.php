<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/informacion_academica.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare informacion_academica object
$informacion_academica = new Informacion_Academica($db);
 
// get informacion_academica id
$data = json_decode(file_get_contents("php://input"));
 
// set informacion_academica id to be deleted
$informacion_academica->id_informacion_academica = $data->id_informacion_academica;
 
// delete the informacion_academica
if($informacion_academica->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Informacion_Academica was deleted","document"=> ""));
    
}
 
// if unable to delete the informacion_academica
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete informacion_academica.","document"=> ""));
}
?>
