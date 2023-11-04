<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asistencia_evento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare asistencia_evento object
$asistencia_evento = new Asistencia_Evento($db);
 
// get id of asistencia_evento to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of asistencia_evento to be edited
$asistencia_evento->id_asistencia_evento = $data->id_asistencia_evento;

if(
!isEmpty($data->id_evento)
&&!isEmpty($data->id_persona)
&&!isEmpty($data->modalidad)
&&!isEmpty($data->asistencia)
&&!isEmpty($data->fecha)
){
// set asistencia_evento property values

if(!isEmpty($data->id_evento)) { 
$asistencia_evento->id_evento = $data->id_evento;
} else { 
$asistencia_evento->id_evento = '';
}
if(!isEmpty($data->id_persona)) { 
$asistencia_evento->id_persona = $data->id_persona;
} else { 
$asistencia_evento->id_persona = '';
}
if(!isEmpty($data->modalidad)) { 
$asistencia_evento->modalidad = $data->modalidad;
} else { 
$asistencia_evento->modalidad = '';
}
if(!isEmpty($data->asistencia)) { 
$asistencia_evento->asistencia = $data->asistencia;
} else { 
$asistencia_evento->asistencia = '';
}
if(!isEmpty($data->fecha)) { 
$asistencia_evento->fecha = $data->fecha;
} else { 
$asistencia_evento->fecha = '';
}
 
// update the asistencia_evento
if($asistencia_evento->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the asistencia_evento, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update asistencia_evento","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update asistencia_evento. Data is incomplete.","document"=> ""));
}
?>
