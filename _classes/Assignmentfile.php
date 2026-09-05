<?php

class Assignmentfile {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($assignmentfile = null){
		$this->_db = DB::getInstance();		
		if($assignmentfile) {
			$this->find($assignmentfile);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('assignmentfiles',$id,$fields)){
			throw new Exception('There was a problem updating the assignmentfile.');
			
		}
	}

	
	public function create($fields = array()){
		if($this->_db->insert('assignmentfiles',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	public function delete($user = null){		
		$field = (is_numeric($assignmentfile)) ? 'id' : 'formhash';
		$this->_db->delete('assignmentfiles', array($field,'=',$assignmentfile));
		/*if(!$this->_db->delete('users', array($field,'=',$user)){
			throw new Exception('There was a problem updating the assignmentfile.');
			
		}*/
	}
	
	public function find($assignmentfile = null){
		if($assignmentfile){
			$field = (is_numeric($assignmentfile)) ? 'id' : 'formhash';
			$data = $this->_db->get('assignmentfiles', array($field,'=',$assignmentfile));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findformhash($assignmentfile = null){
		if($assignmentfile){
			$field = 'uploadformhash';
			$data = $this->_db->get('assignmentfiles', array($field,'=',$assignmentfile));
			
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