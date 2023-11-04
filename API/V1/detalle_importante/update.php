<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/detalle_importante.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare detalle_importante object
$detalle_importante = new Detalle_Importante($db);
 
// get id of detalle_importante to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of detalle_importante to be edited
$detalle_importante->id_detalle_importante = $data->id_detalle_importante;

if(
!isEmpty($data->id_persona)
&&!isEmpty($data->id_tipo_detalle)
&&!isEmpty($data->detalle)
&&!isEmpty($data->tratamiento)
&&!isEmpty($data->activo)
){
// set detalle_importante property values

if(!isEmpty($data->id_persona)) { 
$detalle_importante->id_persona = $data->id_persona;
} else { 
$detalle_importante->id_persona = '';
}
if(!isEmpty($data->id_tipo_detalle)) { 
$detalle_importante->id_tipo_detalle = $data->id_tipo_detalle;
} else { 
$detalle_importante->id_tipo_detalle = '';
}
if(!isEmpty($data->detalle)) { 
$detalle_importante->detalle = $data->detalle;
} else { 
$detalle_importante->detalle = '';
}
if(!isEmpty($data->tratamiento)) { 
$detalle_importante->tratamiento = $data->tratamiento;
} else { 
$detalle_importante->tratamiento = '';
}
if(!isEmpty($data->activo)) { 
$detalle_importante->activo = $data->activo;
} else { 
$detalle_importante->activo = '';
}
 
// update the detalle_importante
if($detalle_importante->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the detalle_importante, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update detalle_importante","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update detalle_importante. Data is incomplete.","document"=> ""));
}
?>
