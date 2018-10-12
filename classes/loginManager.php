<?php
class loginManager
{
	
	CONST SELECT_SERVICE_BY_ID = 'SELECT abreviationService FROM service WHERE idService = :idService';
	private $pdoStatement;
	
	public $data;
	public $pdoQuery;
	
	public function __construct(){
		$this->pdoQuery = new PdoExecuteQuery();
                
                
	}

	public function checkLogin($directory, $dir)
	{
		$data = $this->isLogin();
		if ($data==false)
		{
                    session_unset();
                    header('location:../');
                }else{
                    $mydir = $this->myDirectory($_SESSION['CREDIALS']['idService']);
                    if ($directory == $mydir) {
                         return true;
                    } else {
                        header('location:'.$dir . $mydir.'/');
                        
                    }
                }
	}
        
	private function isLogin()
	{
		if (isset($_SESSION['CREDIALS']) && $_SESSION['CONNECTED'] == true)
		{
                 //   return $_SESSION['CREDIALS']['WHOIS'];
                    return true;
                } else{
                    return false ;
                }
	}
        
	private function myDirectory($idService)
	{
	$services = array(
				'DIRECTION' => 'DIRECTION',
				'ACCUEIL' => 'ACCUEIL',
				'CONSULTATION' =>'CONSULTATION',
				'autres' => 'SERVICE',
			);
		$myservice = $this->pdoQuery->executePdoSelectQueryTable(self::SELECT_SERVICE_BY_ID,
			array(
				'idService' => $idService,
			));
// 		var_dump($myservice);
		if (!empty($myservice[0]['abreviationService']) && isset($myservice[0]['abreviationService'])){
			
                $myservice = $myservice[0]['abreviationService'];
			if (array_key_exists($myservice, $services)){
				return $services[$myservice];
			}
			else return $services['autres'];
		}
		else return $services['autres'];
	}
        
	public function logout()
	{	
                session_unset();
                header('location:../');
	}
	
}
?>