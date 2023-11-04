<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/valoracion.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare valoracion object
$valoracion = new Valoracion($db);
 
// set ID property of record to read
$valoracion->id_valoracion = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of valoracion to be edited
$valoracion->readOne();
 
if($valoracion->id_valoracion!=null){
    // create array
    $valoracion_arr = array(
        
"id_valoracion" => $valoracion->id_valoracion,
"funcion" => html_entity_decode($valoracion->funcion),
"id_voluntario" => $valoracion->id_voluntario,
"nombre" => html_entity_decode($valoracion->nombre),
"rubro" => $valoracion->rubro,
"funcion" => html_entity_decode($valoracion->funcion),
"activo" => $valoracion->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "valoracion found","document"=> $valoracion_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user valoracion does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "valoracion does not exist.","document"=> ""));
}
?>
