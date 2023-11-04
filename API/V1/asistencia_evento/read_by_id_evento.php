<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asistencia_evento.php';
 include_once '../token/validatetoken.php';
// instantiate database and asistencia_evento object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$asistencia_evento = new Asistencia_Evento($db);

$asistencia_evento->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$asistencia_evento->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$asistencia_evento->id_evento = isset($_GET['id_evento']) ? $_GET['id_evento'] : die();
// read asistencia_evento will be here

// query asistencia_evento
$stmt = $asistencia_evento->readByid_evento();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //asistencia_evento array
    $asistencia_evento_arr=array();
	$asistencia_evento_arr["pageno"]=$asistencia_evento->pageNo;
	$asistencia_evento_arr["pagesize"]=$asistencia_evento->no_of_records_per_page;
    $asistencia_evento_arr["total_count"]=$asistencia_evento->total_record_count();
    $asistencia_evento_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $asistencia_evento_item=array(
            
"id_asistencia_evento" => $id_asistencia_evento,
"nombre" => html_entity_decode($nombre),
"id_evento" => $id_evento,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"modalidad" => html_entity_decode($modalidad),
"asistencia" => $asistencia,
"fecha" => $fecha
        );
 
        array_push($asistencia_evento_arr["records"], $asistencia_evento_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show asistencia_evento data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "asistencia_evento found","document"=> $asistencia_evento_arr));
    
}else{
 // no asistencia_evento found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no asistencia_evento found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No asistencia_evento found.","document"=> ""));
    
}
 


