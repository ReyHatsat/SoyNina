<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asesor.php';
 include_once '../token/validatetoken.php';
// instantiate database and asesor object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$asesor = new Asesor($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$asesor->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$asesor->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query asesor
$stmt = $asesor->search($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //asesor array
    $asesor_arr=array();
	$asesor_arr["pageno"]=$asesor->pageNo;
	$asesor_arr["pagesize"]=$asesor->no_of_records_per_page;
    $asesor_arr["total_count"]=$asesor->total_record_count();
    $asesor_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $asesor_item=array(
            
"id_asesor" => $id_asesor,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"funcion" => html_entity_decode($funcion),
"fecha_ingreso" => $fecha_ingreso
        );
 
        array_push($asesor_arr["records"], $asesor_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show asesor data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "asesor found","document"=> $asesor_arr));
    
}else{
 // no asesor found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no asesor found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No asesor found.","document"=> ""));
    
}
 


