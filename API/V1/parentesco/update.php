<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/parentesco.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare parentesco object
$parentesco = new Parentesco($db);

// get id of parentesco to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of parentesco to be edited
$parentesco->id_parentesco = $data->id_parentesco;

if(
!isEmpty($data->nombre)
&&!isEmpty($data->activo)
){
// set parentesco property values

if(!isEmpty($data->nombre)) {
$parentesco->nombre = $data->nombre;
} else {
$parentesco->nombre = '';
}
if(!isEmpty($data->activo)) {
$parentesco->activo = $data->activo;
} else {
$parentesco->activo = '1';
}

// update the parentesco
if($parentesco->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Actualizado con éxito","document"=> ""));
}

// if unable to update the parentesco, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el parentesco","document"=> ""));

}
}
// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede actualizar el parentesco. Los datos están incompletos.","document"=> ""));
}
?>
