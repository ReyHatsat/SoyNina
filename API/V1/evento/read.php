<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/evento.php';
 include_once '../token/validatetoken.php';
// instantiate database and evento object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$evento = new Evento($db);

$evento->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$evento->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read evento will be here

// query evento
$stmt = $evento->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //evento array
    $evento_arr=array();
	$evento_arr["pageno"]=$evento->pageNo;
	$evento_arr["pagesize"]=$evento->no_of_records_per_page;
    $evento_arr["total_count"]=$evento->total_record_count();
    $evento_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $evento_item=array(
            
"id_evento" => $id_evento,
"tipo" => html_entity_decode($tipo),
"id_tipo_evento" => $id_tipo_evento,
"nombre" => html_entity_decode($nombre),
"activo" => $activo
        );
 
        array_push($evento_arr["records"], $evento_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show evento data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "evento found","document"=> $evento_arr));
    
}else{
 // no evento found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no evento found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No evento found.","document"=> ""));
    
}
 


