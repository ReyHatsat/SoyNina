<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/club.php';
 include_once '../token/validatetoken.php';
// instantiate database and club object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$club = new Club($db);

$club->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$club->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
// read club will be here

// query club
$stmt = $club->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //club array
    $club_arr=array();
	$club_arr["pageno"]=$club->pageNo;
	$club_arr["pagesize"]=$club->no_of_records_per_page;
    $club_arr["total_count"]=$club->total_record_count();
    $club_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $club_item=array(
            
"id_club" => $id_club,
"nombre" => $nombre,
"id_ciclo" => $id_ciclo,
"nombre" => $nombre,
"codigo" => $codigo,
"activo" => $activo
        );
 
        array_push($club_arr["records"], $club_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show club data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "club found","document"=> $club_arr));
    
}else{
 // no club found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no club found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No club found.","document"=> ""));
    
}
 


