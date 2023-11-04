<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
// get database connection
include_once '../config/database.php';

// instantiate tipo_persona object
include_once '../objects/tipo_persona.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$tipo_persona = new Tipo_Persona($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->tipo_persona)){

    // set tipo_persona property values

if(!isEmpty($data->tipo_persona)) {
$tipo_persona->tipo_persona = $data->tipo_persona;
} else {
$tipo_persona->tipo_persona = '';
}
 	$lastInsertedId=$tipo_persona->create();
    // create the tipo_persona
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the tipo_persona, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el tipo de persona","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el tipo de persona. Data is incomplete.","document"=> ""));
}
?>
