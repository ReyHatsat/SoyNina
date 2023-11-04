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
 
// instantiate asistencia_evento object
include_once '../objects/asistencia_evento.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$asistencia_evento = new Asistencia_Evento($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_evento)
&&!isEmpty($data->id_persona)
&&!isEmpty($data->modalidad)
&&!isEmpty($data->asistencia)
&&!isEmpty($data->fecha)){
 
    // set asistencia_evento property values
	 
if(!isEmpty($data->id_evento)) { 
$asistencia_evento->id_evento = $data->id_evento;
} else { 
$asistencia_evento->id_evento = '';
}
if(!isEmpty($data->id_persona)) { 
$asistencia_evento->id_persona = $data->id_persona;
} else { 
$asistencia_evento->id_persona = '';
}
if(!isEmpty($data->modalidad)) { 
$asistencia_evento->modalidad = $data->modalidad;
} else { 
$asistencia_evento->modalidad = '';
}
if(!isEmpty($data->asistencia)) { 
$asistencia_evento->asistencia = $data->asistencia;
} else { 
$asistencia_evento->asistencia = '';
}
if(!isEmpty($data->fecha)) { 
$asistencia_evento->fecha = $data->fecha;
} else { 
$asistencia_evento->fecha = '';
}
 	$lastInsertedId=$asistencia_evento->create();
    // create the asistencia_evento
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the asistencia_evento, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create asistencia_evento","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create asistencia_evento. Data is incomplete.","document"=> ""));
}
?>
