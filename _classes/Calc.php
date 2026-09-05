<?php
class Calc {
	
	private $_db,
					$_data,
					$_agent_accounts;
	
	public function __construct($user = null){
		$this->_db = DB::getInstance();
		$this->_agent_accounts = new Agent_accounts();

	}
	
	public function deposit($currencynr){
			$query = 'select SUM(balance) as total from agent_accounts where status = 1 and agent_type = 1 and balance > 0 and currencynr = ' . $currencynr;
			$data = $this->_db->query($query);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
			
		return false;
	}
	
	public function loan($currencynr){
			$query = 'select SUM(balance) as total from agent_accounts where status = 1 and agent_type = 1 and balance < 0 and currencynr = ' . $currencynr;
			$data = $this->_db->query($query);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
			
		return false;
	}
	
	public function mdeposit($currencynr){
			$query = "select sum(amount) as total from agent_transactions where status = 1 and agent_type = 2 and agent_id = 8 and type = 'deposit' and account_id = 23 and currencynr = " . $currencynr;
			$data = $this->_db->query($query);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
			
		return false;
	}
	
	public function mloan($currencynr){
			$query = "select balance as total from agent_transactions where status = 1 and agent_type = 2 and agent_id = 8 and account_id = 23 and currencynr = 2 ORDER BY id DESC LIMIT 1";
			$data = $this->_db->query($query);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
			
		return false;
	}
	
		public function ontransfer($currencynr){
			$query = "select SUM(AMOUNT) as total from agent_transactions where status = 1 and agent_type = 2 and agent_id = 8 and account_id = 23 and currencynr = 2 and ontransfer = 1";
			$data = $this->_db->query($query);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
			
		return false;
	}
	
	public function rate_profit($currencynr){
			$query = 'select SUM(rate_profit) as total from agent_accounts where status = 1 and agent_type = 1 and currencynr = ' . $currencynr;
			$data = $this->_db->query($query);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
			
		return false;
	}
	
	public function rate_balance($currencynr){
			$query = 'select SUM(rate_balance) as total from agent_accounts where status = 1 and agent_type = 1 and currencynr = ' . $currencynr;
			$data = $this->_db->query($query);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
			
		return false;
	}
	
	public function mrate_profit($currencynr){
			$query = 'select SUM(rate_profit) as total from agent_accounts where status = 1 and agent_type = 2 and currencynr = ' . $currencynr;
			$data = $this->_db->query($query);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
			}
			
		return false;
	}
	
	public function mrate_balance($currencynr){
			$query = 'select SUM(rate_balance) as total from agent_accounts where status = 1 and agent_type = 2 and currencynr = ' . $currencynr;
			$data = $this->_db->query($query);
			
			if($data->count())
			{
				$this->_data = $data->first();
				return true;
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