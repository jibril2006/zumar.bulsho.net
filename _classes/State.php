<?php

class State {
	
	private $_db,
			$_data;
	
	public function __construct($state = null){
		$this->_db = DB::getInstance();		
		if($state) {
			$this->find($state);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('states',$id,$fields)){
			throw new Exception('There was a problem updating the state.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('states',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($state = null){
		if($state){
			$field = (is_numeric($state)) ? 'id' : 'formhash';
			$data = $this->_db->get('states', array($field,'=',$state));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findstatename($state = null){
		if($state){
			$field = 'statename';
			$data = $this->_db->get('states', array($field,'=',$state));
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