<?php
class UploadFile
{
	CONST  MAX_SIZE = '1048576';
	private $destination = 'upload/picturefolder';
	private $basename ;
	private $filename = 'default.png';
	private $allowedExtensions;
	public $printError = TRUE;
	public $error = '';
	private $newFileName = array();
	private $uploadFilePath;
	private $uploadFilename;
	private $uploadTempFilename;
	
	public function setDestination($newDestination) {
		$this->destination = $newDestination;
	}
	
	public function setNewFileName($newFileName) {
		$this->newFileName = $newFileName;
	}
	
	public function getUploadFilename(){
		return $this->uploadFilename;
	}
	public function getNewFileName(){
		return $this->newFileName;
	}
	
	public function setPrintError($newValue) {
		$this->printError = $newValue;
	}
	
	public function setAllowedExtensions($newExtensions) {
		if (is_array($newExtensions)){
			$this->allowedExtensions = $newExtensions;
		}
		else {
			$this->allowedExtensions = array($newExtensions);
		}
	}
	
	public function setUploadedFilePath($uploadFilePath){
		$this->uploadFilePath = $uploadFilePath;
	}
	
	public function uploadMutipleFile($file, $i) {
		$counter = 0;
			if (!$this->areValid($file, $i)) {
				if ($this->printError) print $this->error;
			}
			else{
				$pathParts = pathinfo($file['name'][$i]);
				$sanitizedFilename = $this->getSanitizeBasename($pathParts['filename']);
				do{
					$this->uploadFilename = $sanitizedFilename . $counter . '.' . $this->getExtension($file['name'][$i]);
					$this->uploadFilePath = '../'. $this->destination .'/'. $this->uploadFilename;
					$this->uploadTempFilename = $file['tmp_name'][$i];
					$counter++;
				}
				while(file_exists($this->uploadFilePath));
				move_uploaded_file($this->uploadTempFilename, $this->uploadFilePath) or $this->error .= 'Destination Directory Permission Problem.<br />';
				
				if ($this->error && $this->printError) print $this->error;
				else {
					$this->newFileName = $this->uploadFilename;
					return $this->newFileName;
				}
			}
// 		}
	}
	
	public function upload($file) {
		$counter = 0;
		if (!$this->isValid($file)) {
				if ($this->printError) print $this->error;
			}
			else{
				$pathParts = pathinfo($file['name']);
				$sanitizedFilename = $this->getSanitizeBasename($pathParts['filename']);
				do{
					$this->uploadFilename = $sanitizedFilename . $counter . '.' . $this->getExtension($file['name']);
					$this->newFileName = $this->uploadFilename;
					$this->uploadFilePath = '../' . $this->destination .'/'. $this->newFileName;
					$this->uploadTempFilename = $file['tmp_name'];
					$counter++;
				}
				while(file_exists($this->uploadFilePath));
					move_uploaded_file($this->uploadTempFilename, $this->uploadFilePath) or $this->error .= 'Destination Directory Permission Problem.<br />';
				
				if ($this->error && $this->printError) print $this->error;
				else {
					$this->newFileName = $this->uploadFilename;
					return $this->newFileName;
				}
			}
// 		}
	}
	public function getDestination(){
		return $this->destination;
	}
	
	public function getUploadedFilePath(){
		return $this->uploadFilePath;
	}
	
	public function delete($file) {
		if (file_exists($file)) {
			unlink($file) or $this->error .= 'Destination Directory Permission Problem.<br />';
		}
		else {
			$this->error .= 'File not found! Could not delete: '.$file.'<br />';
		}
		if ($this->error && $this->printError) print $this->error;
	}

	public function isValid($file) {
		$isError = true;
		
			if(empty($file['name'])){
				$this->error .= 'Aucun fichier selectionné.<br />';
				$isError = false;
			}
			
			if (!in_array(strtolower($this->getExtension($file['name'])),$this->allowedExtensions)) {
			$this->error .= 'Extension not allowed.<br />';
				$isError = false;
			}
	
			if ($file['size'] > self::MAX_SIZE) {
				$this->error .= 'Fichier trop grand. Limit: '.self::MAX_SIZE.' bytes.<br />';
				$isError = false;
			}
			 
			return $isError;
// 		}
	}
	public function areValid($file, $i) {
		$isError = true;
	
		if(empty($file['name'][$i])){
			$this->error .= 'Aucun fichier selectionné.<br />';
			$isError = false;
		}
			
		if (!in_array(strtolower($this->getExtension($file['name'][$i])),$this->allowedExtensions)) {
			$this->error .= 'Extension not allowed.<br />';
			$isError = false;
		}
	
		if ($file['size'][$i] > self::MAX_SIZE) {
			$this->error .= 'Max File Size Exceeded. Limit: '.self::MAX_SIZE.' bytes.<br />';
			$isError = false;
		}
	
		return $isError;
	}
	
	public function getExtension($file) {
		$filepath = $file;
		$ext = pathinfo($filepath, PATHINFO_EXTENSION);
		return $ext;
	}
	
	private function getSanitizeBasename($basename){
		$basename = preg_replace(array('/è/','/é/', '/ê/','/ë/'), 'e', $basename);
		$basename = preg_replace(array('/â/', '/ä/'), 'a', $basename);
		$basename = preg_replace(array('/ô/','/ö/'), 'o', $basename);
		$basename = preg_replace(array('/û/','/ù/','/ü/') ,'u', $basename);
		$basename = preg_replace(array('/ÿ/'), 'y', $basename);
		$basename = preg_replace(array('/î/','/ï/'), 'i', $basename);
		$basename = preg_replace(array('/-/','/ /'), '_', $basename);
		
		return $basename;
	}
}