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

// instantiate ciclo object
include_once '../objects/ciclo.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$ciclo = new Ciclo($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->nombre)
&&!isEmpty($data->activo)){

    // set ciclo property values

if(!isEmpty($data->nombre)) {
$ciclo->nombre = $data->nombre;
} else {
$ciclo->nombre = '';
}
if(!isEmpty($data->activo)) {
$ciclo->activo = $data->activo;
} else {
$ciclo->activo = '1';
}
 	$lastInsertedId=$ciclo->create();
    // create the ciclo
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the ciclo, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el ciclo","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el ciclo. Los datos están incompletos.","document"=> ""));
}
?>
