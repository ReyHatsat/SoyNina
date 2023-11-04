<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/detalle_importante.php';
 include_once '../token/validatetoken.php';
// instantiate database and detalle_importante object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$detalle_importante = new Detalle_Importante($db);

$detalle_importante->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$detalle_importante->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$detalle_importante->id_persona = isset($_GET['id_persona']) ? $_GET['id_persona'] : die();
// read detalle_importante will be here

// query detalle_importante
$stmt = $detalle_importante->readByid_persona();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //detalle_importante array
    $detalle_importante_arr=array();
	$detalle_importante_arr["pageno"]=$detalle_importante->pageNo;
	$detalle_importante_arr["pagesize"]=$detalle_importante->no_of_records_per_page;
    $detalle_importante_arr["total_count"]=$detalle_importante->total_record_count();
    $detalle_importante_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $detalle_importante_item=array(
            
"id_detalle_importante" => $id_detalle_importante,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"tipo_detalle" => $tipo_detalle,
"id_tipo_detalle" => $id_tipo_detalle,
"detalle" => html_entity_decode($detalle),
"tratamiento" => html_entity_decode($tratamiento),
"activo" => $activo
        );
 
        array_push($detalle_importante_arr["records"], $detalle_importante_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show detalle_importante data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "detalle_importante found","document"=> $detalle_importante_arr));
    
}else{
 // no detalle_importante found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no detalle_importante found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No detalle_importante found.","document"=> ""));
    
}
 


