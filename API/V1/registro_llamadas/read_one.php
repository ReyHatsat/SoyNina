<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/registro_llamadas.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare registro_llamadas object
$registro_llamadas = new Registro_Llamadas($db);
 
// set ID property of record to read
$registro_llamadas->id_registro = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of registro_llamadas to be edited
$registro_llamadas->readOne();
 
if($registro_llamadas->id_registro!=null){
    // create array
    $registro_llamadas_arr = array(
        
"id_registro" => $registro_llamadas->id_registro,
"foto" => html_entity_decode($registro_llamadas->foto),
"id_persona" => $registro_llamadas->id_persona,
"fecha" => $registro_llamadas->fecha,
"estado" => $registro_llamadas->estado
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "registro_llamadas found","document"=> $registro_llamadas_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user registro_llamadas does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "registro_llamadas does not exist.","document"=> ""));
}
?>
