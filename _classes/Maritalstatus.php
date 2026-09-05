<?php

class Maritalstatus {
	
	private $_db,
			$_data;
	
	public function __construct($maritalstatus = null){
		$this->_db = DB::getInstance();		
		if($maritalstatus) {
			$this->find($maritalstatus);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('maritalstatuss',$id,$fields)){
			throw new Exception('There was a problem updating the maritalstatus.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('maritalstatuss',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($maritalstatus = null){
		if($maritalstatus){
			$field = (is_numeric($maritalstatus)) ? 'id' : 'formhash';
			$data = $this->_db->get('maritalstatuss', array($field,'=',$maritalstatus));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findmaritalstatusname($maritalstatus = null){
		if($maritalstatus){
			$field = 'maritalstatusname';
			$data = $this->_db->get('maritalstatuss', array($field,'=',$maritalstatus));
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