<?php

class Subject {
	
	private $_db,
			$_data;
	
	public function __construct($subject = null){
		$this->_db = DB::getInstance();		
		if($subject) {
			$this->find($subject);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('subjects',$id,$fields)){
			throw new Exception('There was a problem updating the subject.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('subjects',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($subject = null){
		if($subject){
			$field = (is_numeric($subject)) ? 'id' : 'formhash';
			$data = $this->_db->get('subjects', array($field,'=',$subject));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcode($subject = null){
		if($subject){
			$field = 'code';
			$data = $this->_db->get('subjects', array($field,'=',$subject));
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