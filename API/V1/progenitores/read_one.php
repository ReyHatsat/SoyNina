<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/progenitores.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare progenitores object
$progenitores = new Progenitores($db);
 
// set ID property of record to read
$progenitores->id_progenitores = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of progenitores to be edited
$progenitores->readOne();
 
if($progenitores->id_progenitores!=null){
    // create array
    $progenitores_arr = array(
        
"id_progenitores" => $progenitores->id_progenitores,
"tipo_convivencia" => $progenitores->tipo_convivencia,
"id_tipo_convivencia" => $progenitores->id_tipo_convivencia,
"foto" => html_entity_decode($progenitores->foto),
"id_madre" => $progenitores->id_madre,
"foto" => html_entity_decode($progenitores->foto),
"id_padre" => $progenitores->id_padre
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "progenitores found","document"=> $progenitores_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user progenitores does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "progenitores does not exist.","document"=> ""));
}
?>
