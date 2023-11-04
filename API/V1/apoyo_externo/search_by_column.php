<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/apoyo_externo.php';
 include_once '../token/validatetoken.php';
// instantiate database and apoyo_externo object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$apoyo_externo = new Apoyo_Externo($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$apoyo_externo->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$apoyo_externo->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query apoyo_externo
$stmt = $apoyo_externo->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //apoyo_externo array
    $apoyo_externo_arr=array();
	$apoyo_externo_arr["pageno"]=$apoyo_externo->pageNo;
	$apoyo_externo_arr["pagesize"]=$apoyo_externo->no_of_records_per_page;
    $apoyo_externo_arr["total_count"]=$apoyo_externo->search_record_count($data,$orAnd);
    $apoyo_externo_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $apoyo_externo_item=array(
            
"id_apoyo_externo" => $id_apoyo_externo,
"institucion" => $institucion,
"activo" => $activo
        );
 
        array_push($apoyo_externo_arr["records"], $apoyo_externo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show apoyo_externo data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "apoyo_externo found","document"=> $apoyo_externo_arr));
    
}else{
 // no apoyo_externo found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no apoyo_externo found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No apoyo_externo found.","document"=> ""));
    
}
 


