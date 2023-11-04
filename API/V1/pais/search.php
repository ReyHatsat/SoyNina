<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/pais.php';
 include_once '../token/validatetoken.php';
// instantiate database and pais object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$pais = new Pais($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$pais->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$pais->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query pais
$stmt = $pais->search($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //pais array
    $pais_arr=array();
	$pais_arr["pageno"]=$pais->pageNo;
	$pais_arr["pagesize"]=$pais->no_of_records_per_page;
    $pais_arr["total_count"]=$pais->total_record_count();
    $pais_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $pais_item=array(
            
"id_pais" => $id_pais,
"nombre" => $nombre,
"nacionalidad" => $nacionalidad,
"activo" => $activo
        );
 
        array_push($pais_arr["records"], $pais_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show pais data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "pais found","document"=> $pais_arr));
    
}else{
 // no pais found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no pais found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No pais found.","document"=> ""));
    
}
 


