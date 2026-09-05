<?php

class Workinghour {
	
	private $_db,
			$_data;
	
	public function __construct($workinghour = null){
		$this->_db = DB::getInstance();		
		if($workinghour) {
			$this->find($workinghour);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('workinghours',$id,$fields)){
			throw new Exception('There was a problem updating the workinghour.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('workinghours',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($workinghour = null){
		if($workinghour){
			$field = (is_numeric($workinghour)) ? 'id' : 'formhash';
			$data = $this->_db->get('workinghours', array($field,'=',$workinghour));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcode($workinghour = null){
		if($workinghour){
			$field = 'code';
			$data = $this->_db->get('workinghours', array($field,'=',$workinghour));
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