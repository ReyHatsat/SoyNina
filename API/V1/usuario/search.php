<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/usuario.php';
 include_once '../token/validatetoken.php';
// instantiate database and usuario object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$usuario = new Usuario($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$usuario->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$usuario->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query usuario
$stmt = $usuario->search($searchKey);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //usuario array
    $usuario_arr=array();
	$usuario_arr["pageno"]=$usuario->pageNo;
	$usuario_arr["pagesize"]=$usuario->no_of_records_per_page;
    $usuario_arr["total_count"]=$usuario->total_record_count();
    $usuario_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $usuario_item=array(
            
"id_usuario" => $id_usuario,
"foto" => html_entity_decode($foto),
"id_persona" => $id_persona,
"nombre_usuario" => $nombre_usuario,
"login_salt" => html_entity_decode($login_salt),
"login_password" => html_entity_decode($login_password)
        );
 
        array_push($usuario_arr["records"], $usuario_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show usuario data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "usuario found","document"=> $usuario_arr));
    
}else{
 // no usuario found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no usuario found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No usuario found.","document"=> ""));
    
}
 


