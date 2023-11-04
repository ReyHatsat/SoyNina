<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/centro_academico.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare centro_academico object
$centro_academico = new Centro_Academico($db);
 
// set ID property of record to read
$centro_academico->id_centro_academico = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of centro_academico to be edited
$centro_academico->readOne();
 
if($centro_academico->id_centro_academico!=null){
    // create array
    $centro_academico_arr = array(
        
"id_centro_academico" => $centro_academico->id_centro_academico,
"centro_academico" => $centro_academico->centro_academico,
"activo" => $centro_academico->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "centro_academico found","document"=> $centro_academico_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user centro_academico does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "centro_academico does not exist.","document"=> ""));
}
?>
