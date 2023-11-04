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

// instantiate tipo_detalle object
include_once '../objects/tipo_detalle.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$tipo_detalle = new Tipo_Detalle($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->tipo_detalle)
&&!isEmpty($data->activo)){

    // set tipo_detalle property values

if(!isEmpty($data->tipo_detalle)) {
$tipo_detalle->tipo_detalle = $data->tipo_detalle;
} else {
$tipo_detalle->tipo_detalle = '';
}
if(!isEmpty($data->activo)) {
$tipo_detalle->activo = $data->activo;
} else {
$tipo_detalle->activo = '1';
}
 	$lastInsertedId=$tipo_detalle->create();
    // create the tipo_detalle
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the tipo_detalle, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el tipo detalle","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el tipo detalle. Los datos están incompletos.","document"=> ""));
}
?>
