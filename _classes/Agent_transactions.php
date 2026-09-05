<?php

class Agent_transactions {
	
	private $_db,
			$_data;
	
	public function __construct($agenttransaction = null){
		$this->_db = DB::getInstance();		
		if($agenttransaction) {
			$this->find($agenttransaction);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('agent_transactions',$id,$fields)){
			throw new Exception('There was a problem updating the transaction.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('agent_transactions',$fields)){
			throw new Exception('There was a problem creating the new transaction.');
			
		}
	}

	
	public function find($agenttransactions = null){
		if($agenttransactions){
			$field = (is_numeric($agenttransactions)) ? 'id' : 'agentid';
			$data = $this->_db->get('agent_transactions', array($field,'=',$agenttransactions));
	
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function find2($agent_id = null, $currencynr = null){
		if($agent_id or $currencynr){
			//$field = (is_numeric($agenttransactions)) ? 'id' : 'agentid';
			if($agent_id)
			{ 
				$field = 'agent_id';
				$data = $this->_db->get('agent_transactions', array($field,'=',$agent_id));
			}
			if($currencynr)
			{
				$data = $this->_db->query("select * from agent_transactions where status = 1 and agent_id = ".$agent_id." and currencynr = ".$currencynr);
			}
			
			if($data->count())
			{
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