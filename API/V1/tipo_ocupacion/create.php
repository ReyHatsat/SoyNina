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

// instantiate tipo_ocupacion object
include_once '../objects/tipo_ocupacion.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$tipo_ocupacion = new Tipo_Ocupacion($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->tipo_ocupacion)
&&!isEmpty($data->activo)){

    // set tipo_ocupacion property values

if(!isEmpty($data->tipo_ocupacion)) {
$tipo_ocupacion->tipo_ocupacion = $data->tipo_ocupacion;
} else {
$tipo_ocupacion->tipo_ocupacion = '';
}
if(!isEmpty($data->activo)) {
$tipo_ocupacion->activo = $data->activo;
} else {
$tipo_ocupacion->activo = '1';
}
 	$lastInsertedId=$tipo_ocupacion->create();
    // create the tipo_ocupacion
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the tipo_ocupacion, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se pudo crear el tipo de ocupación","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se pudo crear el tipo de ocupación. Los datos están incompletos.","document"=> ""));
}
?>
