<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/ciclo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare ciclo object
$ciclo = new Ciclo($db);
 
// set ID property of record to read
$ciclo->id_ciclo = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of ciclo to be edited
$ciclo->readOne();
 
if($ciclo->id_ciclo!=null){
    // create array
    $ciclo_arr = array(
        
"id_ciclo" => $ciclo->id_ciclo,
"nombre" => $ciclo->nombre,
"activo" => $ciclo->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "ciclo found","document"=> $ciclo_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user ciclo does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "ciclo does not exist.","document"=> ""));
}
?>
