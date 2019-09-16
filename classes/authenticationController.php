<?php
class authenticationController
{
	private $pdoQuery;
	private $template;
	private $authentication;
	
	public function __construct()
	{
		$this->template = new Template(DIR_PAGES, DIR_TEMPLATES);
		$this->pdoQuery = new PdoExecuteQuery();
		$this->authentication = new authentication();		
	}

	public static function requiredClasses($dir='./')
	{
		require $dir . 'classes/PdoConnexion.php';
		require $dir . 'classes/PdoExecuteQuery.php';
		require $dir . 'classes/Template.php';
		require $dir . 'classes/authenticationManager.php';
		require $dir . 'classes/loginManager.php';
		require $dir . 'classes/FormFieldValidation.php';
	}
	
	public function displayPage($pageName, $templateName)
	{
		$this->template->setPage($pageName);
		$this->template->setTemplate($templateName);
		include $this->template->getTemplatePath();
	}

	public function includePage()
	{
		include $this->template->getPagePath();
	}

/******************BEGIN AUTH*******************************/
        
	public function storeUser()
	{
		return $this->authentication->storeUser();
	}
	public function login()
	{
		return $this->authentication->getUserByNameAndPassword();
	}
}