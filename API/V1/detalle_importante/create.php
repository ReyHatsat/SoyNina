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
 
// instantiate detalle_importante object
include_once '../objects/detalle_importante.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$detalle_importante = new Detalle_Importante($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_persona)
&&!isEmpty($data->id_tipo_detalle)
&&!isEmpty($data->detalle)
&&!isEmpty($data->tratamiento)
&&!isEmpty($data->activo)){
 
    // set detalle_importante property values
	 
if(!isEmpty($data->id_persona)) { 
$detalle_importante->id_persona = $data->id_persona;
} else { 
$detalle_importante->id_persona = '';
}
if(!isEmpty($data->id_tipo_detalle)) { 
$detalle_importante->id_tipo_detalle = $data->id_tipo_detalle;
} else { 
$detalle_importante->id_tipo_detalle = '';
}
if(!isEmpty($data->detalle)) { 
$detalle_importante->detalle = $data->detalle;
} else { 
$detalle_importante->detalle = '';
}
if(!isEmpty($data->tratamiento)) { 
$detalle_importante->tratamiento = $data->tratamiento;
} else { 
$detalle_importante->tratamiento = '';
}
if(!isEmpty($data->activo)) { 
$detalle_importante->activo = $data->activo;
} else { 
$detalle_importante->activo = '';
}
 	$lastInsertedId=$detalle_importante->create();
    // create the detalle_importante
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the detalle_importante, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create detalle_importante","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create detalle_importante. Data is incomplete.","document"=> ""));
}
?>
