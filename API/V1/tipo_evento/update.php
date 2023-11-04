<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_evento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare tipo_evento object
$tipo_evento = new Tipo_Evento($db);

// get id of tipo_evento to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of tipo_evento to be edited
$tipo_evento->id_evento = $data->id_evento;

if(
!isEmpty($data->tipo)
&&!isEmpty($data->activo)
){
// set tipo_evento property values

if(!isEmpty($data->tipo)) {
$tipo_evento->tipo = $data->tipo;
} else {
$tipo_evento->tipo = '';
}
if(!isEmpty($data->activo)) {
$tipo_evento->activo = $data->activo;
} else {
$tipo_evento->activo = '';
}

// update the tipo_evento
if($tipo_evento->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the tipo_evento, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el tipo del evento","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el tipo del evento. Los datos están incompletos.","document"=> ""));
}
?>
