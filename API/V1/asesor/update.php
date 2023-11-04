<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asesor.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare asesor object
$asesor = new Asesor($db);
 
// get id of asesor to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of asesor to be edited
$asesor->id_asesor = $data->id_asesor;

if(
!isEmpty($data->id_persona)
&&!isEmpty($data->funcion)
&&!isEmpty($data->fecha_ingreso)
){
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
 
// update the asesor
if($asesor->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the asesor, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update asesor","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update asesor. Data is incomplete.","document"=> ""));
}
?>
