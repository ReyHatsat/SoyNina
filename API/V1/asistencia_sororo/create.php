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
 
// instantiate asistencia_sororo object
include_once '../objects/asistencia_sororo.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$asistencia_sororo = new Asistencia_Sororo($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_voluntario)
&&!isEmpty($data->fecha)
&&!isEmpty($data->circulo_sororo)
&&!isEmpty($data->capacitacion)){
 
    // set asistencia_sororo property values
	 
if(!isEmpty($data->id_voluntario)) { 
$asistencia_sororo->id_voluntario = $data->id_voluntario;
} else { 
$asistencia_sororo->id_voluntario = '';
}
if(!isEmpty($data->fecha)) { 
$asistencia_sororo->fecha = $data->fecha;
} else { 
$asistencia_sororo->fecha = '';
}
if(!isEmpty($data->circulo_sororo)) { 
$asistencia_sororo->circulo_sororo = $data->circulo_sororo;
} else { 
$asistencia_sororo->circulo_sororo = '';
}
if(!isEmpty($data->capacitacion)) { 
$asistencia_sororo->capacitacion = $data->capacitacion;
} else { 
$asistencia_sororo->capacitacion = '';
}
 	$lastInsertedId=$asistencia_sororo->create();
    // create the asistencia_sororo
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the asistencia_sororo, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create asistencia_sororo","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create asistencia_sororo. Data is incomplete.","document"=> ""));
}
?>
