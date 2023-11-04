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
 
// instantiate club object
include_once '../objects/club.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$club = new Club($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_ciclo)
&&!isEmpty($data->nombre)
&&!isEmpty($data->codigo)
&&!isEmpty($data->activo)){
 
    // set club property values
	 
if(!isEmpty($data->id_ciclo)) { 
$club->id_ciclo = $data->id_ciclo;
} else { 
$club->id_ciclo = '';
}
if(!isEmpty($data->nombre)) { 
$club->nombre = $data->nombre;
} else { 
$club->nombre = '';
}
if(!isEmpty($data->codigo)) { 
$club->codigo = $data->codigo;
} else { 
$club->codigo = '';
}
if(!isEmpty($data->activo)) { 
$club->activo = $data->activo;
} else { 
$club->activo = '1';
}
 	$lastInsertedId=$club->create();
    // create the club
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the club, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create club","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create club. Data is incomplete.","document"=> ""));
}
?>
