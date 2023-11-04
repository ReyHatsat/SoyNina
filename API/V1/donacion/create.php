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
 
// instantiate donacion object
include_once '../objects/donacion.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$donacion = new Donacion($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->tipo_moneda)
&&!isEmpty($data->id_persona)
&&!isEmpty($data->monto)
&&!isEmpty($data->metodo_pago)){
 
    // set donacion property values
	 
if(!isEmpty($data->tipo_moneda)) { 
$donacion->tipo_moneda = $data->tipo_moneda;
} else { 
$donacion->tipo_moneda = '';
}
if(!isEmpty($data->id_persona)) { 
$donacion->id_persona = $data->id_persona;
} else { 
$donacion->id_persona = '';
}
if(!isEmpty($data->monto)) { 
$donacion->monto = $data->monto;
} else { 
$donacion->monto = '';
}
if(!isEmpty($data->metodo_pago)) { 
$donacion->metodo_pago = $data->metodo_pago;
} else { 
$donacion->metodo_pago = '';
}
 	$lastInsertedId=$donacion->create();
    // create the donacion
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the donacion, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create donacion","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create donacion. Data is incomplete.","document"=> ""));
}
?>
