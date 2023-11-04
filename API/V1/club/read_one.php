<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/club.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare club object
$club = new Club($db);
 
// set ID property of record to read
$club->id_club = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of club to be edited
$club->readOne();
 
if($club->id_club!=null){
    // create array
    $club_arr = array(
        
"id_club" => $club->id_club,
"nombre" => $club->nombre,
"id_ciclo" => $club->id_ciclo,
"nombre" => $club->nombre,
"codigo" => $club->codigo,
"activo" => $club->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "club found","document"=> $club_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user club does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "club does not exist.","document"=> ""));
}
?>
