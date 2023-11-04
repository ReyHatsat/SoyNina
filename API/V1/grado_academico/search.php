<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/grado_academico.php';
 include_once '../token/validatetoken.php';
// instantiate database and grado_academico object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$grado_academico = new Grado_Academico($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$grado_academico->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$grado_academico->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query grado_academico
$stmt = $grado_academico->search($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //grado_academico array
    $grado_academico_arr=array();
	$grado_academico_arr["pageno"]=$grado_academico->pageNo;
	$grado_academico_arr["pagesize"]=$grado_academico->no_of_records_per_page;
    $grado_academico_arr["total_count"]=$grado_academico->total_record_count();
    $grado_academico_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $grado_academico_item=array(
            
"id_grado_academico" => $id_grado_academico,
"grado_academico" => $grado_academico,
"activo" => $activo
        );
 
        array_push($grado_academico_arr["records"], $grado_academico_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show grado_academico data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "grado_academico found","document"=> $grado_academico_arr));
    
}else{
 // no grado_academico found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no grado_academico found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No grado_academico found.","document"=> ""));
    
}
 


