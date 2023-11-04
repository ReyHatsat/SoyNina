<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/rubro.php';
 include_once '../token/validatetoken.php';
// instantiate database and rubro object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$rubro = new Rubro($db);

$rubro->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$rubro->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read rubro will be here

// query rubro
$stmt = $rubro->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //rubro array
    $rubro_arr=array();
	$rubro_arr["pageno"]=$rubro->pageNo;
	$rubro_arr["pagesize"]=$rubro->no_of_records_per_page;
    $rubro_arr["total_count"]=$rubro->total_record_count();
    $rubro_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $rubro_item=array(
            
"id_rubro" => $id_rubro,
"nombre" => html_entity_decode($nombre)
        );
 
        array_push($rubro_arr["records"], $rubro_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show rubro data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "rubro found","document"=> $rubro_arr));
    
}else{
 // no rubro found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no rubro found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No rubro found.","document"=> ""));
    
}
 


