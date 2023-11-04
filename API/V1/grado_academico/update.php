<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/grado_academico.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare grado_academico object
$grado_academico = new Grado_Academico($db);

// get id of grado_academico to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of grado_academico to be edited
$grado_academico->id_grado_academico = $data->id_grado_academico;

if(
!isEmpty($data->grado_academico)
&&!isEmpty($data->activo)
){
// set grado_academico property values

if(!isEmpty($data->grado_academico)) {
$grado_academico->grado_academico = $data->grado_academico;
} else {
$grado_academico->grado_academico = '';
}
if(!isEmpty($data->activo)) {
$grado_academico->activo = $data->activo;
} else {
$grado_academico->activo = '1';
}

// update the grado_academico
if($grado_academico->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the grado_academico, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el grado academico","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el grado academico. Los datos están incompletos.","document"=> ""));
}
?>
