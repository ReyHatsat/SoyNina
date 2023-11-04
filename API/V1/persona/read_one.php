<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/persona.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare persona object
$persona = new Persona($db);
 
// set ID property of record to read
$persona->id_persona = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of persona to be edited
$persona->readOne();
 
if($persona->id_persona!=null){
    // create array
    $persona_arr = array(
        
"id_persona" => $persona->id_persona,
"foto" => html_entity_decode($persona->foto),
"identificacion" => $persona->identificacion,
"nombre" => $persona->nombre,
"primer_apellido" => $persona->primer_apellido,
"segundo_apellido" => $persona->segundo_apellido,
"fecha_nacimiento" => $persona->fecha_nacimiento,
"CV" => html_entity_decode($persona->CV),
"nombre" => $persona->nombre,
"id_pais" => $persona->id_pais,
"nombre" => $persona->nombre,
"id_club" => $persona->id_club,
"ingreso_club" => $persona->ingreso_club,
"tipo_persona" => html_entity_decode($persona->tipo_persona),
"id_tipo_persona" => $persona->id_tipo_persona,
"grado_academico" => $persona->grado_academico,
"id_grado_academico" => $persona->id_grado_academico,
"activo" => $persona->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "persona found","document"=> $persona_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user persona does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "persona does not exist.","document"=> ""));
}
?>
