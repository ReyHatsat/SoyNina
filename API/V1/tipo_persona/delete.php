<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_persona.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare tipo_persona object
$tipo_persona = new Tipo_Persona($db);

// get tipo_persona id
$data = json_decode(file_get_contents("php://input"));

// set tipo_persona id to be deleted
$tipo_persona->id_tipo_persona = $data->id_tipo_persona;

// delete the tipo_persona
if($tipo_persona->delete()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Se eliminó el tipo de persona","document"=> ""));

}

// if unable to delete the tipo_persona
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede eliminar el tipo persona.","document"=> ""));
}
?>
