<?php
class DefaultManager{
	public $pdoQuery;
	public $data;
	
	private $pdoStatement;
	
	public function __construct()
	{
		$this->pdoQuery = new PdoExecuteQuery();
	}
	
	private function isFormSubmit($formname){
		return (isset($_POST['formname']) && ($_POST['formname'])==$formname);
	}
}
?>