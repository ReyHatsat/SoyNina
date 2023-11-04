<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/equipo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare equipo object
$equipo = new Equipo($db);
 
// set ID property of record to read
$equipo->id_equipo = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of equipo to be edited
$equipo->readOne();
 
if($equipo->id_equipo!=null){
    // create array
    $equipo_arr = array(
        
"id_equipo" => $equipo->id_equipo,
"nombre" => html_entity_decode($equipo->nombre)
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "equipo found","document"=> $equipo_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user equipo does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "equipo does not exist.","document"=> ""));
}
?>
