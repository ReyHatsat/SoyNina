<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/transporte.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare transporte object
$transporte = new Transporte($db);

// get id of transporte to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of transporte to be edited
$transporte->id_transporte = $data->id_transporte;

if(
!isEmpty($data->tipo_transporte)
&&!isEmpty($data->activo)
){
// set transporte property values

if(!isEmpty($data->tipo_transporte)) {
$transporte->tipo_transporte = $data->tipo_transporte;
} else {
$transporte->tipo_transporte = '';
}
if(!isEmpty($data->activo)) {
$transporte->activo = $data->activo;
} else {
$transporte->activo = '';
}

// update the transporte
if($transporte->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the transporte, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el transporte","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el transporte. Los datos están incompletos.","document"=> ""));
}
?>
