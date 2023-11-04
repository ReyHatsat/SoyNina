<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_moneda.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare tipo_moneda object
$tipo_moneda = new Tipo_Moneda($db);

// get id of tipo_moneda to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of tipo_moneda to be edited
$tipo_moneda->id_tipo_moneda = $data->id_tipo_moneda;

if(
!isEmpty($data->tipo_moneda)
&&!isEmpty($data->activo)
){
// set tipo_moneda property values

if(!isEmpty($data->tipo_moneda)) {
$tipo_moneda->tipo_moneda = $data->tipo_moneda;
} else {
$tipo_moneda->tipo_moneda = '';
}
if(!isEmpty($data->activo)) {
$tipo_moneda->activo = $data->activo;
} else {
$tipo_moneda->activo = '';
}

// update the tipo_moneda
if($tipo_moneda->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the tipo_moneda, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el tipo moneda","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el tipo moneda. Los datos están incompletos.","document"=> ""));
}
?>
