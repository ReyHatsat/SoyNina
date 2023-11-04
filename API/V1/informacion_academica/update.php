<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/informacion_academica.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare informacion_academica object
$informacion_academica = new Informacion_Academica($db);
 
// get id of informacion_academica to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of informacion_academica to be edited
$informacion_academica->id_informacion_academica = $data->id_informacion_academica;

if(
!isEmpty($data->id_persona)
&&!isEmpty($data->id_centro_academico)
&&!isEmpty($data->id_grado)
&&!isEmpty($data->id_rendimiento)
&&!isEmpty($data->id_apoyo_externo)
&&!isEmpty($data->repitente)
&&!isEmpty($data->grado_repetido)
&&!isEmpty($data->beca)
&&!isEmpty($data->descripcion_beca)
&&!isEmpty($data->motivacion_escuela)
&&!isEmpty($data->descripcion_motivacion)
&&!isEmpty($data->traslada_acompanada)
&&!isEmpty($data->id_encargado_traslado)
&&!isEmpty($data->id_transporte)
&&!isEmpty($data->estudia_acompanada)
&&!isEmpty($data->id_encargado_estudio)
&&!isEmpty($data->trabaja_acompanada)
&&!isEmpty($data->id_encargado_trabajos)
&&!isEmpty($data->relacion_estudiantes)
&&!isEmpty($data->acontecimiento_importante)
&&!isEmpty($data->actividades)
&&!isEmpty($data->talleres)
){
// set informacion_academica property values

if(!isEmpty($data->id_persona)) { 
$informacion_academica->id_persona = $data->id_persona;
} else { 
$informacion_academica->id_persona = '';
}
if(!isEmpty($data->id_centro_academico)) { 
$informacion_academica->id_centro_academico = $data->id_centro_academico;
} else { 
$informacion_academica->id_centro_academico = '';
}
if(!isEmpty($data->id_grado)) { 
$informacion_academica->id_grado = $data->id_grado;
} else { 
$informacion_academica->id_grado = '';
}
if(!isEmpty($data->id_rendimiento)) { 
$informacion_academica->id_rendimiento = $data->id_rendimiento;
} else { 
$informacion_academica->id_rendimiento = '';
}
if(!isEmpty($data->id_apoyo_externo)) { 
$informacion_academica->id_apoyo_externo = $data->id_apoyo_externo;
} else { 
$informacion_academica->id_apoyo_externo = '';
}
if(!isEmpty($data->repitente)) { 
$informacion_academica->repitente = $data->repitente;
} else { 
$informacion_academica->repitente = '';
}
if(!isEmpty($data->grado_repetido)) { 
$informacion_academica->grado_repetido = $data->grado_repetido;
} else { 
$informacion_academica->grado_repetido = '';
}
if(!isEmpty($data->beca)) { 
$informacion_academica->beca = $data->beca;
} else { 
$informacion_academica->beca = '';
}
if(!isEmpty($data->descripcion_beca)) { 
$informacion_academica->descripcion_beca = $data->descripcion_beca;
} else { 
$informacion_academica->descripcion_beca = '';
}
if(!isEmpty($data->motivacion_escuela)) { 
$informacion_academica->motivacion_escuela = $data->motivacion_escuela;
} else { 
$informacion_academica->motivacion_escuela = '';
}
if(!isEmpty($data->descripcion_motivacion)) { 
$informacion_academica->descripcion_motivacion = $data->descripcion_motivacion;
} else { 
$informacion_academica->descripcion_motivacion = '';
}
if(!isEmpty($data->traslada_acompanada)) { 
$informacion_academica->traslada_acompanada = $data->traslada_acompanada;
} else { 
$informacion_academica->traslada_acompanada = '';
}
if(!isEmpty($data->id_encargado_traslado)) { 
$informacion_academica->id_encargado_traslado = $data->id_encargado_traslado;
} else { 
$informacion_academica->id_encargado_traslado = '';
}
if(!isEmpty($data->id_transporte)) { 
$informacion_academica->id_transporte = $data->id_transporte;
} else { 
$informacion_academica->id_transporte = '';
}
if(!isEmpty($data->estudia_acompanada)) { 
$informacion_academica->estudia_acompanada = $data->estudia_acompanada;
} else { 
$informacion_academica->estudia_acompanada = '';
}
if(!isEmpty($data->id_encargado_estudio)) { 
$informacion_academica->id_encargado_estudio = $data->id_encargado_estudio;
} else { 
$informacion_academica->id_encargado_estudio = '';
}
if(!isEmpty($data->trabaja_acompanada)) { 
$informacion_academica->trabaja_acompanada = $data->trabaja_acompanada;
} else { 
$informacion_academica->trabaja_acompanada = '';
}
if(!isEmpty($data->id_encargado_trabajos)) { 
$informacion_academica->id_encargado_trabajos = $data->id_encargado_trabajos;
} else { 
$informacion_academica->id_encargado_trabajos = '';
}
if(!isEmpty($data->relacion_estudiantes)) { 
$informacion_academica->relacion_estudiantes = $data->relacion_estudiantes;
} else { 
$informacion_academica->relacion_estudiantes = '';
}
if(!isEmpty($data->acontecimiento_importante)) { 
$informacion_academica->acontecimiento_importante = $data->acontecimiento_importante;
} else { 
$informacion_academica->acontecimiento_importante = '';
}
if(!isEmpty($data->actividades)) { 
$informacion_academica->actividades = $data->actividades;
} else { 
$informacion_academica->actividades = '';
}
if(!isEmpty($data->talleres)) { 
$informacion_academica->talleres = $data->talleres;
} else { 
$informacion_academica->talleres = '';
}
 
// update the informacion_academica
if($informacion_academica->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the informacion_academica, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update informacion_academica","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update informacion_academica. Data is incomplete.","document"=> ""));
}
?>
