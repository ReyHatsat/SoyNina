<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/donacion.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare donacion object
$donacion = new Donacion($db);
 
// set ID property of record to read
$donacion->id_donacion = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of donacion to be edited
$donacion->readOne();
 
if($donacion->id_donacion!=null){
    // create array
    $donacion_arr = array(
        
"id_donacion" => $donacion->id_donacion,
"tipo_moneda" => html_entity_decode($donacion->tipo_moneda),
"tipo_moneda" => $donacion->tipo_moneda,
"foto" => html_entity_decode($donacion->foto),
"id_persona" => $donacion->id_persona,
"monto" => $donacion->monto,
"metodo_pago" => html_entity_decode($donacion->metodo_pago)
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "donacion found","document"=> $donacion_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user donacion does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "donacion does not exist.","document"=> ""));
}
?>
