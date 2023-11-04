<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_persona.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare tipo_persona object
$tipo_persona = new Tipo_Persona($db);
 
// set ID property of record to read
$tipo_persona->id_tipo_persona = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of tipo_persona to be edited
$tipo_persona->readOne();
 
if($tipo_persona->id_tipo_persona!=null){
    // create array
    $tipo_persona_arr = array(
        
"id_tipo_persona" => $tipo_persona->id_tipo_persona,
"tipo_persona" => html_entity_decode($tipo_persona->tipo_persona)
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_persona found","document"=> $tipo_persona_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user tipo_persona does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "tipo_persona does not exist.","document"=> ""));
}
?>
