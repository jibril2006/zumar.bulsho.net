<?php

class Status {
	
	private $_db,
			$_data;
	
	public function __construct($status = null){
		$this->_db = DB::getInstance();		
		if($status) {
			$this->find($status);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('statuss',$id,$fields)){
			throw new Exception('There was a problem updating the status.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('statuss',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($status = null){
		if($status){
			$field = (is_numeric($status)) ? 'id' : 'formhash';
			$data = $this->_db->get('statuss', array($field,'=',$status));
			
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