<?php
class Template
{
	private $page;
	private $template;
	private $pageDir;
	private $templateDir;
	
	public function __construct($pageDir, $templateDir){
		$this->templateDir = $templateDir;
		$this->pageDir = $pageDir;
	}
	public function setPage($pageName){
		$this->page = $pageName;
	}
	
	public function setTemplate($templateName){
		$this->template = $templateName;
	}
	
	public function getPagePath(){
		return $this->pageDir . $this->page .'.php';
	}
	
	public function getTemplatePath(){
		return $this->templateDir . $this->template .'.php';
	}
}