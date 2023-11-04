<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_ocupacion.php';
 include_once '../token/validatetoken.php';
// instantiate database and tipo_ocupacion object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tipo_ocupacion = new Tipo_Ocupacion($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$tipo_ocupacion->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$tipo_ocupacion->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query tipo_ocupacion
$stmt = $tipo_ocupacion->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //tipo_ocupacion array
    $tipo_ocupacion_arr=array();
	$tipo_ocupacion_arr["pageno"]=$tipo_ocupacion->pageNo;
	$tipo_ocupacion_arr["pagesize"]=$tipo_ocupacion->no_of_records_per_page;
    $tipo_ocupacion_arr["total_count"]=$tipo_ocupacion->search_record_count($data,$orAnd);
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
 


