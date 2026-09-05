<?php

class Donner {
	
	private $_db,
			$_data;
	
	public function __construct($donner = null){
		$this->_db = DB::getInstance();		
		if($donner) {
			$this->find($donner);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('donners',$id,$fields)){
			throw new Exception('There was a problem updating the donner.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('donners',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($donner = null){
		if($donner){
			$field = (is_numeric($donner)) ? 'id' : 'formhash';
			$data = $this->_db->get('donners', array($field,'=',$donner));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finddonnername($donner = null){
		if($donner){
			$field = 'donnername';
			$data = $this->_db->get('donners', array($field,'=',$donner));
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