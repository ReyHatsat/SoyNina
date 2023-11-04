<?php
session_start();


// if there is no OTP set, redirect to the main page
if (!isset($_GET['otp'])) {
  header('Location:../../../');
}



//include the database files
include_once '../../../Carmiol_API/config/database.php';
include_once '../../../Carmiol_API/objects/entidad.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare entidad object
$entidad = new Entidad($db);

// set ID property of record to read
$entidad->login_salt = isset($_GET['otp']) ? $_GET['otp'] : die();
$entidad->id_entidad = isset($_GET['stat']) ? $_GET['stat'] : die();

// read the details of entidad to be edited
$entidad->readOneSalt();

if($entidad->id_entidad != null){

    $entidad->id_estado = 1;
    $entidad->update();

    header('Location:../../../?p=login&e-confirmed');

}else{
    // set response code - 404 Not found
    header('Location:../../../?invalid');
}




?>
