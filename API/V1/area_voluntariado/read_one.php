<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/area_voluntariado.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare area_voluntariado object
$area_voluntariado = new Area_Voluntariado($db);
 
// set ID property of record to read
$area_voluntariado->id_area_voluntariado = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of area_voluntariado to be edited
$area_voluntariado->readOne();
 
if($area_voluntariado->id_area_voluntariado!=null){
    // create array
    $area_voluntariado_arr = array(
        
"id_area_voluntariado" => $area_voluntariado->id_area_voluntariado,
"nombre" => html_entity_decode($area_voluntariado->nombre)
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "area_voluntariado found","document"=> $area_voluntariado_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user area_voluntariado does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "area_voluntariado does not exist.","document"=> ""));
}
?>
