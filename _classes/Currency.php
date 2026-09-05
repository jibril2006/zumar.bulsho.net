<?php

class Currency {
	
	private $_db,
			$_data;
	
	public function __construct($currency = null){
		$this->_db = DB::getInstance();
	}
	
	
	public function update($fields = array(), $id = null){
		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		
		if(!$this->_db->update('currency',$id,$fields)){
			throw new Exception('There was a problem updating the user.');
			
		}
	}
	
	public function create($fields = array()){
		if(!$this->_db->insert('currency',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}
	
	public function find($currency = null){
		if($currency){
			$field = (is_numeric($currency)) ? 'id' : 'currency';
			$data = $this->_db->get('currency', array($field,'=',$currency));
			
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