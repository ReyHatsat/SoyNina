<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
// get database connection
include_once '../config/database.php';
 
// instantiate area_voluntariado object
include_once '../objects/area_voluntariado.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$area_voluntariado = new Area_Voluntariado($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->nombre)){
 
    // set area_voluntariado property values
	 
if(!isEmpty($data->nombre)) { 
$area_voluntariado->nombre = $data->nombre;
} else { 
$area_voluntariado->nombre = '';
}
 	$lastInsertedId=$area_voluntariado->create();
    // create the area_voluntariado
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the area_voluntariado, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create area_voluntariado","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create area_voluntariado. Data is incomplete.","document"=> ""));
}
?>
