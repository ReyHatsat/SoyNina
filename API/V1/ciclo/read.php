<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/ciclo.php';
 include_once '../token/validatetoken.php';
// instantiate database and ciclo object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$ciclo = new Ciclo($db);

$ciclo->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$ciclo->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read ciclo will be here

// query ciclo
$stmt = $ciclo->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //ciclo array
    $ciclo_arr=array();
	$ciclo_arr["pageno"]=$ciclo->pageNo;
	$ciclo_arr["pagesize"]=$ciclo->no_of_records_per_page;
    $ciclo_arr["total_count"]=$ciclo->total_record_count();
    $ciclo_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $ciclo_item=array(
            
"id_ciclo" => $id_ciclo,
"nombre" => $nombre,
"activo" => $activo
        );
 
        array_push($ciclo_arr["records"], $ciclo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show ciclo data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "ciclo found","document"=> $ciclo_arr));
    
}else{
 // no ciclo found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no ciclo found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No ciclo found.","document"=> ""));
    
}
 


