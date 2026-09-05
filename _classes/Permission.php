<?php

class Permission {
	
	private $_db,
			$_data;
	
	public function __construct($permission = null){
		$this->_db = DB::getInstance();		
		if($permission) {
			$this->find($permission);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('permissions',$id,$fields)){
			throw new Exception('There was a problem updating the permission.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('permissions',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($permission = null){
		if($permission){
			$field = (is_numeric($permission)) ? 'id' : 'formhash';
			$data = $this->_db->get('permissions', array($field,'=',$permission));
			
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