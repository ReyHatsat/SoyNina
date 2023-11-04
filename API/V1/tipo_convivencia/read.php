<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/tipo_convivencia.php';
 include_once '../token/validatetoken.php';
// instantiate database and tipo_convivencia object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tipo_convivencia = new Tipo_Convivencia($db);

$tipo_convivencia->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$tipo_convivencia->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read tipo_convivencia will be here

// query tipo_convivencia
$stmt = $tipo_convivencia->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //tipo_convivencia array
    $tipo_convivencia_arr=array();
	$tipo_convivencia_arr["pageno"]=$tipo_convivencia->pageNo;
	$tipo_convivencia_arr["pagesize"]=$tipo_convivencia->no_of_records_per_page;
    $tipo_convivencia_arr["total_count"]=$tipo_convivencia->total_record_count();
    $tipo_convivencia_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $tipo_convivencia_item=array(
            
"id_tipo_convivencia" => $id_tipo_convivencia,
"tipo_convivencia" => $tipo_convivencia,
"activo" => $activo
        );
 
        array_push($tipo_convivencia_arr["records"], $tipo_convivencia_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show tipo_convivencia data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_convivencia found","document"=> $tipo_convivencia_arr));
    
}else{
 // no tipo_convivencia found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no tipo_convivencia found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No tipo_convivencia found.","document"=> ""));
    
}
 


