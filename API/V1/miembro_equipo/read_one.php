<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/miembro_equipo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare miembro_equipo object
$miembro_equipo = new Miembro_Equipo($db);
 
// set ID property of record to read
$miembro_equipo->id_miembro_equipo = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of miembro_equipo to be edited
$miembro_equipo->readOne();
 
if($miembro_equipo->id_miembro_equipo!=null){
    // create array
    $miembro_equipo_arr = array(
        
"id_miembro_equipo" => $miembro_equipo->id_miembro_equipo,
"foto" => html_entity_decode($miembro_equipo->foto),
"id_persona" => $miembro_equipo->id_persona,
"nombre" => html_entity_decode($miembro_equipo->nombre),
"id_equipo" => $miembro_equipo->id_equipo,
"area_trabajo" => html_entity_decode($miembro_equipo->area_trabajo),
"id_area_trabajo" => $miembro_equipo->id_area_trabajo,
"funcion" => html_entity_decode($miembro_equipo->funcion),
"fecha_ingreso" => $miembro_equipo->fecha_ingreso,
"estado" => $miembro_equipo->estado
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "miembro_equipo found","document"=> $miembro_equipo_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user miembro_equipo does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "miembro_equipo does not exist.","document"=> ""));
}
?>
