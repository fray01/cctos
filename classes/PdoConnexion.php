<?php
class PdoConnexion
{
	private $host="localhost";
	private $bdd='cctos';
	private $user="root";
	private $passe='';
	public $dbcnx;
	

	public function connexion()
	{
		try
		{
			//var_dump('connexion');
			$chaine="mysql:host=$this->host;dbname=$this->bdd";
			$this->dbcnx=new PDO($chaine,$this->user,$this->passe);
			return $this->dbcnx;
		}
		catch(PDOException $ex)
		{
			print "Erreur!" .$ex->getMessage();
		}
	}
	public function getLastInserId(){
		return PDO::lastInsertId();
	}
}  
?>