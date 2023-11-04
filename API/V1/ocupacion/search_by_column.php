<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/ocupacion.php';
 include_once '../token/validatetoken.php';
// instantiate database and ocupacion object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$ocupacion = new Ocupacion($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$ocupacion->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$ocupacion->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query ocupacion
$stmt = $ocupacion->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //ocupacion array
    $ocupacion_arr=array();
	$ocupacion_arr["pageno"]=$ocupacion->pageNo;
	$ocupacion_arr["pagesize"]=$ocupacion->no_of_records_per_page;
    $ocupacion_arr["total_count"]=$ocupacion->search_record_count($data,$orAnd);
    $ocupacion_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $ocupacion_item=array(
            
"id_ocupacion" => $id_ocupacion,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"tipo_ocupacion" => $tipo_ocupacion,
"id_tipo_ocupacion" => $id_tipo_ocupacion,
"lugar_ocupacion" => html_entity_decode($lugar_ocupacion),
"puesto" => $puesto,
"activo" => $activo
        );
 
        array_push($ocupacion_arr["records"], $ocupacion_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show ocupacion data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "ocupacion found","document"=> $ocupacion_arr));
    
}else{
 // no ocupacion found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no ocupacion found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No ocupacion found.","document"=> ""));
    
}
 


