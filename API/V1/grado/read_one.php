<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/grado.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare grado object
$grado = new Grado($db);
 
// set ID property of record to read
$grado->id_grado = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of grado to be edited
$grado->readOne();
 
if($grado->id_grado!=null){
    // create array
    $grado_arr = array(
        
"id_grado" => $grado->id_grado,
"grado" => $grado->grado,
"activo" => $grado->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "grado found","document"=> $grado_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user grado does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "grado does not exist.","document"=> ""));
}
?>
