<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/contacto_emergencia.php';
 include_once '../token/validatetoken.php';
// instantiate database and contacto_emergencia object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$contacto_emergencia = new Contacto_Emergencia($db);

$contacto_emergencia->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$contacto_emergencia->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read contacto_emergencia will be here

// query contacto_emergencia
$stmt = $contacto_emergencia->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //contacto_emergencia array
    $contacto_emergencia_arr=array();
	$contacto_emergencia_arr["pageno"]=$contacto_emergencia->pageNo;
	$contacto_emergencia_arr["pagesize"]=$contacto_emergencia->no_of_records_per_page;
    $contacto_emergencia_arr["total_count"]=$contacto_emergencia->total_record_count();
    $contacto_emergencia_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $contacto_emergencia_item=array(
            
"id_contacto_emergencia" => $id_contacto_emergencia,
"nombre" => $nombre,
"id_parentesco" => $id_parentesco,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"foto" => html_entity_decode($foto),
"id_contacto" => $id_contacto
        );
 
        array_push($contacto_emergencia_arr["records"], $contacto_emergencia_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show contacto_emergencia data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "contacto_emergencia found","document"=> $contacto_emergencia_arr));
    
}else{
 // no contacto_emergencia found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no contacto_emergencia found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No contacto_emergencia found.","document"=> ""));
    
}
 


