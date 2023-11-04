<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/area_voluntariado.php';
 include_once '../token/validatetoken.php';
// instantiate database and area_voluntariado object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$area_voluntariado = new Area_Voluntariado($db);

$area_voluntariado->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$area_voluntariado->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read area_voluntariado will be here

// query area_voluntariado
$stmt = $area_voluntariado->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //area_voluntariado array
    $area_voluntariado_arr=array();
	$area_voluntariado_arr["pageno"]=$area_voluntariado->pageNo;
	$area_voluntariado_arr["pagesize"]=$area_voluntariado->no_of_records_per_page;
    $area_voluntariado_arr["total_count"]=$area_voluntariado->total_record_count();
    $area_voluntariado_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $area_voluntariado_item=array(
            
"id_area_voluntariado" => $id_area_voluntariado,
"nombre" => html_entity_decode($nombre)
        );
 
        array_push($area_voluntariado_arr["records"], $area_voluntariado_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show area_voluntariado data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "area_voluntariado found","document"=> $area_voluntariado_arr));
    
}else{
 // no area_voluntariado found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no area_voluntariado found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No area_voluntariado found.","document"=> ""));
    
}
 


