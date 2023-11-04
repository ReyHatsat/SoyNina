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
 
// instantiate usuario object
include_once '../objects/usuario.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$usuario = new Usuario($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->id_persona)
&&!isEmpty($data->nombre_usuario)
&&!isEmpty($data->login_password)){
 
    // set usuario property values
    if(!isEmpty($data->id_persona)) { 
        $usuario->id_persona = $data->id_persona;
    } else { 
        $usuario->id_persona = '';
    }
    if(!isEmpty($data->nombre_usuario)) { 
        $usuario->nombre_usuario = $data->nombre_usuario;
    } else { 
        $usuario->nombre_usuario = '';
    }
    if(!isEmpty($data->login_password)) { 
        $usuario->login_password = $data->login_password;
    } else { 
        $usuario->login_password = '';
    }


    $usuario->login_salt = $usuario->genSalt();
    $usuario->login_password = $usuario->hashPassword_Salt( $usuario->login_password, $usuario->login_salt );
    


 	$lastInsertedId=$usuario->create();
    // create the usuario
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the usuario, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create usuario","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create usuario. Data is incomplete.","document"=> ""));
}
?>
