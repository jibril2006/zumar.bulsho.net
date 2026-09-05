<?php

class Period {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($period = null){
		$this->_db = DB::getInstance();		
		if($period) {
			$this->find($period);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('periods',$id,$fields)){
			throw new Exception('There was a problem updating the period.');
			
		}
	}

	
	public function create($fields = array()){
		if($this->_db->insert('periods',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	public function delete($user = null){		
		$field = (is_numeric($period)) ? 'id' : 'formhash';
		$this->_db->delete('periods', array($field,'=',$period));
		/*if(!$this->_db->delete('users', array($field,'=',$user)){
			throw new Exception('There was a problem updating the period.');
			
		}*/
	}
	
	public function find($period = null){
		if($period){
			$field = (is_numeric($period)) ? 'id' : 'formhash';
			$data = $this->_db->get('periods', array($field,'=',$period));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduser($period = null){
		if($period){
			$field = 'userid';
			$data = $this->_db->get('periods', array($field,'=',$period));
			
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