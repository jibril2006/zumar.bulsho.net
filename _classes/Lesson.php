<?php

class Lesson {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($lesson = null){
		$this->_db = DB::getInstance();		
		if($lesson) {
			$this->find($lesson);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('lessons',$id,$fields)){
			throw new Exception('There was a problem updating the lesson.');
			
		}
	}

	
	public function create($fields = array()){
		if($this->_db->insert('lessons',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	public function delete($user = null){		
		$field = (is_numeric($lesson)) ? 'id' : 'formhash';
		$this->_db->delete('lessons', array($field,'=',$lesson));
		/*if(!$this->_db->delete('users', array($field,'=',$user)){
			throw new Exception('There was a problem updating the lesson.');
			
		}*/
	}
	
	public function find($lesson = null){
		if($lesson){
			$field = (is_numeric($lesson)) ? 'id' : 'formhash';
			$data = $this->_db->get('lessons', array($field,'=',$lesson));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduser($lesson = null){
		if($lesson){
			$field = 'userid';
			$data = $this->_db->get('lessons', array($field,'=',$lesson));
			
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

	public function lastinsertid(){
		return $this->_lastinserid;
	}
	
	public function data(){
		return $this->_data;
	}
	

}


?>