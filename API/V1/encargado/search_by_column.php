<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/encargado.php';
 include_once '../token/validatetoken.php';
// instantiate database and encargado object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$encargado = new Encargado($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$encargado->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$encargado->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query encargado
$stmt = $encargado->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //encargado array
    $encargado_arr=array();
	$encargado_arr["pageno"]=$encargado->pageNo;
	$encargado_arr["pagesize"]=$encargado->no_of_records_per_page;
    $encargado_arr["total_count"]=$encargado->search_record_count($data,$orAnd);
    $encargado_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $encargado_item=array(
            
"id_encargado" => $id_encargado,
"foto" => html_entity_decode($foto),
"id_nina" => $id_nina,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"nombre" => $nombre,
"id_parentesco" => $id_parentesco,
"relacion_nina" => html_entity_decode($relacion_nina),
"autorizado_recoger" => $autorizado_recoger,
"restriccion_acercamiento" => $restriccion_acercamiento,
"drogadiccion" => $drogadiccion,
"descripcion_drogadiccion" => html_entity_decode($descripcion_drogadiccion),
"privado_libertad" => $privado_libertad,
"descripcion_privado_libertad" => html_entity_decode($descripcion_privado_libertad),
"activo" => $activo
        );
 
        array_push($encargado_arr["records"], $encargado_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show encargado data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "encargado found","document"=> $encargado_arr));
    
}else{
 // no encargado found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no encargado found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No encargado found.","document"=> ""));
    
}
 


