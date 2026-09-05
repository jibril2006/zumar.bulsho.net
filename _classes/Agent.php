<?php

class Agent {
	
	private $_db,
			$_data;
	
	public function __construct($agent = null){
		$this->_db = DB::getInstance();		
		if($agent) {
			$this->find($agent);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('agents',$id,$fields)){
			throw new Exception('There was a problem updating the agent.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('agents',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($agent = null){
		if($agent){
			$field = (is_numeric($agent)) ? 'id' : 'agentid';
			$data = $this->_db->get('agents', array($field,'=',$agent));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findtlf($agent = null){
		if($agent){
			$field = (is_numeric($agent)) ? 'tlf' : 'name';
			$data = $this->_db->get('agents', array($field,'=',$agent));
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