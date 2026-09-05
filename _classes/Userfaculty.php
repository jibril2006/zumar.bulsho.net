<?php

class Userfaculty {
	
	private $_db,
			$_data;
	
	public function __construct($faculty = null){
		$this->_db = DB::getInstance();		
		if($faculty) {
			$this->find($faculty);
		}
		
	}
	
	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('userfaculties',$id,$fields)){
			throw new Exception('There was a problem updating the faculty.');
			
		}
	}

	public function create($fields = array()){
		if(!$this->_db->insert('userfaculties',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	public function find($faculty = null){
		if($faculty){
			$field = (is_numeric($faculty)) ? 'id' : 'formhash';
			$data = $this->_db->get('userfaculties', array($field,'=',$faculty));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcode($faculty = null){
		if($faculty){
			$field = 'code';
			$data = $this->_db->get('userfaculties', array($field,'=',$faculty));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function delete($fields = array()){
		if(!$this->_db->delete('userfaculties',$fields)){
			throw new Exception('There was a problem deleting the right to faculty.');
			
		}
	}

	public function get($fields = array()){
		if(!$this->_db->get('userfaculties',$fields)){
			throw new Exception('There was a problem deleting the right to faculty.');
			
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