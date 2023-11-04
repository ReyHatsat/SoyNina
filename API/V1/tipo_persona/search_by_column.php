<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/tipo_persona.php';
 include_once '../token/validatetoken.php';
// instantiate database and tipo_persona object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tipo_persona = new Tipo_Persona($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$tipo_persona->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$tipo_persona->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query tipo_persona
$stmt = $tipo_persona->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //tipo_persona array
    $tipo_persona_arr=array();
	$tipo_persona_arr["pageno"]=$tipo_persona->pageNo;
	$tipo_persona_arr["pagesize"]=$tipo_persona->no_of_records_per_page;
    $tipo_persona_arr["total_count"]=$tipo_persona->search_record_count($data,$orAnd);
    $tipo_persona_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $tipo_persona_item=array(
            
"id_tipo_persona" => $id_tipo_persona,
"tipo_persona" => html_entity_decode($tipo_persona)
        );
 
        array_push($tipo_persona_arr["records"], $tipo_persona_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show tipo_persona data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "tipo_persona found","document"=> $tipo_persona_arr));
    
}else{
 // no tipo_persona found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no tipo_persona found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No tipo_persona found.","document"=> ""));
    
}
 


