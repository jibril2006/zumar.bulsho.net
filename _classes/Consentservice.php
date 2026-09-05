<?php

class Consentservice {
	
	private $_db,
			$_data;
	
	public function __construct($consentservice = null){
		$this->_db = DB::getInstance();		
		if($consentservice) {
			$this->find($consentservice);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('consentservices',$id,$fields)){
			throw new Exception('There was a problem updating the consentservice.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('consentservices',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($consentservice = null){
		if($consentservice){
			$field = (is_numeric($consentservice)) ? 'id' : 'formhash';
			$data = $this->_db->get('consentservices', array($field,'=',$consentservice));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

public function findcode($consentservice = null){
		if($consentservice){
			$field = 'survivorcode';
			$data = $this->_db->get('consentservices', array($field,'=',$consentservice));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function delete($consentservice = null){		
		$field = (is_numeric($consentservice)) ? 'id' : 'formhash';
		$this->_db->delete('consentservices', array($field,'=',$consentservice));
		/*if(!$this->_db->delete('consentservices', array($field,'=',$consentservice)){
			throw new Exception('There was a problem updating the consentservice.');
			
		}*/
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data(){
		return $this->_data;
	}
	

}


?>