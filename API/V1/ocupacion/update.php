<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/ocupacion.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare ocupacion object
$ocupacion = new Ocupacion($db);
 
// get id of ocupacion to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of ocupacion to be edited
$ocupacion->id_ocupacion = $data->id_ocupacion;

if(
!isEmpty($data->id_persona)
&&!isEmpty($data->id_tipo_ocupacion)
&&!isEmpty($data->lugar_ocupacion)
&&!isEmpty($data->puesto)
&&!isEmpty($data->activo)
){
// set ocupacion property values

if(!isEmpty($data->id_persona)) { 
$ocupacion->id_persona = $data->id_persona;
} else { 
$ocupacion->id_persona = '';
}
if(!isEmpty($data->id_tipo_ocupacion)) { 
$ocupacion->id_tipo_ocupacion = $data->id_tipo_ocupacion;
} else { 
$ocupacion->id_tipo_ocupacion = '';
}
if(!isEmpty($data->lugar_ocupacion)) { 
$ocupacion->lugar_ocupacion = $data->lugar_ocupacion;
} else { 
$ocupacion->lugar_ocupacion = '';
}
if(!isEmpty($data->puesto)) { 
$ocupacion->puesto = $data->puesto;
} else { 
$ocupacion->puesto = '';
}
if(!isEmpty($data->activo)) { 
$ocupacion->activo = $data->activo;
} else { 
$ocupacion->activo = '1';
}
 
// update the ocupacion
if($ocupacion->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the ocupacion, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update ocupacion","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update ocupacion. Data is incomplete.","document"=> ""));
}
?>
