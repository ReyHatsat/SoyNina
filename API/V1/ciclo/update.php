<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/ciclo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare ciclo object
$ciclo = new Ciclo($db);

// get id of ciclo to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of ciclo to be edited
$ciclo->id_ciclo = $data->id_ciclo;

if(
!isEmpty($data->nombre)
&&!isEmpty($data->activo)
){
// set ciclo property values

if(!isEmpty($data->nombre)) {
$ciclo->nombre = $data->nombre;
} else {
$ciclo->nombre = '';
}
if(!isEmpty($data->activo)) {
$ciclo->activo = $data->activo;
} else {
$ciclo->activo = '1';
}

// update the ciclo
if($ciclo->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the ciclo, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el ciclo","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el ciclo. Los datos están incompletos.","document"=> ""));
}
?>
