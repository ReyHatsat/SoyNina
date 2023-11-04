<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/rendimiento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare rendimiento object
$rendimiento = new Rendimiento($db);

// get id of rendimiento to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of rendimiento to be edited
$rendimiento->id_rendimiento = $data->id_rendimiento;

if(
!isEmpty($data->rendimiento)
&&!isEmpty($data->activo)
){
// set rendimiento property values

if(!isEmpty($data->rendimiento)) {
$rendimiento->rendimiento = $data->rendimiento;
} else {
$rendimiento->rendimiento = '';
}
if(!isEmpty($data->activo)) {
$rendimiento->activo = $data->activo;
} else {
$rendimiento->activo = '';
}

// update the rendimiento
if($rendimiento->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the rendimiento, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el rendimiento","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el rendimiento. Los datos están incompletos.","document"=> ""));
}
?>
