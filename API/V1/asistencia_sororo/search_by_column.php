<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/asistencia_sororo.php';
 include_once '../token/validatetoken.php';
// instantiate database and asistencia_sororo object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$asistencia_sororo = new Asistencia_Sororo($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$asistencia_sororo->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$asistencia_sororo->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query asistencia_sororo
$stmt = $asistencia_sororo->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //asistencia_sororo array
    $asistencia_sororo_arr=array();
	$asistencia_sororo_arr["pageno"]=$asistencia_sororo->pageNo;
	$asistencia_sororo_arr["pagesize"]=$asistencia_sororo->no_of_records_per_page;
    $asistencia_sororo_arr["total_count"]=$asistencia_sororo->search_record_count($data,$orAnd);
    $asistencia_sororo_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $asistencia_sororo_item=array(
            
"id_asistencia_sororo" => $id_asistencia_sororo,
"funcion" => html_entity_decode($funcion),
"id_voluntario" => $id_voluntario,
"fecha" => $fecha,
"circulo_sororo" => $circulo_sororo,
"capacitacion" => $capacitacion
        );
 
        array_push($asistencia_sororo_arr["records"], $asistencia_sororo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show asistencia_sororo data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "asistencia_sororo found","document"=> $asistencia_sororo_arr));
    
}else{
 // no asistencia_sororo found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no asistencia_sororo found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No asistencia_sororo found.","document"=> ""));
    
}
 


