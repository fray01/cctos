<?php
class authenticationController
{
	private $pdoQuery;
	private $template;
	private $serviceManager;
	private $settingsManager;
	private $errorManager;
	
	public function __construct()
	{
		$this->template = new Template(DIR_PAGES, DIR_TEMPLATES);
		$this->pdoQuery = new PdoExecuteQuery();
		$this->authentication = new authentication();
		$this->serviceManager = new ServiceManager();
		$this->settingsManager = new SettingsManager();
		$this->errorManager= new ErrorsManager();
		
	}

	public static function requiredClasses($dir='./')
	{
		require $dir . 'classes/PdoConnexion.php';
		require $dir . 'classes/PdoExecuteQuery.php';
		require $dir . 'classes/Template.php';
		require $dir . 'classes/authenticationManager.php';
		require $dir . 'classes/loginManager.php';
		require $dir . 'classes/ServiceManager.php';
		require $dir . 'classes/SettingsManager.php';
		require $dir . 'classes/FormFieldValidation.php';
		require $dir . 'classes/ErrorsManager.php';
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

/******************END STOCK*******************************/
        
        
/******************BEGIN SERVICE *******************************/
	public function optionServices($idService){
		return $this->serviceManager->optionServices($idService);
	}
/******************END SERVICE*******************************/
	
}