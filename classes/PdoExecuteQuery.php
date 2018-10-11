<?php
class PdoExecuteQuery {
	
	private $dbcnx;
	public function __construct()
	{
 		//require './classes/PdoConnexion.php';
	}
	public function executePdoQuery($query, $params=array()){
		
		$con = new PdoConnexion();
		$this->dbcnx =  $con->connexion();
		if(empty($params)){
			return $this->dbcnx->query($query);
		}
		else{
// 			var_dump($params);
			$this->pdoStatement = $this->dbcnx->prepare($query);
			return $this->pdoStatement->execute($params);
		}
	}
	
	public function executePdoSelectQueryTable($query, $params){
		$bool = $this->executePdoQuery($query, $params);
		if($bool) return $this->pdoStatement->fetchAll();
		else return array();
	}
	
	public function getLastInserId(){
		return $this->dbcnx->lastInsertId();
	}
}
?>