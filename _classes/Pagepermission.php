<?php

class Pagepermission {
	
	private $_db,
			$_data;
	
	public function __construct($pagepermission = null){
		$this->_db = DB::getInstance();		
		if($pagepermission) {
			$this->find($pagepermission);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('pagepermissions',$id,$fields)){
			throw new Exception('There was a problem updating the pagepermission.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('pagepermissions',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($pagepermission = null){
		if($pagepermission){
			$field = (is_numeric($pagepermission)) ? 'id' : 'formhash';
			$data = $this->_db->get('pagepermissions', array($field,'=',$pagepermission));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcode($pagepermission = null){
		if($pagepermission){
			$field = 'code';
			$data = $this->_db->get('pagepermissions', array($field,'=',$pagepermission));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function delete($pagepermission = null){		
		$field = (is_numeric($pagepermission)) ? 'id' : 'formhash';
		$this->_db->delete('pagepermissions', array($field,'=',$pagepermission));
		/*if(!$this->_db->delete('pagepermissions', array($field,'=',$pagepermission)){
			throw new Exception('There was a problem updating the pagepermission.');
			
		}*/
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data(){
		return $this->_data;
	}
	

}


?>