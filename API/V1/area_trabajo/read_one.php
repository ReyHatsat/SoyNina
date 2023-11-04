<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/area_trabajo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare area_trabajo object
$area_trabajo = new Area_Trabajo($db);
 
// set ID property of record to read
$area_trabajo->id_area_trabajo = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of area_trabajo to be edited
$area_trabajo->readOne();
 
if($area_trabajo->id_area_trabajo!=null){
    // create array
    $area_trabajo_arr = array(
        
"id_area_trabajo" => $area_trabajo->id_area_trabajo,
"area_trabajo" => html_entity_decode($area_trabajo->area_trabajo),
"activo" => $area_trabajo->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "area_trabajo found","document"=> $area_trabajo_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user area_trabajo does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "area_trabajo does not exist.","document"=> ""));
}
?>
