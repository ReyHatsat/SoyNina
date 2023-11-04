<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/encargado.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare encargado object
$encargado = new Encargado($db);
 
// set ID property of record to read
$encargado->id_encargado = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of encargado to be edited
$encargado->readOne();
 
if($encargado->id_encargado!=null){
    // create array
    $encargado_arr = array(
        
"id_encargado" => $encargado->id_encargado,
"foto" => html_entity_decode($encargado->foto),
"id_nina" => $encargado->id_nina,
"foto" => html_entity_decode($encargado->foto),
"id_persona" => $encargado->id_persona,
"nombre" => $encargado->nombre,
"id_parentesco" => $encargado->id_parentesco,
"relacion_nina" => html_entity_decode($encargado->relacion_nina),
"autorizado_recoger" => $encargado->autorizado_recoger,
"restriccion_acercamiento" => $encargado->restriccion_acercamiento,
"drogadiccion" => $encargado->drogadiccion,
"descripcion_drogadiccion" => html_entity_decode($encargado->descripcion_drogadiccion),
"privado_libertad" => $encargado->privado_libertad,
"descripcion_privado_libertad" => html_entity_decode($encargado->descripcion_privado_libertad),
"activo" => $encargado->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "encargado found","document"=> $encargado_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user encargado does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "encargado does not exist.","document"=> ""));
}
?>
