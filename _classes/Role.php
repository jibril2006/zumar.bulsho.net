<?php

class Role {
	
	private $_db,
			$_data;
	
	public function __construct($role = null){
		$this->_db = DB::getInstance();		
		if($role) {
			$this->find($role);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('roles',$id,$fields)){
			throw new Exception('There was a problem updating the role.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('roles',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($role = null){
		if($role){
			$field = (is_numeric($role)) ? 'id' : 'formhash';
			$data = $this->_db->get('roles', array($field,'=',$role));
			
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