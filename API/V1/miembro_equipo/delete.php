<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/miembro_equipo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare miembro_equipo object
$miembro_equipo = new Miembro_Equipo($db);
 
// get miembro_equipo id
$data = json_decode(file_get_contents("php://input"));
 
// set miembro_equipo id to be deleted
$miembro_equipo->id_miembro_equipo = $data->id_miembro_equipo;
 
// delete the miembro_equipo
if($miembro_equipo->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Miembro_Equipo was deleted","document"=> ""));
    
}
 
// if unable to delete the miembro_equipo
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete miembro_equipo.","document"=> ""));
}
?>
