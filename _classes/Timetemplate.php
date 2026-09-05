<?php

class Timetemplate {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($timetemplate = null){
		$this->_db = DB::getInstance();		
		if($timetemplate) {
			$this->find($timetemplate);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('timetemplates',$id,$fields)){
			throw new Exception('There was a problem updating the timetemplate.');
			
		}
	}

	
	public function create($fields = array()){
		if($this->_db->insert('timetemplates',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	public function delete($user = null){		
		$field = (is_numeric($timetemplate)) ? 'id' : 'formhash';
		$this->_db->delete('timetemplates', array($field,'=',$timetemplate));
		/*if(!$this->_db->delete('users', array($field,'=',$user)){
			throw new Exception('There was a problem updating the timetemplate.');
			
		}*/
	}
	
	public function find($timetemplate = null){
		if($timetemplate){
			$field = (is_numeric($timetemplate)) ? 'id' : 'formhash';
			$data = $this->_db->get('timetemplates', array($field,'=',$timetemplate));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduser($timetemplate = null){
		if($timetemplate){
			$field = 'userid';
			$data = $this->_db->get('timetemplates', array($field,'=',$timetemplate));
			
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