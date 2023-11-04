<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/informacion_academica.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare informacion_academica object
$informacion_academica = new Informacion_Academica($db);
 
// set ID property of record to read
$informacion_academica->id_informacion_academica = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of informacion_academica to be edited
$informacion_academica->readOne();
 
if($informacion_academica->id_informacion_academica!=null){
    // create array
    $informacion_academica_arr = array(
        
"id_informacion_academica" => $informacion_academica->id_informacion_academica,
"foto" => html_entity_decode($informacion_academica->foto),
"id_persona" => $informacion_academica->id_persona,
"centro_academico" => $informacion_academica->centro_academico,
"id_centro_academico" => $informacion_academica->id_centro_academico,
"grado" => $informacion_academica->grado,
"id_grado" => $informacion_academica->id_grado,
"rendimiento" => $informacion_academica->rendimiento,
"id_rendimiento" => $informacion_academica->id_rendimiento,
"institucion" => $informacion_academica->institucion,
"id_apoyo_externo" => $informacion_academica->id_apoyo_externo,
"repitente" => $informacion_academica->repitente,
"grado_repetido" => $informacion_academica->grado_repetido,
"beca" => $informacion_academica->beca,
"descripcion_beca" => html_entity_decode($informacion_academica->descripcion_beca),
"motivacion_escuela" => $informacion_academica->motivacion_escuela,
"descripcion_motivacion" => html_entity_decode($informacion_academica->descripcion_motivacion),
"traslada_acompanada" => $informacion_academica->traslada_acompanada,
"foto" => html_entity_decode($informacion_academica->foto),
"id_encargado_traslado" => $informacion_academica->id_encargado_traslado,
"tipo_transporte" => $informacion_academica->tipo_transporte,
"id_transporte" => $informacion_academica->id_transporte,
"estudia_acompanada" => $informacion_academica->estudia_acompanada,
"foto" => html_entity_decode($informacion_academica->foto),
"id_encargado_estudio" => $informacion_academica->id_encargado_estudio,
"trabaja_acompanada" => $informacion_academica->trabaja_acompanada,
"foto" => html_entity_decode($informacion_academica->foto),
"id_encargado_trabajos" => $informacion_academica->id_encargado_trabajos,
"relacion_estudiantes" => html_entity_decode($informacion_academica->relacion_estudiantes),
"acontecimiento_importante" => html_entity_decode($informacion_academica->acontecimiento_importante),
"actividades" => html_entity_decode($informacion_academica->actividades),
"talleres" => html_entity_decode($informacion_academica->talleres)
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "informacion_academica found","document"=> $informacion_academica_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user informacion_academica does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "informacion_academica does not exist.","document"=> ""));
}
?>
