<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/tipo_detalle.php';
 include_once '../token/validatetoken.php';
// instantiate database and tipo_detalle object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tipo_detalle = new Tipo_Detalle($db);

$tipo_detalle->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$tipo_detalle->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read tipo_detalle will be here

// query tipo_detalle
$stmt = $tipo_detalle->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //tipo_detalle array
    $tipo_detalle_arr=array();
	$tipo_detalle_arr["pageno"]=$tipo_detalle->pageNo;
	$tipo_detalle_arr["pagesize"]=$tipo_detalle->no_of_records_per_page;
    $tipo_detalle_arr["total_count"]=$tipo_detalle->total_record_count();
    $tipo_detalle_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $tipo_detalle_item=array(
            
"id_tipo_detalle" => $id_tipo_detalle,
"tipo_detalle" => $tipo_detalle,
"activo" => $activo
        );
 
        array_push($tipo_detalle_arr["records"], $tipo_detalle_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show tipo_detalle data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_detalle found","document"=> $tipo_detalle_arr));
    
}else{
 // no tipo_detalle found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no tipo_detalle found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No tipo_detalle found.","document"=> ""));
    
}
 


