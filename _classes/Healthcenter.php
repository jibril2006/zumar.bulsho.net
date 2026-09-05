<?php

class Healthcenter {
	
	private $_db,
			$_data;
	
	public function __construct($healthcenter = null){
		$this->_db = DB::getInstance();		
		if($healthcenter) {
			$this->find($healthcenter);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('healthcenters',$id,$fields)){
			throw new Exception('There was a problem updating the healthcenter.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('healthcenters',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($healthcenter = null){
		if($healthcenter){
			$field = (is_numeric($healthcenter)) ? 'id' : 'formhash';
			$data = $this->_db->get('healthcenters', array($field,'=',$healthcenter));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findhealthcentername($healthcenter = null){
		if($healthcenter){
			$field = 'healthcentername';
			$data = $this->_db->get('healthcenters', array($field,'=',$healthcenter));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcentercode($healthcenter = null){
		if($healthcenter){
			$field = 'centercode';
			$data = $this->_db->get('healthcenters', array($field,'=',$healthcenter));
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