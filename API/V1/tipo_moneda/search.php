<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_moneda.php';
 include_once '../token/validatetoken.php';
// instantiate database and tipo_moneda object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tipo_moneda = new Tipo_Moneda($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$tipo_moneda->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$tipo_moneda->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query tipo_moneda
$stmt = $tipo_moneda->search($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //tipo_moneda array
    $tipo_moneda_arr=array();
	$tipo_moneda_arr["pageno"]=$tipo_moneda->pageNo;
	$tipo_moneda_arr["pagesize"]=$tipo_moneda->no_of_records_per_page;
    $tipo_moneda_arr["total_count"]=$tipo_moneda->total_record_count();
    $tipo_moneda_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $tipo_moneda_item=array(
            
"id_tipo_moneda" => $id_tipo_moneda,
"tipo_moneda" => html_entity_decode($tipo_moneda),
"activo" => $activo
        );
 
        array_push($tipo_moneda_arr["records"], $tipo_moneda_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show tipo_moneda data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_moneda found","document"=> $tipo_moneda_arr));
    
}else{
 // no tipo_moneda found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no tipo_moneda found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No tipo_moneda found.","document"=> ""));
    
}
 


