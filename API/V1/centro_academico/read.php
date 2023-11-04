<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/centro_academico.php';
 include_once '../token/validatetoken.php';
// instantiate database and centro_academico object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$centro_academico = new Centro_Academico($db);

$centro_academico->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$centro_academico->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read centro_academico will be here

// query centro_academico
$stmt = $centro_academico->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //centro_academico array
    $centro_academico_arr=array();
	$centro_academico_arr["pageno"]=$centro_academico->pageNo;
	$centro_academico_arr["pagesize"]=$centro_academico->no_of_records_per_page;
    $centro_academico_arr["total_count"]=$centro_academico->total_record_count();
    $centro_academico_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $centro_academico_item=array(
            
"id_centro_academico" => $id_centro_academico,
"centro_academico" => $centro_academico,
"activo" => $activo
        );
 
        array_push($centro_academico_arr["records"], $centro_academico_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show centro_academico data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "centro_academico found","document"=> $centro_academico_arr));
    
}else{
 // no centro_academico found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no centro_academico found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No centro_academico found.","document"=> ""));
    
}
 


