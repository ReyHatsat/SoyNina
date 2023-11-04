<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/rendimiento.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare rendimiento object
$rendimiento = new Rendimiento($db);
 
// set ID property of record to read
$rendimiento->id_rendimiento = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of rendimiento to be edited
$rendimiento->readOne();
 
if($rendimiento->id_rendimiento!=null){
    // create array
    $rendimiento_arr = array(
        
"id_rendimiento" => $rendimiento->id_rendimiento,
"rendimiento" => $rendimiento->rendimiento,
"activo" => $rendimiento->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "rendimiento found","document"=> $rendimiento_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user rendimiento does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "rendimiento does not exist.","document"=> ""));
}
?>
