<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/encargado.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare encargado object
$encargado = new Encargado($db);
 
// get id of encargado to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of encargado to be edited
$encargado->id_encargado = $data->id_encargado;

if(
!isEmpty($data->id_nina)
&&!isEmpty($data->id_persona)
&&!isEmpty($data->id_parentesco)
&&!isEmpty($data->relacion_nina)
&&!isEmpty($data->autorizado_recoger)
&&!isEmpty($data->restriccion_acercamiento)
&&!isEmpty($data->drogadiccion)
&&!isEmpty($data->descripcion_drogadiccion)
&&!isEmpty($data->privado_libertad)
&&!isEmpty($data->descripcion_privado_libertad)
&&!isEmpty($data->activo)
){
// set encargado property values

if(!isEmpty($data->id_nina)) { 
$encargado->id_nina = $data->id_nina;
} else { 
$encargado->id_nina = '';
}
if(!isEmpty($data->id_persona)) { 
$encargado->id_persona = $data->id_persona;
} else { 
$encargado->id_persona = '';
}
if(!isEmpty($data->id_parentesco)) { 
$encargado->id_parentesco = $data->id_parentesco;
} else { 
$encargado->id_parentesco = '';
}
if(!isEmpty($data->relacion_nina)) { 
$encargado->relacion_nina = $data->relacion_nina;
} else { 
$encargado->relacion_nina = '';
}
if(!isEmpty($data->autorizado_recoger)) { 
$encargado->autorizado_recoger = $data->autorizado_recoger;
} else { 
$encargado->autorizado_recoger = '';
}
if(!isEmpty($data->restriccion_acercamiento)) { 
$encargado->restriccion_acercamiento = $data->restriccion_acercamiento;
} else { 
$encargado->restriccion_acercamiento = '';
}
if(!isEmpty($data->drogadiccion)) { 
$encargado->drogadiccion = $data->drogadiccion;
} else { 
$encargado->drogadiccion = '';
}
if(!isEmpty($data->descripcion_drogadiccion)) { 
$encargado->descripcion_drogadiccion = $data->descripcion_drogadiccion;
} else { 
$encargado->descripcion_drogadiccion = '';
}
if(!isEmpty($data->privado_libertad)) { 
$encargado->privado_libertad = $data->privado_libertad;
} else { 
$encargado->privado_libertad = '';
}
if(!isEmpty($data->descripcion_privado_libertad)) { 
$encargado->descripcion_privado_libertad = $data->descripcion_privado_libertad;
} else { 
$encargado->descripcion_privado_libertad = '';
}
if(!isEmpty($data->activo)) { 
$encargado->activo = $data->activo;
} else { 
$encargado->activo = '1';
}
 
// update the encargado
if($encargado->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the encargado, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update encargado","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update encargado. Data is incomplete.","document"=> ""));
}
?>
