<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/rubro.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare rubro object
$rubro = new Rubro($db);
 
// set ID property of record to read
$rubro->id_rubro = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of rubro to be edited
$rubro->readOne();
 
if($rubro->id_rubro!=null){
    // create array
    $rubro_arr = array(
        
"id_rubro" => $rubro->id_rubro,
"nombre" => html_entity_decode($rubro->nombre)
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "rubro found","document"=> $rubro_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user rubro does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "rubro does not exist.","document"=> ""));
}
?>
