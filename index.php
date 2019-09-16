<?php 
session_start();
require './classes/authenticationController.php';
authenticationController::requiredClasses();

define('DEFAULT_PAGE', 'login');
define('DEFAULT_TEMPLATE', 'default');
define('ERROR_PAGE', 'notfound');
define('BLANK', 'blank');
define('DIR_TEMPLATES', './includes/templates/');
define('DIR_PAGES', './includes/pages/');
$allowedPages = parse_ini_file("./includes/conf.ini", true);

$page = isset($_GET['p'])? $_GET['p'] : DEFAULT_PAGE;
if (isset($allowedPages[$page])){
}
else {
$page = ERROR_PAGE;
}
	$controller = new authenticationController();
	$controller->displayPage($page, $allowedPages[$page]['template']);
?>