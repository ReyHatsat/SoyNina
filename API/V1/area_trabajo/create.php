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

// instantiate area_trabajo object
include_once '../objects/area_trabajo.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$area_trabajo = new Area_Trabajo($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->area_trabajo)
&&!isEmpty($data->activo)){

    // set area_trabajo property values

if(!isEmpty($data->area_trabajo)) {
$area_trabajo->area_trabajo = $data->area_trabajo;
} else {
$area_trabajo->area_trabajo = '';
}
if(!isEmpty($data->activo)) {
$area_trabajo->activo = $data->activo;
} else {
$area_trabajo->activo = '';
}
 	$lastInsertedId=$area_trabajo->create();
    // create the area_trabajo
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the area_trabajo, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el área de trabajo","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el área de trabajo. Los datos están incompletos.","document"=> ""));
}
?>
