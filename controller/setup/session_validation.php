<?php


//Validates if user is not logging out.
if (isset($_GET[LOGOUT])) {
  session_destroy();
  echo" <script>location.replace('./')</script>";
}



//Validate if the user is admin and give access to the view
//!is_null($_SESSION[SES_OBJ][ADM_VALID])
if (isset($_SESSION[SES_OBJ]) && isset($_SESSION[ADM_ACC])) {
  define(ADM_VARIABLE, true);
}



//The user is admin and is accessing into the admin view
if (isset($_GET[ADM_ACC]) && !is_null($_SESSION[SES_OBJ][ADM_VALID])){
  $_SESSION[ADM_ACC] = true;
  header(ADM_REDIR);
  die();
}


//the user is exitting the admin view
if (isset($_GET[EXIT_ADM])) {
  unset($_SESSION[ADM_ACC]);
  header(ADM_REDIR);
  die();
}



//Function to validate the admin view access.
function validateAdminPage(){
    return(
        isset($_SESSION[SES_OBJ])
        && !empty($_SESSION[SES_OBJ])
        && !isset($_GET[LOGOUT])
        && isset($_SESSION[ADM_ACC])
        && !is_null($_SESSION[SES_OBJ][ADM_VALID])
    );
}



//function to validate the client view access.
function validatePage(){
    return(
        isset($_SESSION[SES_OBJ])
        && !empty($_SESSION[SES_OBJ])
        && !isset($_GET[LOGOUT])
    );
}


?>
