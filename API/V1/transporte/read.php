<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/transporte.php';
 include_once '../token/validatetoken.php';
// instantiate database and transporte object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$transporte = new Transporte($db);

$transporte->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$transporte->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read transporte will be here

// query transporte
$stmt = $transporte->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //transporte array
    $transporte_arr=array();
	$transporte_arr["pageno"]=$transporte->pageNo;
	$transporte_arr["pagesize"]=$transporte->no_of_records_per_page;
    $transporte_arr["total_count"]=$transporte->total_record_count();
    $transporte_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $transporte_item=array(
            
"id_transporte" => $id_transporte,
"tipo_transporte" => $tipo_transporte,
"activo" => $activo
        );
 
        array_push($transporte_arr["records"], $transporte_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show transporte data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "transporte found","document"=> $transporte_arr));
    
}else{
 // no transporte found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no transporte found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No transporte found.","document"=> ""));
    
}
 


