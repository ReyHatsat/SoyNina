<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/pais.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare pais object
$pais = new Pais($db);
 
// set ID property of record to read
$pais->id_pais = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of pais to be edited
$pais->readOne();
 
if($pais->id_pais!=null){
    // create array
    $pais_arr = array(
        
"id_pais" => $pais->id_pais,
"nombre" => $pais->nombre,
"nacionalidad" => $pais->nacionalidad,
"activo" => $pais->activo
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "pais found","document"=> $pais_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user pais does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "pais does not exist.","document"=> ""));
}
?>
