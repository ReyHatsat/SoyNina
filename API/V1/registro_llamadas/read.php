<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/registro_llamadas.php';
 include_once '../token/validatetoken.php';
// instantiate database and registro_llamadas object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$registro_llamadas = new Registro_Llamadas($db);

$registro_llamadas->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$registro_llamadas->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read registro_llamadas will be here

// query registro_llamadas
$stmt = $registro_llamadas->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //registro_llamadas array
    $registro_llamadas_arr=array();
	$registro_llamadas_arr["pageno"]=$registro_llamadas->pageNo;
	$registro_llamadas_arr["pagesize"]=$registro_llamadas->no_of_records_per_page;
    $registro_llamadas_arr["total_count"]=$registro_llamadas->total_record_count();
    $registro_llamadas_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $registro_llamadas_item=array(
            
"id_registro" => $id_registro,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"fecha" => $fecha,
"estado" => $estado
        );
 
        array_push($registro_llamadas_arr["records"], $registro_llamadas_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show registro_llamadas data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "registro_llamadas found","document"=> $registro_llamadas_arr));
    
}else{
 // no registro_llamadas found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no registro_llamadas found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No registro_llamadas found.","document"=> ""));
    
}
 


