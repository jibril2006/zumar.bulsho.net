<?php

class Usedconsentservice {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($usedconsentservice = null){
		$this->_db = DB::getInstance();		
		if($usedconsentservice) {
			$this->find($usedconsentservice);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('usedconsentservices',$id,$fields)){
			throw new Exception('There was a problem updating the usedconsentservice.');
			
		}
	}


	public function create($fields = array()){
		if($this->_db->insert('usedconsentservices',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	
	public function find($usedconsentservice = null){
		if($usedconsentservice){
			$field = (is_numeric($usedconsentservice)) ? 'id' : 'formhash';
			$data = $this->_db->get('usedconsentservices', array($field,'=',$usedconsentservice));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcontactnumber($usedconsentservice = null){
		if($usedconsentservice){
			$field = 'contactnumber';
			$data = $this->_db->get('usedconsentservices', array($field,'=',$usedconsentservice));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

public function findcode($usedconsentservice = null){
		if($usedconsentservice){
			$field = 'usedconsentservicecode';
			$data = $this->_db->get('usedconsentservices', array($field,'=',$usedconsentservice));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function delete($usedconsentservice = null){		
		$field = (is_numeric($usedconsentservice)) ? 'id' : 'formhash';
		$this->_db->delete('usedconsentservices', array($field,'=',$usedconsentservice));
		/*if(!$this->_db->delete('usedconsentservices', array($field,'=',$usedconsentservice)){
			throw new Exception('There was a problem updating the usedconsentservice.');
			
		}*/
	}

	public function lastinsertid(){
		return $this->_lastinserid;
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data(){
		return $this->_data;
	}
	

}


?>