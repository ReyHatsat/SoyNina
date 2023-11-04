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

// instantiate grado_academico object
include_once '../objects/grado_academico.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$grado_academico = new Grado_Academico($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->grado_academico)
&&!isEmpty($data->activo)){

    // set grado_academico property values

if(!isEmpty($data->grado_academico)) {
$grado_academico->grado_academico = $data->grado_academico;
} else {
$grado_academico->grado_academico = '';
}
if(!isEmpty($data->activo)) {
$grado_academico->activo = $data->activo;
} else {
$grado_academico->activo = '1';
}
 	$lastInsertedId=$grado_academico->create();
    // create the grado_academico
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the grado_academico, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el grado academico","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el grado academico. Los datos están incompletos.","document"=> ""));
}
?>
