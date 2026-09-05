<?php

class Gender {
	
	private $_db,
			$_data;
	
	public function __construct($gender = null){
		$this->_db = DB::getInstance();		
		if($gender) {
			$this->find($gender);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('genders',$id,$fields)){
			throw new Exception('There was a problem updating the gender.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('genders',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($gender = null){
		if($gender){
			$field = (is_numeric($gender)) ? 'id' : 'formhash';
			$data = $this->_db->get('genders', array($field,'=',$gender));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findgendername($gender = null){
		if($gender){
			$field = 'gendername';
			$data = $this->_db->get('genders', array($field,'=',$gender));
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