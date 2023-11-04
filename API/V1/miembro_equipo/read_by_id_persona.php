<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/miembro_equipo.php';
 include_once '../token/validatetoken.php';
// instantiate database and miembro_equipo object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$miembro_equipo = new Miembro_Equipo($db);

$miembro_equipo->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$miembro_equipo->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$miembro_equipo->id_persona = isset($_GET['id_persona']) ? $_GET['id_persona'] : die();
// read miembro_equipo will be here

// query miembro_equipo
$stmt = $miembro_equipo->readByid_persona();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //miembro_equipo array
    $miembro_equipo_arr=array();
	$miembro_equipo_arr["pageno"]=$miembro_equipo->pageNo;
	$miembro_equipo_arr["pagesize"]=$miembro_equipo->no_of_records_per_page;
    $miembro_equipo_arr["total_count"]=$miembro_equipo->total_record_count();
    $miembro_equipo_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $miembro_equipo_item=array(
            
"id_miembro_equipo" => $id_miembro_equipo,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"nombre" => html_entity_decode($nombre),
"id_equipo" => $id_equipo,
"area_trabajo" => html_entity_decode($area_trabajo),
"id_area_trabajo" => $id_area_trabajo,
"funcion" => html_entity_decode($funcion),
"fecha_ingreso" => $fecha_ingreso,
"estado" => $estado
        );
 
        array_push($miembro_equipo_arr["records"], $miembro_equipo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show miembro_equipo data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "miembro_equipo found","document"=> $miembro_equipo_arr));
    
}else{
 // no miembro_equipo found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no miembro_equipo found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No miembro_equipo found.","document"=> ""));
    
}
 


