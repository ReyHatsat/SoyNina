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

// instantiate evento object
include_once '../objects/evento.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$evento = new Evento($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->id_tipo_evento)
&&!isEmpty($data->nombre)
&&!isEmpty($data->activo)){

    // set evento property values

if(!isEmpty($data->id_tipo_evento)) {
$evento->id_tipo_evento = $data->id_tipo_evento;
} else {
$evento->id_tipo_evento = '';
}
if(!isEmpty($data->nombre)) {
$evento->nombre = $data->nombre;
} else {
$evento->nombre = '';
}
if(!isEmpty($data->activo)) {
$evento->activo = $data->activo;
} else {
$evento->activo = '';
}
 	$lastInsertedId=$evento->create();
    // create the evento
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the evento, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el evento","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el evento. Los datos están incompletos.","document"=> ""));
}
?>
