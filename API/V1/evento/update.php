<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/evento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare evento object
$evento = new Evento($db);

// get id of evento to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of evento to be edited
$evento->id_evento = $data->id_evento;

if(
!isEmpty($data->id_tipo_evento)
&&!isEmpty($data->nombre)
&&!isEmpty($data->activo)
){
// set evento property values

if(!isEmpty($data->id_tipo_evento)) {
$evento->id_tipo_evento = $data->id_tipo_evento;
} else {
$evento->id_tipo_evento = '';
}
if(!isEmpty($data->nombre)) {
$evento->nombre = $data->nombre;
} else {
$evento->nombre = '';
}
if(!isEmpty($data->activo)) {
$evento->activo = $data->activo;
} else {
$evento->activo = '';
}

// update the evento
if($evento->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the evento, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el evento","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el evento. Los datos están incompletos.","document"=> ""));
}
?>
