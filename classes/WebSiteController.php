<?php
class WebSiteController
{
	private $pdoQuery;
	private $template;
	private $serviceManager;
	private $typePatientManager;
	private $userManager;
	private $settingsManager;
	private $error;
	
	public function __construct()
	{
		$this->template = new Template(DIR_PAGES, DIR_TEMPLATES);
		$this->pdoQuery = new PdoExecuteQuery();
		$this->loginManager = new loginManager();
		$this->authentication = new authentication();
		$this->serviceManager = new ServiceManager();
		$this->typePatientManager = new PatientManager();
		$this->userManager = new UserManager();
		$this->stockManager = new StockManager();
		$this->diagnosticManager = new diagnosticManager();
		$this->error = new ErrorsManager();
		$this->settingsManager = new SettingsManager();
	}

	public static function requiredClasses($dir='./')
	{
		require $dir . 'classes/PdoConnexion.php';
		require $dir . 'classes/PdoExecuteQuery.php';
		require $dir . 'classes/Template.php';
		require $dir . 'classes/loginManager.php';
		require $dir . 'classes/authenticationManager.php';
		require $dir . 'classes/ServiceManager.php';
		require $dir . 'classes/PatientManager.php';
		require $dir . 'classes/StockManager.php';
		require $dir . 'classes/diagnosticManager.php';
		require $dir . 'classes/UserManager.php';
		require $dir . 'classes/SettingsManager.php';
		require $dir . 'classes/FormFieldValidation.php';
		require $dir . 'classes/ErrorsManager.php';
		require $dir . 'classes/UploadFile.php';
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
		
/******************BEGIN ACCOUNT*******************************/
        
	public function storeUser()
	{
        return $this->authentication->storeUser();
	}

	public function displayAccount()
	{
		return $this->authentication->displayAccount();
	}

	public function updateUser()
	{
		return $this->authentication->updateUser();
	}
/******************END ACCOUNT*******************************/
	public function checkLogin($directory, $dir)
	{
		return $this->loginManager->checkLogin($directory, $dir);
	}
/****************** END LOGIN CHECKING **************************************/
 
/******************BEGIN LOGOUT*******************************/
	public function logout()
	{       
            if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
            return $this->loginManager->logout();
            }
	}
/****************** END LOGOUT **************************************/
 
/******************BEGIN service*******************************/
	public function addNewService()
	{
		return $this->serviceManager->addNewService();
	}
	
	public function updateService()
	{
		return $this->serviceManager->updateService();
	}
	
	public function displayService()
	{
		return $this->serviceManager->displayServices();
	}
	
	public function readService($idService)
	{
		return $this->serviceManager->readService($idService);
	}
	public function optionServices($idService){
		return $this->serviceManager->optionServices($idService);
	}
	
	public function displayFolderByServices()
	{
		return $this->serviceManager->displayFolderByServices();
	}
/****************** ENDservice**************************************/
	
/******************BEGIN Type Patient*******************************/	
	public function displayTypePatient(){
		return $this->typePatientManager->displayTypePatient();
	}

	public function addNewTypePatient(){
		return $this->typePatientManager->addNewTypePatient();
	}
	
	public function updateTypePatient()
	{
		return $this->typePatientManager->updateTypePatient();
	}
	
	public function readTypePatient($idTypePatient)
	{
		return $this->typePatientManager->readTypePatient($idTypePatient);
	}
	
	public function optionTypePatient($idTypePatient)
	{
		return $this->typePatientManager->optionTypePatient($idTypePatient);
	}
	
	public function displayPatientFolderByServices($numDossier, $nomPatient, $prenomPatient)
	{
		return $this->typePatientManager->displayPatientFolderByServices($numDossier, $nomPatient, $prenomPatient);
	}
	
	public function setBackward()
	{
		$bool = $this->typePatientManager->setBackward();
		if ($bool){
			return 'Règlement pris en compte';
		}
		else return 'Echec de l\'enregistrement';
	}
/******************END Type Patient*******************************/

/******************BEGIN Patient*******************************/

	public function addNewPatient()
	{
		return $this->typePatientManager->addNewPatient();
	}
	
	public function updatePatient(){
		return $this->typePatientManager->updatePatient();
	}
	
	public function ReadPatient($numDossier)
	{
		return $this->typePatientManager->readPatient($numDossier);
	}

	public function displayPatient($etatPoser, $etatPatient=0)
	{
		return $this->typePatientManager->displayPatient($etatPoser, $etatPatient);
	}
	public function displayPatientShort()
	{
		return $this->typePatientManager->displayPatientShort();
	}
	
	public function readPatientFolder($numDossier)
	{
		return $this->typePatientManager->readPatientFolder($numDossier);
	}
	
	public function displayPatientFolders($numDossier)
	{
		$this->typePatientManager->displayPatientFolderByServices($numDossier);
	}
	
	public function patientNewFolder()
	{
		return $this->typePatientManager->patientNewFolder();
	}

	public function addPatientNewActe()
	{
		return $this->typePatientManager->addPatientNewActe();
	}

	public function displayPatientPrintFolder($idService, $numDossier)
	{
		return $this->typePatientManager->displayPatientPrintFolder($idService, $numDossier);
	}

	public function displayPaymentInfo()
	{
		return $this->typePatientManager->displayPaymentInfo();
	}
	
	
/******************END Patient*******************************/


/******************BEGIN FOLLOW*******************************/
	
	public function addFollowPatient()
	{
		return $this->typePatientManager->addFollowPatient();
	}

	public function updateFollowPatient()
	{
		return $this->typePatientManager->updateFollowPatient();
	}
	
	public function readPatientFollowers($numDossier,$service)
	{
		return $this->typePatientManager->readFollower($numDossier,$service);
	}
/******************END FOLLOW*******************************/

/******************BEGIN Personnel*******************************/
	public function addEmployee()
	{
		return $this->userManager->addEmployee();
	}
	
	public function updateEmployee()
	{
		return $this->userManager->updateEmployee();
	}

	public function displayEmployees()
	{
		return $this->userManager->displayEmployees();
	}
	public function optionFonction($idPersonnel)
	{
		return $this->userManager->optionFonction($idPersonnel);
	}
	
	public function optionAffiliation($idParent)
	{
		return $this->userManager->optionAffiliation($idParent);
	}
	
	public function readEmployee($idPersonnel)
	{
		return $this->userManager->readEmployee($idPersonnel);
	}
	
	public function readAffiliation($idParent)
	{
		return $this->userManager->readAffiliation($idParent);
	}
	
	public function displayEmployeesFamilyMembers($idPersonnel,$matriculePersonnel, $nomPersonnel, $prenomPersonnel)
	{
		return $this->userManager->displayEmployeesFamilyMembers($idPersonnel, $matriculePersonnel, $nomPersonnel, $prenomPersonnel);
	}
	public function addPersonnelNewFamilyMember()
	{
		return $this->userManager->addPersonnelNewFamilyMember();
	}

	public function updatePersonnelNewFamilyMember()
	{
		return $this->userManager->updatePersonnelNewFamilyMember();
	}
	
	public function optionPersonnel()
	{
		return $this->userManager->optionPersonnel();
	}
	
	public function displayInOut()
	{
		return $this->userManager->displayInOut();
	}
	
	public function displayTodayInOut()
	{
		return $this->userManager->displayTodayInOut();
	}
	
	public function displayPersonnel()
	{
		return $this->userManager->displayPersonnel();
	}
	
	public function isOn()
	{
		return $this->userManager->isOn();
	}
	
	public function isOut($idEtre)
	{
		return $this->userManager->isOut($idEtre);
	}
	
	public function readInOut($idEtre)
	{
		return $this->userManager->readInOut($idEtre);
	}

	public function displayPersonnelIn()
	{
		return $this->userManager->displayPersonnelIn();
	}

	public function displayPersonnelActivities($idPersonnel,$nomPersonnel, $prenomPersonnel)
	{
		return $this->userManager->displayPersonnelActivities($idPersonnel,$nomPersonnel, $prenomPersonnel);
	}

	public function displayPersonnelStat($idPersonnel,$nomPersonnel, $prenomPersonnel)
	{
		return  $this->userManager->displayPersonnelStat($idPersonnel, $nomPersonnel, $prenomPersonnel);
	}
/******************BEGIN Acte*******************************/
	public function isFormAdd()
	{
		return $this->settingsManager->isFormAdd();
	}
	public function isFormUpdate()
	{
		return $this->settingsManager->isFormUpdate();
	}
/*	public function addActe()
	{
		$this->settingsManager->addActe();
	}
	
	public function updateActe()
	{
		return $this->settingsManager->updateActe();
	}
*/
	public function displayActe()
	{
		return $this->settingsManager->displayActe();
	}
	
	public function readActe($idActe)
	{
		return $this->settingsManager->readActe($idActe);
	}
/*	public function addTarification()
	{
		$this->settingsManager->addTarification();
	}
	
	public function updateTarification()
	{
		return $this->settingsManager->updateTarification();
	}
*/	
	public function displayTarification()
	{
		return $this->settingsManager->displayTarification();
	}
	public function optionTarification($idTarif)
	{
		echo $this->settingsManager->optionTarification($idTarif);
	}
	public function readTarification($idTarif)
	{
		return $this->settingsManager->readTarification($idTarif);
	}
	public function countService()
	{
		return $this->settingsManager->countService();
	}
	public function countPersonnel()
	{
		return $this->settingsManager->countPersonnel();
	}
	public function countPoser()
	{
		return $this->settingsManager->countPoser();
	}
	public function countPatient()
	{
		return $this->settingsManager->countPatient();
	}
	public function optionCentre()
	{
		return $this->settingsManager->optionCentre();
	}
/******************END Acte*******************************/


/******************BEGIN STOCK*******************************/
        
	public function addNewProduit()
	{
		return $this->stockManager->addNewProduit();
	}
	public function mouvementProduit()
	{
		return $this->stockManager->mouvementProduit();
	}
	public function displayStock()
	{
		return $this->stockManager->displayStock();
	}
	public function displayStockUse()
	{
			return $this->stockManager->displayStockUse();
	}
	
	public function readProduit($id)
	{
		return $this->stockManager->getProduitById($id);
	}
	public function updateProduit()
	{
		return $this->stockManager->updateProduit();
	}
	public function optionProduit($selected)
	{
		return $this->stockManager->optionProduit($selected);
	}
	public function optionBatiment($idBatiment)
	{
		return $this->stockManager->optionBatiment($idBatiment);
	}
	public function displayIn()
	{
		return $this->stockManager->displayIn();
	}
	public function displayOut()
	{
		return $this->stockManager->displayOut();
	}
	public function optionStock($idBatiment)
	{
		return $this->stockManager->optionStock($idBatiment);
	}
	public function useProduct()
	{
		return $this->stockManager->useProduct();
	}
/******************END STOCK*******************************/

/******************BEGIN DIAGNOSTIC*******************************/
	public function addDiagnostic()
	{
		if(isset($_GET['detail'])){
			return $this->diagnosticManager->addDiagnostic($_GET['detail']);
		}
		else return;
	}
	
	public function confirmDiagnostic()
	{
		if(isset($_GET['resultat'])){
			return $this->diagnosticManager->confirmDiagnostic($_GET['resultat']);
		}
		else return;
	}

	public function displayDiagnostic($etatDiagnostic='')
	{
		if(isset($_GET['id'])){
			return $this->diagnosticManager->displayDiagnostic($_GET['id'], $etatDiagnostic);
		}
		else return;
	}
	public function updateDiagnostic()
	{       
			return $this->diagnosticManager->updateDiagnostic();
	}	
	public function readDiagnostic()
	{       
		if(isset($_GET['id']) && isset($_GET['cod'])){
			$this->pdoQuery = $this->diagnosticManager->getDiagnosticById((int)$_GET['cod']);
                foreach ($this->pdoQuery as $data) {
                    return $data;
                }
		}
	}	
	public function readDiagnosticConsultation($idResultat)
	{       
		return $this->diagnosticManager->readDiagnostic($idResultat);
	}

	public function optionActe($idActe)
	{
		return $this->diagnosticManager->optionActe($idActe);
	}

	public function optionDent($numDent)
	{
		return $this->diagnosticManager->optionDent($numDent);
	}
	public function optionActeService($libelleActe)
	{
		return $this->diagnosticManager->optionActeService($_SESSION['idService'], $libelleActe);
	}
	
	public function readDiagnostics()
	{
		return $this->diagnosticManager->readDiagnostic($_SESSION['idService']);
	}
	public function optionDentService($libelleActe)
	{
		return $this->diagnosticManager->optionDentService($_SESSION['idService'], $libelleActe);
	}
/****************** END DIAGNOSTIC **************************************/


/****************** BEGIN NOTIFICATION**************************************/

	public function displayNotification()
	{
		$count = 0;
		$content = '';
		
		$AlertStock = $this->stockManager->countAlertStock();
		$count += $AlertStock['nbre'];
		$AlertPatient = $this->typePatientManager->countAlertPatient();
		$count += $AlertPatient['nbre'];
		//feed notif bar
		$content.='<a href="#" class="dropdown-toggle" data-toggle="dropdown">'
				 .'<i class="fa fa-bell-o"></i>'
				 .'<span class="label label-warning">'.$count
				 .'</span></a><ul class="dropdown-menu">'
				 .'<li class="header"></li>'
				 .'<li><ul class="menu">'
				  .$AlertStock['info']
				  .$AlertPatient['info'];;
		//close notif bar		  
		$content.='</ul></li></ul>';
		
		echo $content;
	}
	
	public function previousPage()
	{
		if(isset($_SERVER['HTTP_REFERER'])){
		$_SESSION['temp_dir'] = $_SERVER['HTTP_REFERER'];
		$back = $_SESSION['temp_dir']; 
		}
		elseif(!isset($_SERVER['HTTP_REFERER']) && isset($_SESSION['temp_dir'])){
			$back = $_SESSION['temp_dir']; 
		}else $back ='./index.php';
		return $back;
	}


/****************** END NOTIFICATION **************************************/
}