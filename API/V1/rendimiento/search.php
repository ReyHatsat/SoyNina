<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/rendimiento.php';
 include_once '../token/validatetoken.php';
// instantiate database and rendimiento object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$rendimiento = new Rendimiento($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$rendimiento->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$rendimiento->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query rendimiento
$stmt = $rendimiento->search($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //rendimiento array
    $rendimiento_arr=array();
	$rendimiento_arr["pageno"]=$rendimiento->pageNo;
	$rendimiento_arr["pagesize"]=$rendimiento->no_of_records_per_page;
    $rendimiento_arr["total_count"]=$rendimiento->total_record_count();
    $rendimiento_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $rendimiento_item=array(
            
"id_rendimiento" => $id_rendimiento,
"rendimiento" => $rendimiento,
"activo" => $activo
        );
 
        array_push($rendimiento_arr["records"], $rendimiento_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show rendimiento data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "rendimiento found","document"=> $rendimiento_arr));
    
}else{
 // no rendimiento found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no rendimiento found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No rendimiento found.","document"=> ""));
    
}
 


