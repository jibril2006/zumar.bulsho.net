<?php

class Jobstatus {
	
	private $_db,
			$_data;
	
	public function __construct($jobstatus = null){
		$this->_db = DB::getInstance();		
		if($jobstatus) {
			$this->find($jobstatus);
		}
		
	}
	

	public function update($fields = array(), $id = null){
		if(!$this->_db->update('jobstatuss',$id,$fields)){
			throw new Exception('There was a problem updating the jobstatus.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('jobstatuss',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($jobstatus = null){
		if($jobstatus){
			$field = (is_numeric($jobstatus)) ? 'id' : 'formhash';
			$data = $this->_db->get('jobstatuss', array($field,'=',$jobstatus));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findjobtitle($jobstatus = null){
		if($jobstatus){
			$field = 'jobtitle';
			$data = $this->_db->get('jobstatuss', array($field,'=',$jobstatus));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data(){
		return $this->_data;
	}
	

}


?>