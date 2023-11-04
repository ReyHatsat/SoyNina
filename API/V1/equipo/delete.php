<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/equipo.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare equipo object
$equipo = new Equipo($db);

// get equipo id
$data = json_decode(file_get_contents("php://input"));

// set equipo id to be deleted
$equipo->id_equipo = $data->id_equipo;

// delete the equipo
if($equipo->delete()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "El equipo fue eliminado","document"=> ""));

}

// if unable to delete the equipo
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede eliminar el equipo.","document"=> ""));
}
?>
