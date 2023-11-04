<?php

session_start();

require_once('../config.php');


$_SESSION[SES_OBJ] = [ ADM_VALID => true ];
$_SESSION[ADM_ACC] = true;


header('Location: ../');



?>
