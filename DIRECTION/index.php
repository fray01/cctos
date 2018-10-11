<?php 
session_start();
require '../classes/WebSiteController.php';
WebSiteController::requiredClasses('../');
define('DIRECTORY', 'DIRECTION');
define('DEFAULT_PAGE', 'direction');
define('ERROR_PAGE', 'notfound');
define('DEFAULT_TEMPLATE', 'default');
define('CHART_TEMPLATE', 'chart');
define('BLANK', 'blank');
define('DIR_TEMPLATES', 'includes/templates/');
define('DIR_PAGES', 'includes/pages/');
$allowedPages = parse_ini_file("includes/conf.ini", true);

$page = isset($_GET['p'])? $_GET['p'] : DEFAULT_PAGE;
if (isset($allowedPages[$page])){
}
else {
$page = ERROR_PAGE;
}
	$controller = new WebSiteController();
        $controller->checkLogin(DIRECTORY,'../');
        $controller->logout(); 
	$controller->displayPage($page, $allowedPages[$page]['template']);
?>