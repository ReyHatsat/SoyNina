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

// instantiate rendimiento object
include_once '../objects/rendimiento.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$rendimiento = new Rendimiento($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!isEmpty($data->rendimiento)
&&!isEmpty($data->activo)){

    // set rendimiento property values

if(!isEmpty($data->rendimiento)) {
$rendimiento->rendimiento = $data->rendimiento;
} else {
$rendimiento->rendimiento = '';
}
if(!isEmpty($data->activo)) {
$rendimiento->activo = $data->activo;
} else {
$rendimiento->activo = '';
}
 	$lastInsertedId=$rendimiento->create();
    // create the rendimiento
    if($lastInsertedId!=0){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Creado con éxito","document"=> $lastInsertedId));
    }

    // if unable to create the rendimiento, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el rendimiento","document"=> ""));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No se puede crear el rendimiento. Los datos están incompletos.","document"=> ""));
}
?>
