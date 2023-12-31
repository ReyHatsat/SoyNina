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
 
// instantiate ocupacion object
include_once '../objects/ocupacion.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$ocupacion = new Ocupacion($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_persona)
&&!isEmpty($data->id_tipo_ocupacion)
&&!isEmpty($data->lugar_ocupacion)
&&!isEmpty($data->puesto)
&&!isEmpty($data->activo)){
 
    // set ocupacion property values
	 
if(!isEmpty($data->id_persona)) { 
$ocupacion->id_persona = $data->id_persona;
} else { 
$ocupacion->id_persona = '';
}
if(!isEmpty($data->id_tipo_ocupacion)) { 
$ocupacion->id_tipo_ocupacion = $data->id_tipo_ocupacion;
} else { 
$ocupacion->id_tipo_ocupacion = '';
}
if(!isEmpty($data->lugar_ocupacion)) { 
$ocupacion->lugar_ocupacion = $data->lugar_ocupacion;
} else { 
$ocupacion->lugar_ocupacion = '';
}
if(!isEmpty($data->puesto)) { 
$ocupacion->puesto = $data->puesto;
} else { 
$ocupacion->puesto = '';
}
if(!isEmpty($data->activo)) { 
$ocupacion->activo = $data->activo;
} else { 
$ocupacion->activo = '1';
}
 	$lastInsertedId=$ocupacion->create();
    // create the ocupacion
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the ocupacion, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create ocupacion","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create ocupacion. Data is incomplete.","document"=> ""));
}
?>
