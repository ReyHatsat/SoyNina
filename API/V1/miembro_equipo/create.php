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
 
// instantiate miembro_equipo object
include_once '../objects/miembro_equipo.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$miembro_equipo = new Miembro_Equipo($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_persona)
&&!isEmpty($data->id_equipo)
&&!isEmpty($data->id_area_trabajo)
&&!isEmpty($data->funcion)
&&!isEmpty($data->fecha_ingreso)
&&!isEmpty($data->estado)){
 
    // set miembro_equipo property values
	 
if(!isEmpty($data->id_persona)) { 
$miembro_equipo->id_persona = $data->id_persona;
} else { 
$miembro_equipo->id_persona = '';
}
if(!isEmpty($data->id_equipo)) { 
$miembro_equipo->id_equipo = $data->id_equipo;
} else { 
$miembro_equipo->id_equipo = '';
}
if(!isEmpty($data->id_area_trabajo)) { 
$miembro_equipo->id_area_trabajo = $data->id_area_trabajo;
} else { 
$miembro_equipo->id_area_trabajo = '';
}
if(!isEmpty($data->funcion)) { 
$miembro_equipo->funcion = $data->funcion;
} else { 
$miembro_equipo->funcion = '';
}
if(!isEmpty($data->fecha_ingreso)) { 
$miembro_equipo->fecha_ingreso = $data->fecha_ingreso;
} else { 
$miembro_equipo->fecha_ingreso = '';
}
if(!isEmpty($data->estado)) { 
$miembro_equipo->estado = $data->estado;
} else { 
$miembro_equipo->estado = '';
}
 	$lastInsertedId=$miembro_equipo->create();
    // create the miembro_equipo
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the miembro_equipo, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create miembro_equipo","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create miembro_equipo. Data is incomplete.","document"=> ""));
}
?>
