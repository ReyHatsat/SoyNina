<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/grado.php';
 include_once '../token/validatetoken.php';
// instantiate database and grado object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$grado = new Grado($db);

$grado->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$grado->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read grado will be here

// query grado
$stmt = $grado->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //grado array
    $grado_arr=array();
	$grado_arr["pageno"]=$grado->pageNo;
	$grado_arr["pagesize"]=$grado->no_of_records_per_page;
    $grado_arr["total_count"]=$grado->total_record_count();
    $grado_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $grado_item=array(
            
"id_grado" => $id_grado,
"grado" => $grado,
"activo" => $activo
        );
 
        array_push($grado_arr["records"], $grado_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show grado data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "grado found","document"=> $grado_arr));
    
}else{
 // no grado found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no grado found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No grado found.","document"=> ""));
    
}
 


