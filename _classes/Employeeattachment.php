<?php

class Employeeattachment {
	
	private $_db,
			$_data;
	
	public function __construct($employeeattachment = null){
		$this->_db = DB::getInstance();		
		if($employeeattachment) {
			$this->find($employeeattachment);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('employeeattachments',$id,$fields)){
			throw new Exception('There was a problem updating the employeeattachment.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('employeeattachments',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($employeeattachment = null){
		if($employeeattachment){
			$field = (is_numeric($employeeattachment)) ? 'id' : 'formhash';
			$data = $this->_db->get('employeeattachments', array($field,'=',$employeeattachment));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findemployeeattachmentname($employeeattachment = null){
		if($employeeattachment){
			$field = 'employeeattachmentname';
			$data = $this->_db->get('employeeattachments', array($field,'=',$employeeattachment));
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