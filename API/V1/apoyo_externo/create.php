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

// instantiate apoyo_externo object
include_once '../objects/apoyo_externo.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$apoyo_externo = new Apoyo_Externo($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->institucion)
&&!isEmpty($data->activo)){

    // set apoyo_externo property values

if(!isEmpty($data->institucion)) {
$apoyo_externo->institucion = $data->institucion;
} else {
$apoyo_externo->institucion = '';
}
if(!isEmpty($data->activo)) {
$apoyo_externo->activo = $data->activo;
} else {
$apoyo_externo->activo = '';
}
 	$lastInsertedId=$apoyo_externo->create();
    // create the apoyo_externo
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the apoyo_externo, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Imposible crear el apoyo externo","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Imposible crear el apoyo externo. Los datos están incompletos.","document"=> ""));
}
?>
