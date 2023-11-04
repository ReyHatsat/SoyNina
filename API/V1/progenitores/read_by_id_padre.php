<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/progenitores.php';
 include_once '../token/validatetoken.php';
// instantiate database and progenitores object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$progenitores = new Progenitores($db);

$progenitores->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$progenitores->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$progenitores->id_padre = isset($_GET['id_padre']) ? $_GET['id_padre'] : die();
// read progenitores will be here

// query progenitores
$stmt = $progenitores->readByid_padre();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //progenitores array
    $progenitores_arr=array();
	$progenitores_arr["pageno"]=$progenitores->pageNo;
	$progenitores_arr["pagesize"]=$progenitores->no_of_records_per_page;
    $progenitores_arr["total_count"]=$progenitores->total_record_count();
    $progenitores_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $progenitores_item=array(
            
"id_progenitores" => $id_progenitores,
"tipo_convivencia" => $tipo_convivencia,
"id_tipo_convivencia" => $id_tipo_convivencia,
"foto" => html_entity_decode($foto),
"id_madre" => $id_madre,
"foto" => html_entity_decode($foto),
"id_padre" => $id_padre
        );
 
        array_push($progenitores_arr["records"], $progenitores_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show progenitores data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "progenitores found","document"=> $progenitores_arr));
    
}else{
 // no progenitores found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no progenitores found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No progenitores found.","document"=> ""));
    
}
 


