<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/parentesco.php';
 include_once '../token/validatetoken.php';
// instantiate database and parentesco object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$parentesco = new Parentesco($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$parentesco->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$parentesco->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query parentesco
$stmt = $parentesco->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //parentesco array
    $parentesco_arr=array();
	$parentesco_arr["pageno"]=$parentesco->pageNo;
	$parentesco_arr["pagesize"]=$parentesco->no_of_records_per_page;
    $parentesco_arr["total_count"]=$parentesco->search_record_count($data,$orAnd);
    $parentesco_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $parentesco_item=array(
            
"id_parentesco" => $id_parentesco,
"nombre" => $nombre,
"activo" => $activo
        );
 
        array_push($parentesco_arr["records"], $parentesco_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show parentesco data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "parentesco found","document"=> $parentesco_arr));
    
}else{
 // no parentesco found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no parentesco found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No parentesco found.","document"=> ""));
    
}
 


