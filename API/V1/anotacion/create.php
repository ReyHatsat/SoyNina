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
 
// instantiate anotacion object
include_once '../objects/anotacion.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$anotacion = new Anotacion($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_persona)
&&!isEmpty($data->descripcion)){
 
    // set anotacion property values
	 
if(!isEmpty($data->id_persona)) { 
$anotacion->id_persona = $data->id_persona;
} else { 
$anotacion->id_persona = '';
}
if(!isEmpty($data->descripcion)) { 
$anotacion->descripcion = $data->descripcion;
} else { 
$anotacion->descripcion = '';
}
 	$lastInsertedId=$anotacion->create();
    // create the anotacion
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the anotacion, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create anotacion","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create anotacion. Data is incomplete.","document"=> ""));
}
?>
