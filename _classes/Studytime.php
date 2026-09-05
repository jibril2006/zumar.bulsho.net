<?php

class Studytime {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($studytime = null){
		$this->_db = DB::getInstance();		
		if($studytime) {
			$this->find($studytime);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('studytimes',$id,$fields)){
			throw new Exception('There was a problem updating the studytime.');
			
		}
	}

	
	public function create($fields = array()){
		if($this->_db->insert('studytimes',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	public function delete($user = null){		
		$field = (is_numeric($studytime)) ? 'id' : 'formhash';
		$this->_db->delete('studytimes', array($field,'=',$studytime));
		/*if(!$this->_db->delete('users', array($field,'=',$user)){
			throw new Exception('There was a problem updating the studytime.');
			
		}*/
	}
	
	public function find($studytime = null){
		if($studytime){
			$field = (is_numeric($studytime)) ? 'id' : 'formhash';
			$data = $this->_db->get('studytimes', array($field,'=',$studytime));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduser($studytime = null){
		if($studytime){
			$field = 'userid';
			$data = $this->_db->get('studytimes', array($field,'=',$studytime));
			
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