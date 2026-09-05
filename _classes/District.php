<?php

class District {
	
	private $_db,
			$_data;
	
	public function __construct($district = null){
		$this->_db = DB::getInstance();		
		if($district) {
			$this->find($district);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('districts',$id,$fields)){
			throw new Exception('There was a problem updating the district.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('districts',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($district = null){
		if($district){
			$field = (is_numeric($district)) ? 'id' : 'formhash';
			$data = $this->_db->get('districts', array($field,'=',$district));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finddistrictname($district = null){
		if($district){
			$field = 'districtname';
			$data = $this->_db->get('districts', array($field,'=',$district));
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