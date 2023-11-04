<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/grado_academico.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare grado_academico object
$grado_academico = new Grado_Academico($db);
 
// set ID property of record to read
$grado_academico->id_grado_academico = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of grado_academico to be edited
$grado_academico->readOne();
 
if($grado_academico->id_grado_academico!=null){
    // create array
    $grado_academico_arr = array(
        
"id_grado_academico" => $grado_academico->id_grado_academico,
"grado_academico" => $grado_academico->grado_academico,
"activo" => $grado_academico->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "grado_academico found","document"=> $grado_academico_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user grado_academico does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "grado_academico does not exist.","document"=> ""));
}
?>
