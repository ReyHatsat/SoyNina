<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/direccion.php';
 include_once '../token/validatetoken.php';
// instantiate database and direccion object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$direccion = new Direccion($db);

$direccion->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$direccion->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$direccion->id_persona = isset($_GET['id_persona']) ? $_GET['id_persona'] : die();
// read direccion will be here

// query direccion
$stmt = $direccion->readByid_persona();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //direccion array
    $direccion_arr=array();
	$direccion_arr["pageno"]=$direccion->pageNo;
	$direccion_arr["pagesize"]=$direccion->no_of_records_per_page;
    $direccion_arr["total_count"]=$direccion->total_record_count();
    $direccion_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $direccion_item=array(
            
"id_direccion" => $id_direccion,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"descripcion" => html_entity_decode($descripcion)
        );
 
        array_push($direccion_arr["records"], $direccion_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show direccion data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "direccion found","document"=> $direccion_arr));
    
}else{
 // no direccion found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no direccion found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No direccion found.","document"=> ""));
    
}
 


