<?php
class ErrorsManager
{
	public $error;
	public function __construct()
	{
		$this->error = '';
	}
	
	public  function isErrorMsg($bool, $action)
	{
		if ($bool) {
			$this->error  .= '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fa fa-success">'.stripslashes($action).' effectué(e) avec succès</i></div>';
		}
		else $this->error  .= '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fa fa-warning"></i>Echec ' .stripslashes($action).'!</div>';
		return $this->error ;
	}
}
?>