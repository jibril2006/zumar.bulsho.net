<?php

class Notification {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($notification = null){
		$this->_db = DB::getInstance();		
		if($notification) {
			$this->find($notification);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('notifications',$id,$fields)){
			throw new Exception('There was a problem updating the notification.');
			
		}
	}

	
	public function create($fields = array()){
		if($this->_db->insert('notifications',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	public function delete($user = null){		
		$field = (is_numeric($notification)) ? 'id' : 'formhash';
		$this->_db->delete('notifications', array($field,'=',$notification));
		/*if(!$this->_db->delete('users', array($field,'=',$user)){
			throw new Exception('There was a problem updating the notification.');
			
		}*/
	}
	
	public function find($notification = null){
		if($notification){
			$field = (is_numeric($notification)) ? 'id' : 'formhash';
			$data = $this->_db->get('notifications', array($field,'=',$notification));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduser($notification = null){
		if($notification){
			$field = 'userid';
			$data = $this->_db->get('notifications', array($field,'=',$notification));
			
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