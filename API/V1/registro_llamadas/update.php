<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/registro_llamadas.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare registro_llamadas object
$registro_llamadas = new Registro_Llamadas($db);

// get id of registro_llamadas to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of registro_llamadas to be edited
$registro_llamadas->id_registro = $data->id_registro;

if(
!isEmpty($data->id_persona)
&&!isEmpty($data->fecha)
&&!isEmpty($data->estado)
){
// set registro_llamadas property values

if(!isEmpty($data->id_persona)) {
$registro_llamadas->id_persona = $data->id_persona;
} else {
$registro_llamadas->id_persona = '';
}
if(!isEmpty($data->fecha)) {
$registro_llamadas->fecha = $data->fecha;
} else {
$registro_llamadas->fecha = '';
}
if(!isEmpty($data->estado)) {
$registro_llamadas->estado = $data->estado;
} else {
$registro_llamadas->estado = '';
}

// update the registro_llamadas
if($registro_llamadas->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the registro_llamadas, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Imposible actualizar el registro de llamadas","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Imposible actualizar el registro de llamadas. Los datos están incompletos.","document"=> ""));
}
?>
