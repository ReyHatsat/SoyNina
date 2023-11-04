<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/miembro_equipo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare miembro_equipo object
$miembro_equipo = new Miembro_Equipo($db);
 
// get id of miembro_equipo to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of miembro_equipo to be edited
$miembro_equipo->id_miembro_equipo = $data->id_miembro_equipo;

if(
!isEmpty($data->id_persona)
&&!isEmpty($data->id_equipo)
&&!isEmpty($data->id_area_trabajo)
&&!isEmpty($data->funcion)
&&!isEmpty($data->fecha_ingreso)
&&!isEmpty($data->estado)
){
// set miembro_equipo property values

if(!isEmpty($data->id_persona)) { 
$miembro_equipo->id_persona = $data->id_persona;
} else { 
$miembro_equipo->id_persona = '';
}
if(!isEmpty($data->id_equipo)) { 
$miembro_equipo->id_equipo = $data->id_equipo;
} else { 
$miembro_equipo->id_equipo = '';
}
if(!isEmpty($data->id_area_trabajo)) { 
$miembro_equipo->id_area_trabajo = $data->id_area_trabajo;
} else { 
$miembro_equipo->id_area_trabajo = '';
}
if(!isEmpty($data->funcion)) { 
$miembro_equipo->funcion = $data->funcion;
} else { 
$miembro_equipo->funcion = '';
}
if(!isEmpty($data->fecha_ingreso)) { 
$miembro_equipo->fecha_ingreso = $data->fecha_ingreso;
} else { 
$miembro_equipo->fecha_ingreso = '';
}
if(!isEmpty($data->estado)) { 
$miembro_equipo->estado = $data->estado;
} else { 
$miembro_equipo->estado = '';
}
 
// update the miembro_equipo
if($miembro_equipo->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the miembro_equipo, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update miembro_equipo","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update miembro_equipo. Data is incomplete.","document"=> ""));
}
?>
