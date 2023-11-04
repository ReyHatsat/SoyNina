<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/parentesco.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare parentesco object
$parentesco = new Parentesco($db);
 
// set ID property of record to read
$parentesco->id_parentesco = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of parentesco to be edited
$parentesco->readOne();
 
if($parentesco->id_parentesco!=null){
    // create array
    $parentesco_arr = array(
        
"id_parentesco" => $parentesco->id_parentesco,
"nombre" => $parentesco->nombre,
"activo" => $parentesco->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "parentesco found","document"=> $parentesco_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user parentesco does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "parentesco does not exist.","document"=> ""));
}
?>
