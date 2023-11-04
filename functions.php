<?php




// comentario de prueba desde el Editor de Github

$lazy_load = false;
$lazy_load_scripts = [];



function _title($title = 'Inicio'){
  if (isset($_GET['p'])) {
    $title = ucwords(implode(' ', explode('_', $_GET['p'])));
  }
  $title =  APP_NAME.' - '.$title;
  echo "<title>$title</title>";
}


function _dashboardTitle(){
  $title = 'Dashboard';
  if (isset($_GET['adm'])) {
    $adm = ($_GET['adm']) ? $_GET['adm'] : $title ;
    $title = 'Admin - '.ucwords(implode(' ', explode('_', $adm)));
  }
  echo "<title>$title</title>";
}



function _dashboardCrumb(){
  $title = 'Dashboard';
  if (isset($_GET['adm'])) {
    $adm = ($_GET['adm']) ? $_GET['adm'] : $title ;
    $title = ucwords(implode(' ', explode('_', $adm)));
  }
  echo $title;
}



//Incluye el JS para el framework
function _framework(){
  ?>
  <link rel="stylesheet" href="<?=PATH_ASSETS?>/css/fnon.min.css">
  <script type="text/javascript">
    <?php include(FNON); ?>
  </script>
  <script type="text/javascript">
    <?php include(RAI_FW); ?>
  </script>
  <?php
}


function _sessionData(){
  $ses = ( isset($_SESSION) && isset($_SESSION[SES_OBJ]) ) ? json_encode($_SESSION[SES_OBJ]) : 'false'; ?>
  <script type="text/javascript">
    const g__session = <?=$ses?>;
  </script>
  <?php
}


function _component($cmp, $ext = '.php'){
  if (file_exists(PATH_COMPONENTS.$cmp.$ext)) {
    include(PATH_COMPONENTS.$cmp.$ext);
  }else{
    echo "Component '$cmp$ext' does not exist or is not located in the components folder.";
  }
}


function _adminComponent($cmp, $ext = '.php'){
  if (file_exists(PATH_ADMIN_COMPONENTS.$cmp.$ext)) {
    include(PATH_ADMIN_COMPONENTS.$cmp.$ext);
  }else{
    echo "Component '$cmp$ext' does not exist or is not located in the components folder.";
  }
}


function _pageContent(){
  if (isset($_GET['p']) && file_exists(PATH_PAGES.$_GET['p'].'/'.$_GET['p'].'.php')) {
    include(PATH_PAGES.$_GET['p'].'/'.$_GET['p'].'.php');
  }else{
    include(PATH_PAGES.DEFAULT_PAGE.'/'.DEFAULT_PAGE.'.php');
  }
}

function _pageContentAdmin(){
  if (isset($_GET['adm']) && file_exists('view/admin/'.$_GET['adm'].'/'.$_GET['adm'].'.php')) {
    include('view/admin/'.$_GET['adm'].'/'.$_GET['adm'].'.php');
  }else{
    include('view/admin/main/main.php');
  }
}


function _pageScript(){
  if (isset($_GET['p']) && file_exists(PATH_PAGES.$_GET['p'].'/'.$_GET['p'].SCRIPT_EXT)) {
    ?>
    <script type="text/javascript">
      <?php include(PATH_PAGES.$_GET['p'].'/'.$_GET['p'].SCRIPT_EXT); ?>
    </script>
    <?php
  }else{
    ?>
    <script type="text/javascript">
      <?php include(PATH_PAGES.DEFAULT_PAGE.'/'.DEFAULT_PAGE.SCRIPT_EXT); ?>
    </script>
    <?php
  }
}


function _pageScriptAdmin(){
  if (isset($_GET['adm']) && file_exists('view/admin/'.$_GET['adm'].'/'.$_GET['adm'].'.php')) {
    ?>
    <script type="text/javascript">
      <?php include(PATH_ADMIN.$_GET['adm'].'/'.$_GET['adm'].'.js'); ?>
    </script>
    <?php
  }else{
    ?>
    <script type="text/javascript">
      <?php include(PATH_ADMIN.DEFAULT_PAGE.'/'.DEFAULT_PAGE.SCRIPT_EXT); ?>
    </script>
    <?php
  }
}


function _lazyLoad($arr){
  global $lazy_load, $lazy_load_scripts;
  $lazy_load = true;
  $lazy_load_scripts = $arr;
}


function _lazyLoadScript(){
  global $lazy_load_scripts;
  if (isset($_GET['p']) && file_exists(PATH_PAGES.$_GET['p'].'/'.$_GET['p'].'/')) {
    foreach ($lazy_load_scripts as $script) {

      ?>
      <script type="text/javascript">
        <?php include(PATH_PAGES.$_GET['p'].'/'.$_GET['p'].'/'.$script.SCRIPT_EXT); ?>
      </script>
      <?php
    }
  }
}







?>
