<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/voluntario.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare voluntario object
$voluntario = new Voluntario($db);
 
// get id of voluntario to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of voluntario to be edited
$voluntario->id_voluntario = $data->id_voluntario;

if(
!isEmpty($data->area_voluntariado)
&&!isEmpty($data->funcion)
&&!isEmpty($data->fecha_ingreso)
&&!isEmpty($data->estado)
&&!isEmpty($data->id_persona)
){
// set voluntario property values

if(!isEmpty($data->area_voluntariado)) { 
$voluntario->area_voluntariado = $data->area_voluntariado;
} else { 
$voluntario->area_voluntariado = '';
}
if(!isEmpty($data->funcion)) { 
$voluntario->funcion = $data->funcion;
} else { 
$voluntario->funcion = '';
}
if(!isEmpty($data->fecha_ingreso)) { 
$voluntario->fecha_ingreso = $data->fecha_ingreso;
} else { 
$voluntario->fecha_ingreso = '';
}
if(!isEmpty($data->estado)) { 
$voluntario->estado = $data->estado;
} else { 
$voluntario->estado = '';
}
if(!isEmpty($data->id_persona)) { 
$voluntario->id_persona = $data->id_persona;
} else { 
$voluntario->id_persona = '';
}
 
// update the voluntario
if($voluntario->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the voluntario, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update voluntario","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update voluntario. Data is incomplete.","document"=> ""));
}
?>
