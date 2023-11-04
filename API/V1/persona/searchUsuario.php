<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/persona.php';
 include_once '../token/validatetoken.php';
// instantiate database and persona object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$persona = new Persona($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$persona->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$persona->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query persona
$stmt = $persona->searchUsuario($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //persona array
    $persona_arr=array();
	$persona_arr["pageno"]=$persona->pageNo;
	$persona_arr["pagesize"]=$persona->no_of_records_per_page;
    $persona_arr["total_count"]=$persona->total_record_count();
    $persona_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $persona_item=array(
            "id_persona" => $id_persona,
            "foto" => html_entity_decode($foto),
            "identificacion" => $identificacion,
            "nombre" => $nombre,
            "primer_apellido" => $primer_apellido,
            "segundo_apellido" => $segundo_apellido,
            "fecha_nacimiento" => $fecha_nacimiento,
            "CV" => html_entity_decode($CV),
            "nombre" => $nombre,
            "id_pais" => $id_pais,
            "nombre" => $nombre,
            "id_club" => $id_club,
            "ingreso_club" => $ingreso_club,
            "tipo_persona" => html_entity_decode($tipo_persona),
            "id_tipo_persona" => $id_tipo_persona,
            "grado_academico" => $grado_academico,
            "id_grado_academico" => $id_grado_academico,
            "activo" => $activo
        );
 
        array_push($persona_arr["records"], $persona_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show persona data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "persona found","document"=> $persona_arr));
    
}else{
 // no persona found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no persona found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No persona found.","document"=> ""));
    
}
 


