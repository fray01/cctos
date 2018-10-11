<?php
class FormFieldValidation{
	private $dataFilter;

	public function setDataFilter(array $dataFilter){
		$this->dataFilter = $dataFilter;
	}

	public function getFilteredData($data){
		$data = filter_var_array($data, $this->dataFilter);

		$copieData = array();
		foreach ($data as $key=>$value){
			$newKey = ':'.$key;
			$copieData[$key] = $value; 
			$copieData[$newKey] = $value; 
		}
		return $copieData;
	}

	public function getSanitizeBasename($basename){
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