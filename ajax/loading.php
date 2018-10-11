<?php
session_start();
		$dir='../';
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
		
		$pdoQuery = new PdoExecuteQuery();
		$serviceManager = new ServiceManager();
		$typePatientManager = new PatientManager();
		$userManager = new UserManager();
		$stockManager = new StockManager();
		$diagnosticManager = new diagnosticManager();
		$settingsManager = new SettingsManager();
		$error = new ErrorsManager();
		$p = isset($_GET['p']) ? $_GET['p'] : '';

if(!empty($p)){
$data = array(
			'play' => 0,
			'info' => '',
			);
switch ($p)
	{
		case 'displayPatient' : 
			$displayPatientData = $typePatientManager->displayPatient(0);
			$data = array(
						'play' => 0,
						'info' => $displayPatientData,
						);
			echo json_encode($data);	
		break;
		case 'displayPatientOnWaiting' : 
			$displayPatientData = $typePatientManager->displayPatient(1);
			$data = array(
						'play' => 0,
						'info' => $displayPatientData,
						);
			echo json_encode($data);	
		break;
		case 'displayCasSocial' : 
			$displayPatientData = $typePatientManager->displayPatient('', 1);
			$data = array(
						'play' => 0,
						'info' => $displayPatientData,
						);
			echo json_encode($data);	
		break;
		case 'displayPersonnelIn' : 
			$displayPersonnelIn = $userManager->displayPersonnelIn();
			$data = array(
						'play' => 0,
						'info' => $displayPersonnelIn,
						);
			echo json_encode($data);	
		break;
		case 'displayTodayInOut' : 
			$displayTodayInOut = $userManager->displayTodayInOut();
			$data = array(
						'play' => 0,
						'info' => $displayTodayInOut,
						);
			echo json_encode($data);
		break;
		case 'displayNotification' : 
						$count = 0;
						$play = 0;
						$AlertStockMsg = '';
						$AlertPatientMsg = '';
						$AlertPatientOnWaitingMsg = '';

				$content = '';
				if($_SESSION['nomService'] == 'Direction'){
				
				//get stock Alert
				$AlertStock = $stockManager->countAlertStock();
				$count += $AlertStock['nbre'];
				$AlertStockMsg = $AlertStock['nbre'] > 0 ? $AlertStock['info'] : '';
				//get Patient waiting confirmation Alert
				$AlertPatient = $typePatientManager->countAlertPatient();
				$count += $AlertPatient['nbre'];
				$AlertPatientMsg = $AlertPatient['nbre']> 0 ? $AlertPatient['info'] : '';
				$play = $AlertPatient['nbre'];
				} else{
				//get Patient waiting doctor alert
				$AlertPatientOnWaiting = $typePatientManager->countAlertPatientOnWaiting();
				$count += $AlertPatientOnWaiting['nbre'];
				$AlertPatientOnWaitingMsg = $AlertPatientOnWaiting['nbre']> 0 ? $AlertPatientOnWaiting['info'] : '';
				$play = $AlertPatientOnWaiting['nbre'];
				}
				//feed notif bar
				$content.='<a href="#" class="dropdown-toggle" data-toggle="dropdown">'
						 .'<i class="fa fa-bell-o"></i>'
						 .'<span class="label label-warning">'.$count
						 .'</span></a><ul class="dropdown-menu">'
						 .'<li class="header"></li>'
						 .'<li><ul class="menu">'
						  .$AlertStockMsg
						  .$AlertPatientMsg
						  .$AlertPatientOnWaitingMsg;
				//close notif bar		  
				$content.='</ul></li></ul>';
				$content = $count > 0 ? $content : '';
				
				$data = array(
							'play' => $play ,
							'info' => $content,
							);
				echo json_encode($data);
		break;
		
		default:
		
		break;
	}
}
	
?>