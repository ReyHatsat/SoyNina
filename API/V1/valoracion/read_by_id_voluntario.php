<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/valoracion.php';
 include_once '../token/validatetoken.php';
// instantiate database and valoracion object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$valoracion = new Valoracion($db);

$valoracion->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$valoracion->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$valoracion->id_voluntario = isset($_GET['id_voluntario']) ? $_GET['id_voluntario'] : die();
// read valoracion will be here

// query valoracion
$stmt = $valoracion->readByid_voluntario();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //valoracion array
    $valoracion_arr=array();
	$valoracion_arr["pageno"]=$valoracion->pageNo;
	$valoracion_arr["pagesize"]=$valoracion->no_of_records_per_page;
    $valoracion_arr["total_count"]=$valoracion->total_record_count();
    $valoracion_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $valoracion_item=array(
            
"id_valoracion" => $id_valoracion,
"funcion" => html_entity_decode($funcion),
"id_voluntario" => $id_voluntario,
"nombre" => html_entity_decode($nombre),
"rubro" => $rubro,
"funcion" => html_entity_decode($funcion),
"activo" => $activo
        );
 
        array_push($valoracion_arr["records"], $valoracion_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show valoracion data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "valoracion found","document"=> $valoracion_arr));
    
}else{
 // no valoracion found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no valoracion found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No valoracion found.","document"=> ""));
    
}
 


