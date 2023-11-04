<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/telefono.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare telefono object
$telefono = new Telefono($db);
 
// set ID property of record to read
$telefono->id_telefono = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of telefono to be edited
$telefono->readOne();
 
if($telefono->id_telefono!=null){
    // create array
    $telefono_arr = array(
        
"id_telefono" => $telefono->id_telefono,
"foto" => html_entity_decode($telefono->foto),
"id_persona" => $telefono->id_persona,
"telefono" => $telefono->telefono
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "telefono found","document"=> $telefono_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user telefono does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "telefono does not exist.","document"=> ""));
}
?>
