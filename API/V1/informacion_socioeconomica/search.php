<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/informacion_socioeconomica.php';
 include_once '../token/validatetoken.php';
// instantiate database and informacion_socioeconomica object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$informacion_socioeconomica = new Informacion_Socioeconomica($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$informacion_socioeconomica->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$informacion_socioeconomica->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query informacion_socioeconomica
$stmt = $informacion_socioeconomica->search($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //informacion_socioeconomica array
    $informacion_socioeconomica_arr=array();
	$informacion_socioeconomica_arr["pageno"]=$informacion_socioeconomica->pageNo;
	$informacion_socioeconomica_arr["pagesize"]=$informacion_socioeconomica->no_of_records_per_page;
    $informacion_socioeconomica_arr["total_count"]=$informacion_socioeconomica->total_record_count();
    $informacion_socioeconomica_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $informacion_socioeconomica_item=array(
            
"id_informacion_socioeconomica" => $id_informacion_socioeconomica,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"personas_laborales" => $personas_laborales,
"ingreso_mensual_aproximado" => $ingreso_mensual_aproximado,
"descripcion_vivienda" => html_entity_decode($descripcion_vivienda),
"comparte_cuarto" => $comparte_cuarto,
"foto" => html_entity_decode($foto),
"id_comparte_cuarto" => $id_comparte_cuarto,
"comparte_cama" => $comparte_cama,
"foto" => html_entity_decode($foto),
"id_comparte_cama" => $id_comparte_cama
        );
 
        array_push($informacion_socioeconomica_arr["records"], $informacion_socioeconomica_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show informacion_socioeconomica data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "informacion_socioeconomica found","document"=> $informacion_socioeconomica_arr));
    
}else{
 // no informacion_socioeconomica found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no informacion_socioeconomica found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No informacion_socioeconomica found.","document"=> ""));
    
}
 


