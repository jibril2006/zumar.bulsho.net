<?php

class Rate {
	
	private $_db,
			$_data,
			$_data2;
	
	public function __construct($currency = null){
		$this->_db = DB::getInstance();
		
	}
	
	public function update($fields = array(), $id = null){
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		
		if(!$this->_db->update('rate',$id,$fields)){
			throw new Exception('There was a problem updating the user.');			
		}
	}
	
	public function create($fields = array()){
		if(!$this->_db->insert('rate',$fields)){
			throw new Exception('There was a problem creating the new account.');
		}
	}
	
	public function find($currency = null){
		if($currency){
			$field = (is_numeric($currency)) ? 'id' : 'currency';
			$data = $this->_db->get('rate', array($field,'=',$currency));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	
	public function showCurrent($currency){

		$file = 'http://www.nationalbanken.dk/_vti_bin/DN/DataService.svc/CurrencyRatesXML?lang=da';
		$hndl = @fopen($file,'r');
		
		if($hndl !== false){
		   
				$xml = simplexml_load_file($file);
				$element = $xml->xpath('dailyrates/currency[@code="' . $currency . '"]/@rate');
				return $element[0];
		   
		}
		else
		{
		   return false;
		}
			
	}
	

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	
	public function data(){
		return $this->_data;
	}
	
	
}


?>