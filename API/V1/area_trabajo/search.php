<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/area_trabajo.php';
 include_once '../token/validatetoken.php';
// instantiate database and area_trabajo object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$area_trabajo = new Area_Trabajo($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$area_trabajo->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$area_trabajo->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query area_trabajo
$stmt = $area_trabajo->search($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //area_trabajo array
    $area_trabajo_arr=array();
	$area_trabajo_arr["pageno"]=$area_trabajo->pageNo;
	$area_trabajo_arr["pagesize"]=$area_trabajo->no_of_records_per_page;
    $area_trabajo_arr["total_count"]=$area_trabajo->total_record_count();
    $area_trabajo_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $area_trabajo_item=array(
            
"id_area_trabajo" => $id_area_trabajo,
"area_trabajo" => html_entity_decode($area_trabajo),
"activo" => $activo
        );
 
        array_push($area_trabajo_arr["records"], $area_trabajo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show area_trabajo data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "area_trabajo found","document"=> $area_trabajo_arr));
    
}else{
 // no area_trabajo found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no area_trabajo found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No area_trabajo found.","document"=> ""));
    
}
 


