<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/donacion.php';
 include_once '../token/validatetoken.php';
// instantiate database and donacion object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$donacion = new Donacion($db);

$donacion->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$donacion->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$donacion->tipo_moneda = isset($_GET['tipo_moneda']) ? $_GET['tipo_moneda'] : die();
// read donacion will be here

// query donacion
$stmt = $donacion->readBytipo_moneda();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //donacion array
    $donacion_arr=array();
	$donacion_arr["pageno"]=$donacion->pageNo;
	$donacion_arr["pagesize"]=$donacion->no_of_records_per_page;
    $donacion_arr["total_count"]=$donacion->total_record_count();
    $donacion_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $donacion_item=array(
            
"id_donacion" => $id_donacion,
"tipo_moneda" => html_entity_decode($tipo_moneda),
"tipo_moneda" => $tipo_moneda,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"monto" => $monto,
"metodo_pago" => html_entity_decode($metodo_pago)
        );
 
        array_push($donacion_arr["records"], $donacion_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show donacion data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "donacion found","document"=> $donacion_arr));
    
}else{
 // no donacion found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no donacion found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No donacion found.","document"=> ""));
    
}
 


