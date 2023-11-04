<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/apoyo_externo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare apoyo_externo object
$apoyo_externo = new Apoyo_Externo($db);
 
// set ID property of record to read
$apoyo_externo->id_apoyo_externo = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of apoyo_externo to be edited
$apoyo_externo->readOne();
 
if($apoyo_externo->id_apoyo_externo!=null){
    // create array
    $apoyo_externo_arr = array(
        
"id_apoyo_externo" => $apoyo_externo->id_apoyo_externo,
"institucion" => $apoyo_externo->institucion,
"activo" => $apoyo_externo->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "apoyo_externo found","document"=> $apoyo_externo_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user apoyo_externo does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "apoyo_externo does not exist.","document"=> ""));
}
?>
