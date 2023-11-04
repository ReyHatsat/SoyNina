<?php

// ENABLE / DISABLE WARNINGS and ERRORS
DEFINE('ERRORS', false);


//DEVELOPMENT INFORMATION
define('ENV', 'Development'); // Production
define('VERSION','0.0.1');
define('DEV_CONTACT', [
  'contact_name' => 'Sergio Chang Muñoz',
  'contact_email' => 'sergio@rai.cr'
]);



// ********************************************************************



//COMPANY / APPLICATION INFORMATION
define('APP_NAME', 'Soy Niña CRM');
//define('APP_')


// ********************************************************************



// PATH CONFIGURATION
define('PATH_MODULE', 'module/');
define('PATH_VIEW', 'view/');
define('PATH_CONTROLLER', 'controller/');

//VIEWS FOLDERS
define('PATH_PAGES', PATH_VIEW.'pages/');
define('PATH_ADMIN', PATH_VIEW.'admin/');

//ASSETS FOLDERS
define('PATH_ASSETS', PATH_VIEW.'assets/');
define('PATH_ADMIN_ASSSETS', PATH_VIEW.'admin_assets/');

//REUSABLE COMPONENTS
define('PATH_COMPONENTS', PATH_VIEW.'components/');
define('PATH_ADMIN_COMPONENTS', PATH_VIEW.'admin_components/');

//GLOBAL FOLDERS
define('PATH_ACTIONS', 'actions/');
define('PATH_SETUP', PATH_CONTROLLER.'setup/');

//INITIALIZE VALIDATIONS
define('SESSION_VALIDATION', PATH_SETUP.'session_validation.php');
define('VIEW_VALIDATION', PATH_SETUP.'view_validation.php');

//FRAMEWORK DEFINITIONS
define('PATH_RAI_FW', PATH_VIEW.'framework/');
define('PATH_RAI_FN', 'main.js');
define('RAI_FW', PATH_RAI_FW.PATH_RAI_FN);
define('FNON', PATH_ASSETS.'js/fnon.min.js');


//API CONFIGURATION AND KEYS
define('PATH_API', 'API/V1/');
define('PATH_TOKEN', PATH_API.'token/generate.php');
define('GENERAL', 'ce4a40cb972dc5bd524be63cd8ebf664');
define('SPECIFIC', 'd1427c4a90bc9cb6e3ca69ff7754f105');



// ********************************************************************



//LOCATION(s) & PAGE(s) CONFIGURATION
define('VIEW_CLIENT', PATH_PAGES.'panel.php');
define('VIEW_ADMIN', PATH_ADMIN.'admin_panel.php');
define('START_PAGE', 'landing.php');
define('DEFAULT_PAGE', 'main');
define('PAGE_EXT', '.php');
define('SCRIPT_EXT', '.js');


//ACCESS TO PAGES
define('LOGIN', true);
define('PANEL', true);
define('page_access', true);



// ********************************************************************



//Access Configuration
define('DBencoding','utf8');
define('allow-customer-login',true);
define('allow-admin-login',true);
define('cookies_notice', false);
define('variable_langs', false);
define('lang_folder', PATH_VIEW.'langs/');



// ********************************************************************



//CLIENT DATA AND INDEXING
define('CLIENT_IP' , $_SERVER['REMOTE_ADDR']);



// ********************************************************************



//BEHAVIOUR VARIABLES
define('LOGOUT', 'logout');
define('SES_OBJ', 'entidad');
define('GET_ADM', 'administrator');
define('ADM_ACC', 'is_admin');
define('ADM_VALID', 'is_admin');
define('EXIT_ADM', 'exit_administrator');
define('ADM_VARIABLE', 'ADMIN');
define('ADM_REDIR', 'Refresh:0; url=./?adm');


// ENABLE/DISABLE ERRORS
if(!ERRORS){
  error_reporting(0);
}
