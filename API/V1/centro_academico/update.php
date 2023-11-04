<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/centro_academico.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare centro_academico object
$centro_academico = new Centro_Academico($db);

// get id of centro_academico to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of centro_academico to be edited
$centro_academico->id_centro_academico = $data->id_centro_academico;

if(
!isEmpty($data->centro_academico)
&&!isEmpty($data->activo)
){
// set centro_academico property values

if(!isEmpty($data->centro_academico)) {
$centro_academico->centro_academico = $data->centro_academico;
} else {
$centro_academico->centro_academico = '';
}
if(!isEmpty($data->activo)) {
$centro_academico->activo = $data->activo;
} else {
$centro_academico->activo = '';
}

// update the centro_academico
if($centro_academico->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the centro_academico, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar centro academico","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar centro academico. Los datos están incompletos.","document"=> ""));
}
?>
