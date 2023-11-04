<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/contacto_emergencia.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare contacto_emergencia object
$contacto_emergencia = new Contacto_Emergencia($db);
 
// get id of contacto_emergencia to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of contacto_emergencia to be edited
$contacto_emergencia->id_contacto_emergencia = $data->id_contacto_emergencia;

if(
!isEmpty($data->id_parentesco)
&&!isEmpty($data->id_persona)
&&!isEmpty($data->id_contacto)
){
// set contacto_emergencia property values

if(!isEmpty($data->id_parentesco)) { 
$contacto_emergencia->id_parentesco = $data->id_parentesco;
} else { 
$contacto_emergencia->id_parentesco = '';
}
if(!isEmpty($data->id_persona)) { 
$contacto_emergencia->id_persona = $data->id_persona;
} else { 
$contacto_emergencia->id_persona = '';
}
if(!isEmpty($data->id_contacto)) { 
$contacto_emergencia->id_contacto = $data->id_contacto;
} else { 
$contacto_emergencia->id_contacto = '';
}
 
// update the contacto_emergencia
if($contacto_emergencia->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the contacto_emergencia, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update contacto_emergencia","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update contacto_emergencia. Data is incomplete.","document"=> ""));
}
?>
