<?php

class Agent_accounts {
	
	private $_db,
			$_data;
	
	public function __construct($agentaccount = null){
		$this->_db = DB::getInstance();		
		if($agentaccount) {
			$this->find($agentaccount);
		}
		
	}
	

	public function update($fields = array(), $id = null){
		if(!$this->_db->update('agent_accounts',$id,$fields)){
			throw new Exception('There was a problem updating the account.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('agent_accounts',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($agentaccounts = null){
		if($agentaccounts){
			$field = (is_numeric($agentaccounts)) ? 'id' : 'agentid';
			$data = $this->_db->get('agent_accounts', array($field,'=',$agentaccounts));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function findaccountnr($agentaccounts = null){
		if($agentaccounts){
			$field = (is_numeric($agentaccounts)) ? 'accountnr' : 'agentid';
			$data = $this->_db->get('agent_accounts', array($field,'=',$agentaccounts));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function find1($agent_id = null, $currencynr = null, $agent_type){
		if($agent_id or $currencynr)
		{
			$data = $this->_db->query("select * from agent_accounts where status = 1 and agent_type = ".$agent_type." agent_id = ".$agent_id." and currencynr = ".$currencynr);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}


	public function find2($agent_id = null, $currencynr = null){
		if($agent_id or $currencynr)
		{
			//$field = (is_numeric($agentaccounts)) ? 'id' : 'agentid';
			if($agent_id)
			{ 
				$field = 'agent_id';
				$data = $this->_db->get('agent_accounts', array($field,'=',$agent_id));
			}
			if($currencynr)
			{
				$data = $this->_db->query("select * from agent_accounts where status = 1 and agent_id = ".$agent_id." and currencynr = ".$currencynr);
			}
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function findm2($agent_id = null, $currencynr = null){
		if($agent_id or $currencynr)
		{
			//$field = (is_numeric($agentaccounts)) ? 'id' : 'agentid';
			if($agent_id)
			{ 
				$field = 'agent_id';
				$data = $this->_db->get('agent_accounts', array($field,'=',$agent_id));
			}
			if($currencynr)
			{
				$data = $this->_db->query("select * from agent_accounts where status = 1 and agent_type = 2 and agent_id = ".$agent_id." and currencynr = ".$currencynr);
			}
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function findfromagent($agent_id = null, $currencynr = null){
		if($agent_id or $currencynr)
		{
			//$field = (is_numeric($agent_id) ? 'agent_id' : 'agentid');
			$data = $this->_db->query("select * from agent_accounts where status = 1 and agent_type = 1 and agentid = '".$agent_id."' and currencynr = ".$currencynr);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findfromman($agent_id = null, $currencynr = null){
		if($agent_id or $currencynr)
		{
			//$field = (is_numeric($agent_id) ? 'agent_id' : 'agentid');
			$data = $this->_db->query("select * from agent_accounts where status = 1 and agent_type = 2 and agentid = '".$agent_id."' and currencynr = ".$currencynr);
			
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