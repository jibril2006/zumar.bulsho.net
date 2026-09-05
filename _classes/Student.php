<?php

class Student {
	
	private $_db,
			$_data;
	
	public function __construct($student = null){
		$this->_db = DB::getInstance();		
		if($student) {
			$this->find($student);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('users',$id,$fields)){
			throw new Exception('There was a problem updating the student.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('users',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($student = null){
		if($student){
			$field = (is_numeric($student)) ? 'id' : 'formhash';
			$data = $this->_db->get('users', array($field,'=',$student));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduser($student = null){
		if($student){
			$field = 'username';
			$data = $this->_db->get('users', array($field,'=',$student));
			
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