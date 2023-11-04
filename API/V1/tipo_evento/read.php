<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/tipo_evento.php';
 include_once '../token/validatetoken.php';
// instantiate database and tipo_evento object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tipo_evento = new Tipo_Evento($db);

$tipo_evento->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$tipo_evento->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read tipo_evento will be here

// query tipo_evento
$stmt = $tipo_evento->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //tipo_evento array
    $tipo_evento_arr=array();
	$tipo_evento_arr["pageno"]=$tipo_evento->pageNo;
	$tipo_evento_arr["pagesize"]=$tipo_evento->no_of_records_per_page;
    $tipo_evento_arr["total_count"]=$tipo_evento->total_record_count();
    $tipo_evento_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $tipo_evento_item=array(
            
"id_evento" => $id_evento,
"tipo" => html_entity_decode($tipo),
"activo" => $activo
        );
 
        array_push($tipo_evento_arr["records"], $tipo_evento_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show tipo_evento data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_evento found","document"=> $tipo_evento_arr));
    
}else{
 // no tipo_evento found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no tipo_evento found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No tipo_evento found.","document"=> ""));
    
}
 


