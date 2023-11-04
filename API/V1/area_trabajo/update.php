<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/area_trabajo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare area_trabajo object
$area_trabajo = new Area_Trabajo($db);

// get id of area_trabajo to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of area_trabajo to be edited
$area_trabajo->id_area_trabajo = $data->id_area_trabajo;

if(
!isEmpty($data->area_trabajo)
&&!isEmpty($data->activo)
){
// set area_trabajo property values

if(!isEmpty($data->area_trabajo)) {
$area_trabajo->area_trabajo = $data->area_trabajo;
} else {
$area_trabajo->area_trabajo = '';
}
if(!isEmpty($data->activo)) {
$area_trabajo->activo = $data->activo;
} else {
$area_trabajo->activo = '';
}

// update the area_trabajo
if($area_trabajo->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the area_trabajo, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el área de trabajo","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el área de trabajo. Los datos están incompletos.","document"=> ""));
}
?>
