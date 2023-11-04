<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/anotacion.php';
 include_once '../token/validatetoken.php';
// instantiate database and anotacion object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$anotacion = new Anotacion($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$anotacion->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$anotacion->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query anotacion
$stmt = $anotacion->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //anotacion array
    $anotacion_arr=array();
	$anotacion_arr["pageno"]=$anotacion->pageNo;
	$anotacion_arr["pagesize"]=$anotacion->no_of_records_per_page;
    $anotacion_arr["total_count"]=$anotacion->search_record_count($data,$orAnd);
    $anotacion_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $anotacion_item=array(
            
"id_anotacion" => $id_anotacion,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"descripcion" => html_entity_decode($descripcion)
        );
 
        array_push($anotacion_arr["records"], $anotacion_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show anotacion data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "anotacion found","document"=> $anotacion_arr));
    
}else{
 // no anotacion found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no anotacion found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No anotacion found.","document"=> ""));
    
}
 


