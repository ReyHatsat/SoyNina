<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/informacion_socioeconomica.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare informacion_socioeconomica object
$informacion_socioeconomica = new Informacion_Socioeconomica($db);
 
// get id of informacion_socioeconomica to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of informacion_socioeconomica to be edited
$informacion_socioeconomica->id_informacion_socioeconomica = $data->id_informacion_socioeconomica;

if(
!isEmpty($data->id_persona)
&&!isEmpty($data->personas_laborales)
&&!isEmpty($data->ingreso_mensual_aproximado)
&&!isEmpty($data->descripcion_vivienda)
&&!isEmpty($data->comparte_cuarto)
&&!isEmpty($data->id_comparte_cuarto)
&&!isEmpty($data->comparte_cama)
&&!isEmpty($data->id_comparte_cama)
){
// set informacion_socioeconomica property values

if(!isEmpty($data->id_persona)) { 
$informacion_socioeconomica->id_persona = $data->id_persona;
} else { 
$informacion_socioeconomica->id_persona = '';
}
if(!isEmpty($data->personas_laborales)) { 
$informacion_socioeconomica->personas_laborales = $data->personas_laborales;
} else { 
$informacion_socioeconomica->personas_laborales = '';
}
if(!isEmpty($data->ingreso_mensual_aproximado)) { 
$informacion_socioeconomica->ingreso_mensual_aproximado = $data->ingreso_mensual_aproximado;
} else { 
$informacion_socioeconomica->ingreso_mensual_aproximado = '';
}
if(!isEmpty($data->descripcion_vivienda)) { 
$informacion_socioeconomica->descripcion_vivienda = $data->descripcion_vivienda;
} else { 
$informacion_socioeconomica->descripcion_vivienda = '';
}
if(!isEmpty($data->comparte_cuarto)) { 
$informacion_socioeconomica->comparte_cuarto = $data->comparte_cuarto;
} else { 
$informacion_socioeconomica->comparte_cuarto = '';
}
if(!isEmpty($data->id_comparte_cuarto)) { 
$informacion_socioeconomica->id_comparte_cuarto = $data->id_comparte_cuarto;
} else { 
$informacion_socioeconomica->id_comparte_cuarto = '';
}
if(!isEmpty($data->comparte_cama)) { 
$informacion_socioeconomica->comparte_cama = $data->comparte_cama;
} else { 
$informacion_socioeconomica->comparte_cama = '';
}
if(!isEmpty($data->id_comparte_cama)) { 
$informacion_socioeconomica->id_comparte_cama = $data->id_comparte_cama;
} else { 
$informacion_socioeconomica->id_comparte_cama = '';
}
 
// update the informacion_socioeconomica
if($informacion_socioeconomica->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the informacion_socioeconomica, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update informacion_socioeconomica","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update informacion_socioeconomica. Data is incomplete.","document"=> ""));
}
?>
