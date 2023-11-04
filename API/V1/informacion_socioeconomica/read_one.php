<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/informacion_socioeconomica.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare informacion_socioeconomica object
$informacion_socioeconomica = new Informacion_Socioeconomica($db);
 
// set ID property of record to read
$informacion_socioeconomica->id_informacion_socioeconomica = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of informacion_socioeconomica to be edited
$informacion_socioeconomica->readOne();
 
if($informacion_socioeconomica->id_informacion_socioeconomica!=null){
    // create array
    $informacion_socioeconomica_arr = array(
        
"id_informacion_socioeconomica" => $informacion_socioeconomica->id_informacion_socioeconomica,
"foto" => html_entity_decode($informacion_socioeconomica->foto),
"id_persona" => $informacion_socioeconomica->id_persona,
"personas_laborales" => $informacion_socioeconomica->personas_laborales,
"ingreso_mensual_aproximado" => $informacion_socioeconomica->ingreso_mensual_aproximado,
"descripcion_vivienda" => html_entity_decode($informacion_socioeconomica->descripcion_vivienda),
"comparte_cuarto" => $informacion_socioeconomica->comparte_cuarto,
"foto" => html_entity_decode($informacion_socioeconomica->foto),
"id_comparte_cuarto" => $informacion_socioeconomica->id_comparte_cuarto,
"comparte_cama" => $informacion_socioeconomica->comparte_cama,
"foto" => html_entity_decode($informacion_socioeconomica->foto),
"id_comparte_cama" => $informacion_socioeconomica->id_comparte_cama
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "informacion_socioeconomica found","document"=> $informacion_socioeconomica_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user informacion_socioeconomica does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "informacion_socioeconomica does not exist.","document"=> ""));
}
?>
