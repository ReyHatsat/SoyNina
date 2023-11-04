<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_convivencia.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare tipo_convivencia object
$tipo_convivencia = new Tipo_Convivencia($db);

// get id of tipo_convivencia to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of tipo_convivencia to be edited
$tipo_convivencia->id_tipo_convivencia = $data->id_tipo_convivencia;

if(
!isEmpty($data->tipo_convivencia)
&&!isEmpty($data->activo)
){
// set tipo_convivencia property values

if(!isEmpty($data->tipo_convivencia)) {
$tipo_convivencia->tipo_convivencia = $data->tipo_convivencia;
} else {
$tipo_convivencia->tipo_convivencia = '';
}
if(!isEmpty($data->activo)) {
$tipo_convivencia->activo = $data->activo;
} else {
$tipo_convivencia->activo = '1';
}

// update the tipo_convivencia
if($tipo_convivencia->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the tipo_convivencia, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el tipo de convivencia","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el tipo de convivencia. Los datos están incompletos.","document"=> ""));
}
?>
