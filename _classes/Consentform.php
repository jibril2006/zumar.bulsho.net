<?php

class Consentform {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($consentform = null){
		$this->_db = DB::getInstance();		
		if($consentform) {
			$this->find($consentform);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('consentforms',$id,$fields)){
			throw new Exception('There was a problem updating the consentform.');
			
		}
	}


	public function create($fields = array()){
		if($this->_db->insert('consentforms',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	
	public function find($consentform = null){
		if($consentform){
			$field = (is_numeric($consentform)) ? 'id' : 'formhash';
			$data = $this->_db->get('consentforms', array($field,'=',$consentform));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

public function findcode($consentform = null){
		if($consentform){
			$field = 'survivorcode';
			$data = $this->_db->get('consentforms', array($field,'=',$consentform));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function delete($consentform = null){		
		$field = (is_numeric($consentform)) ? 'id' : 'formhash';
		$this->_db->delete('consentforms', array($field,'=',$consentform));
		/*if(!$this->_db->delete('consentforms', array($field,'=',$consentform)){
			throw new Exception('There was a problem updating the consentform.');
			
		}*/
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}

	public function lastinsertid(){
		return $this->_lastinserid;
	}
		
	public function data(){
		return $this->_data;
	}
	

}


?>