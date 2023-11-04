<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/voluntario.php';
 include_once '../token/validatetoken.php';
// instantiate database and voluntario object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$voluntario = new Voluntario($db);

$voluntario->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$voluntario->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read voluntario will be here

// query voluntario
$stmt = $voluntario->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //voluntario array
    $voluntario_arr=array();
	$voluntario_arr["pageno"]=$voluntario->pageNo;
	$voluntario_arr["pagesize"]=$voluntario->no_of_records_per_page;
    $voluntario_arr["total_count"]=$voluntario->total_record_count();
    $voluntario_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $voluntario_item=array(
            
"id_voluntario" => $id_voluntario,
"nombre" => html_entity_decode($nombre),
"area_voluntariado" => $area_voluntariado,
"funcion" => html_entity_decode($funcion),
"fecha_ingreso" => $fecha_ingreso,
"estado" => $estado,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona
        );
 
        array_push($voluntario_arr["records"], $voluntario_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show voluntario data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "voluntario found","document"=> $voluntario_arr));
    
}else{
 // no voluntario found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no voluntario found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No voluntario found.","document"=> ""));
    
}
 


