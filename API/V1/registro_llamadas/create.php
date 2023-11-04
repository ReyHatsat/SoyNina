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

// instantiate registro_llamadas object
include_once '../objects/registro_llamadas.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$registro_llamadas = new Registro_Llamadas($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->id_persona)
&&!isEmpty($data->fecha)
&&!isEmpty($data->estado)){

    // set registro_llamadas property values

if(!isEmpty($data->id_persona)) {
$registro_llamadas->id_persona = $data->id_persona;
} else {
$registro_llamadas->id_persona = '';
}
if(!isEmpty($data->fecha)) {
$registro_llamadas->fecha = $data->fecha;
} else {
$registro_llamadas->fecha = '';
}
if(!isEmpty($data->estado)) {
$registro_llamadas->estado = $data->estado;
} else {
$registro_llamadas->estado = '';
}
 	$lastInsertedId=$registro_llamadas->create();
    // create the registro_llamadas
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the registro_llamadas, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Imposible crear el registro de llamadas","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Imposible crear el registro de llamadas. Los datos están incompletos.","document"=> ""));
}
?>
