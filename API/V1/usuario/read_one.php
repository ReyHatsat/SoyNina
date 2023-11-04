<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/usuario.php';
include_once '../token/validatetoken.php';


// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare usuario object
$usuario = new Usuario($db);
 
// set ID property of record to read
$usuario->id_usuario = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of usuario to be edited
$usuario->readOne();
 
if($usuario->id_usuario!=null){
    // create array
    $usuario_arr = array(
        "id_usuario" => $usuario->id_usuario,
        "foto" => html_entity_decode($usuario->foto),
        "id_persona" => $usuario->id_persona,
        "nombre_usuario" => $usuario->nombre_usuario,
        "login_salt" => html_entity_decode($usuario->login_salt),
        "login_password" => html_entity_decode($usuario->login_password)
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "usuario found","document"=> $usuario_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user usuario does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "usuario does not exist.","document"=> ""));
}
?>
