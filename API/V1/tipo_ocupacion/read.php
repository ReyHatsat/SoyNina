<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/tipo_ocupacion.php';
 include_once '../token/validatetoken.php';
// instantiate database and tipo_ocupacion object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tipo_ocupacion = new Tipo_Ocupacion($db);

$tipo_ocupacion->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$tipo_ocupacion->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read tipo_ocupacion will be here

// query tipo_ocupacion
$stmt = $tipo_ocupacion->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //tipo_ocupacion array
    $tipo_ocupacion_arr=array();
	$tipo_ocupacion_arr["pageno"]=$tipo_ocupacion->pageNo;
	$tipo_ocupacion_arr["pagesize"]=$tipo_ocupacion->no_of_records_per_page;
    $tipo_ocupacion_arr["total_count"]=$tipo_ocupacion->total_record_count();
    $tipo_ocupacion_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $tipo_ocupacion_item=array(
            
"id_tipo_ocupacion" => $id_tipo_ocupacion,
"tipo_ocupacion" => $tipo_ocupacion,
"activo" => $activo
        );
 
        array_push($tipo_ocupacion_arr["records"], $tipo_ocupacion_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show tipo_ocupacion data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_ocupacion found","document"=> $tipo_ocupacion_arr));
    
}else{
 // no tipo_ocupacion found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no tipo_ocupacion found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No tipo_ocupacion found.","document"=> ""));
    
}
 


