<?php

class room {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($room = null){
		$this->_db = DB::getInstance();		
		if($room) {
			$this->find($room);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('rooms',$id,$fields)){
			throw new Exception('There was a problem updating the room.');
			
		}
	}

	
	public function create($fields = array()){
		if($this->_db->insert('rooms',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	public function delete($user = null){		
		$field = (is_numeric($room)) ? 'id' : 'formhash';
		$this->_db->delete('rooms', array($field,'=',$room));
		/*if(!$this->_db->delete('users', array($field,'=',$user)){
			throw new Exception('There was a problem updating the room.');
			
		}*/
	}
	
	public function find($room = null){
		if($room){
			$field = (is_numeric($room)) ? 'id' : 'formhash';
			$data = $this->_db->get('rooms', array($field,'=',$room));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduser($room = null){
		if($room){
			$field = 'userid';
			$data = $this->_db->get('rooms', array($field,'=',$room));
			
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