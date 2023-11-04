<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asesor.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare asesor object
$asesor = new Asesor($db);
 
// set ID property of record to read
$asesor->id_asesor = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of asesor to be edited
$asesor->readOne();
 
if($asesor->id_asesor!=null){
    // create array
    $asesor_arr = array(
        
"id_asesor" => $asesor->id_asesor,
"foto" => html_entity_decode($asesor->foto),
"id_persona" => $asesor->id_persona,
"funcion" => html_entity_decode($asesor->funcion),
"fecha_ingreso" => $asesor->fecha_ingreso
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "asesor found","document"=> $asesor_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user asesor does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "asesor does not exist.","document"=> ""));
}
?>
