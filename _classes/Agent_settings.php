<?php

class Agent_settings {
	
	private $_db,
			$_data;
	
	public function __construct($agentsetting = null){
		$this->_db = DB::getInstance();		
		if($agentsetting) {
			$this->find($agentsetting);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('agent_settings',$id,$fields)){
			throw new Exception('There was a problem updating the agent.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('agent_settings',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($agentsettings = null){
		if($agentsettings){
			//$field = (is_numeric($agentsettings)) ? 'id' : 'set_valuta1';
			$field = 'id';
			$data = $this->_db->get('agent_settings', array($field,'=',$agentsettings));
			
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