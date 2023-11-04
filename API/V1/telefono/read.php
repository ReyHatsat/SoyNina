<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/telefono.php';
 include_once '../token/validatetoken.php';
// instantiate database and telefono object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$telefono = new Telefono($db);

$telefono->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$telefono->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read telefono will be here

// query telefono
$stmt = $telefono->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //telefono array
    $telefono_arr=array();
	$telefono_arr["pageno"]=$telefono->pageNo;
	$telefono_arr["pagesize"]=$telefono->no_of_records_per_page;
    $telefono_arr["total_count"]=$telefono->total_record_count();
    $telefono_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $telefono_item=array(
            
"id_telefono" => $id_telefono,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"telefono" => $telefono
        );
 
        array_push($telefono_arr["records"], $telefono_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show telefono data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "telefono found","document"=> $telefono_arr));
    
}else{
 // no telefono found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no telefono found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No telefono found.","document"=> ""));
    
}
 


