<?php

class Setting {
	
	private $_db,
			$_data;
	
	public function __construct($setting = null){
		$this->_db = DB::getInstance();		
		if($setting) {
			$this->find($setting);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('settings',$id,$fields)){
			throw new Exception('There was a problem updating the setting.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('settings',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($setting = null){
		if($setting){
			$field = (is_numeric($setting)) ? 'id' : 'option';
			$data = $this->_db->get('settings', array($field,'=',$setting));
			
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