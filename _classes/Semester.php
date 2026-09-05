<?php

class Semester {
	
	private $_db,
			$_data;
	
	public function __construct($semester = null){
		$this->_db = DB::getInstance();		
		if($semester) {
			$this->find($semester);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('semesters',$id,$fields)){
			throw new Exception('There was a problem updating the semester.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('semesters',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($semester = null){
		if($semester){
			$field = (is_numeric($semester)) ? 'id' : 'formhash';
			$data = $this->_db->get('semesters', array($field,'=',$semester));
			
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