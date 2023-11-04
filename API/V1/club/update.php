<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/club.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare club object
$club = new Club($db);
 
// get id of club to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of club to be edited
$club->id_club = $data->id_club;

if(
!isEmpty($data->id_ciclo)
&&!isEmpty($data->nombre)
&&!isEmpty($data->codigo)
&&!isEmpty($data->activo)
){
// set club property values

if(!isEmpty($data->id_ciclo)) { 
$club->id_ciclo = $data->id_ciclo;
} else { 
$club->id_ciclo = '';
}
if(!isEmpty($data->nombre)) { 
$club->nombre = $data->nombre;
} else { 
$club->nombre = '';
}
if(!isEmpty($data->codigo)) { 
$club->codigo = $data->codigo;
} else { 
$club->codigo = '';
}
if(!isEmpty($data->activo)) { 
$club->activo = $data->activo;
} else { 
$club->activo = '1';
}
 
// update the club
if($club->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the club, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update club","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update club. Data is incomplete.","document"=> ""));
}
?>
