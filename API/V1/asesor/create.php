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
 
// instantiate asesor object
include_once '../objects/asesor.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$asesor = new Asesor($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_persona)
&&!isEmpty($data->funcion)
&&!isEmpty($data->fecha_ingreso)){
 
    // set asesor property values
	 
if(!isEmpty($data->id_persona)) { 
$asesor->id_persona = $data->id_persona;
} else { 
$asesor->id_persona = '';
}
if(!isEmpty($data->funcion)) { 
$asesor->funcion = $data->funcion;
} else { 
$asesor->funcion = '';
}
if(!isEmpty($data->fecha_ingreso)) { 
$asesor->fecha_ingreso = $data->fecha_ingreso;
} else { 
$asesor->fecha_ingreso = '';
}
 	$lastInsertedId=$asesor->create();
    // create the asesor
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the asesor, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create asesor","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create asesor. Data is incomplete.","document"=> ""));
}
?>
