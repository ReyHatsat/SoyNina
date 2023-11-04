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

// instantiate tipo_moneda object
include_once '../objects/tipo_moneda.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$tipo_moneda = new Tipo_Moneda($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->tipo_moneda)
&&!isEmpty($data->activo)){

    // set tipo_moneda property values

if(!isEmpty($data->tipo_moneda)) {
$tipo_moneda->tipo_moneda = $data->tipo_moneda;
} else {
$tipo_moneda->tipo_moneda = '';
}
if(!isEmpty($data->activo)) {
$tipo_moneda->activo = $data->activo;
} else {
$tipo_moneda->activo = '';
}
 	$lastInsertedId=$tipo_moneda->create();
    // create the tipo_moneda
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the tipo_moneda, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el tipo moneda","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el tipo moneda. Los datos están incompletos.","document"=> ""));
}
?>
