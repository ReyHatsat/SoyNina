<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/voluntario.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare voluntario object
$voluntario = new Voluntario($db);
 
// set ID property of record to read
$voluntario->id_voluntario = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of voluntario to be edited
$voluntario->readOne();
 
if($voluntario->id_voluntario!=null){
    // create array
    $voluntario_arr = array(
        
"id_voluntario" => $voluntario->id_voluntario,
"nombre" => html_entity_decode($voluntario->nombre),
"area_voluntariado" => $voluntario->area_voluntariado,
"funcion" => html_entity_decode($voluntario->funcion),
"fecha_ingreso" => $voluntario->fecha_ingreso,
"estado" => $voluntario->estado,
"foto" => html_entity_decode($voluntario->foto),
"id_persona" => $voluntario->id_persona
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "voluntario found","document"=> $voluntario_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user voluntario does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "voluntario does not exist.","document"=> ""));
}
?>
