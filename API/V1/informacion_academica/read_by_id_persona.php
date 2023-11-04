<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/informacion_academica.php';
 include_once '../token/validatetoken.php';
// instantiate database and informacion_academica object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$informacion_academica = new Informacion_Academica($db);

$informacion_academica->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$informacion_academica->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$informacion_academica->id_persona = isset($_GET['id_persona']) ? $_GET['id_persona'] : die();
// read informacion_academica will be here

// query informacion_academica
$stmt = $informacion_academica->readByid_persona();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //informacion_academica array
    $informacion_academica_arr=array();
	$informacion_academica_arr["pageno"]=$informacion_academica->pageNo;
	$informacion_academica_arr["pagesize"]=$informacion_academica->no_of_records_per_page;
    $informacion_academica_arr["total_count"]=$informacion_academica->total_record_count();
    $informacion_academica_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $informacion_academica_item=array(
            
"id_informacion_academica" => $id_informacion_academica,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"centro_academico" => $centro_academico,
"id_centro_academico" => $id_centro_academico,
"grado" => $grado,
"id_grado" => $id_grado,
"rendimiento" => $rendimiento,
"id_rendimiento" => $id_rendimiento,
"institucion" => $institucion,
"id_apoyo_externo" => $id_apoyo_externo,
"repitente" => $repitente,
"grado_repetido" => $grado_repetido,
"beca" => $beca,
"descripcion_beca" => html_entity_decode($descripcion_beca),
"motivacion_escuela" => $motivacion_escuela,
"descripcion_motivacion" => html_entity_decode($descripcion_motivacion),
"traslada_acompanada" => $traslada_acompanada,
"foto" => html_entity_decode($foto),
"id_encargado_traslado" => $id_encargado_traslado,
"tipo_transporte" => $tipo_transporte,
"id_transporte" => $id_transporte,
"estudia_acompanada" => $estudia_acompanada,
"foto" => html_entity_decode($foto),
"id_encargado_estudio" => $id_encargado_estudio,
"trabaja_acompanada" => $trabaja_acompanada,
"foto" => html_entity_decode($foto),
"id_encargado_trabajos" => $id_encargado_trabajos,
"relacion_estudiantes" => html_entity_decode($relacion_estudiantes),
"acontecimiento_importante" => html_entity_decode($acontecimiento_importante),
"actividades" => html_entity_decode($actividades),
"talleres" => html_entity_decode($talleres)
        );
 
        array_push($informacion_academica_arr["records"], $informacion_academica_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show informacion_academica data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "informacion_academica found","document"=> $informacion_academica_arr));
    
}else{
 // no informacion_academica found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no informacion_academica found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No informacion_academica found.","document"=> ""));
    
}
 


