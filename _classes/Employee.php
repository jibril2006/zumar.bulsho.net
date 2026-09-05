<?php

class Employee {
	
	private $_db,
			$_data;
	
	public function __construct($employee = null){
		$this->_db = DB::getInstance();		
		if($employee) {
			$this->find($employee);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('employees',$id,$fields)){
			throw new Exception('There was a problem updating the employee.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('employees',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($employee = null){
		if($employee){
			$field = (is_numeric($employee)) ? 'id' : 'formhash';
			$data = $this->_db->get('employees', array($field,'=',$employee));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findemployeename($employee = null){
		if($employee){
			$field = 'employeename';
			$data = $this->_db->get('employees', array($field,'=',$employee));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findpincode($employee = null){
		if($employee){
			$field = 'pincode';
			$data = $this->_db->get('employees', array($field,'=',$employee));
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