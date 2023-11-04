<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/equipo.php';
 include_once '../token/validatetoken.php';
// instantiate database and equipo object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$equipo = new Equipo($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$equipo->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$equipo->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query equipo
$stmt = $equipo->search($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //equipo array
    $equipo_arr=array();
	$equipo_arr["pageno"]=$equipo->pageNo;
	$equipo_arr["pagesize"]=$equipo->no_of_records_per_page;
    $equipo_arr["total_count"]=$equipo->total_record_count();
    $equipo_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $equipo_item=array(
            
"id_equipo" => $id_equipo,
"nombre" => html_entity_decode($nombre)
        );
 
        array_push($equipo_arr["records"], $equipo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show equipo data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "equipo found","document"=> $equipo_arr));
    
}else{
 // no equipo found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no equipo found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No equipo found.","document"=> ""));
    
}
 


