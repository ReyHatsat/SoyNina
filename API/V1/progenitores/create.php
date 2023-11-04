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
 
// instantiate progenitores object
include_once '../objects/progenitores.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$progenitores = new Progenitores($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_tipo_convivencia)
&&!isEmpty($data->id_madre)
&&!isEmpty($data->id_padre)){
 
    // set progenitores property values
	 
if(!isEmpty($data->id_tipo_convivencia)) { 
$progenitores->id_tipo_convivencia = $data->id_tipo_convivencia;
} else { 
$progenitores->id_tipo_convivencia = '';
}
if(!isEmpty($data->id_madre)) { 
$progenitores->id_madre = $data->id_madre;
} else { 
$progenitores->id_madre = '';
}
if(!isEmpty($data->id_padre)) { 
$progenitores->id_padre = $data->id_padre;
} else { 
$progenitores->id_padre = '';
}
 	$lastInsertedId=$progenitores->create();
    // create the progenitores
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the progenitores, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create progenitores","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create progenitores. Data is incomplete.","document"=> ""));
}
?>
