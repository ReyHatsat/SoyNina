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
 
// instantiate contacto_emergencia object
include_once '../objects/contacto_emergencia.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$contacto_emergencia = new Contacto_Emergencia($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_parentesco)
&&!isEmpty($data->id_persona)
&&!isEmpty($data->id_contacto)){
 
    // set contacto_emergencia property values
	 
if(!isEmpty($data->id_parentesco)) { 
$contacto_emergencia->id_parentesco = $data->id_parentesco;
} else { 
$contacto_emergencia->id_parentesco = '';
}
if(!isEmpty($data->id_persona)) { 
$contacto_emergencia->id_persona = $data->id_persona;
} else { 
$contacto_emergencia->id_persona = '';
}
if(!isEmpty($data->id_contacto)) { 
$contacto_emergencia->id_contacto = $data->id_contacto;
} else { 
$contacto_emergencia->id_contacto = '';
}
 	$lastInsertedId=$contacto_emergencia->create();
    // create the contacto_emergencia
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the contacto_emergencia, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create contacto_emergencia","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create contacto_emergencia. Data is incomplete.","document"=> ""));
}
?>
