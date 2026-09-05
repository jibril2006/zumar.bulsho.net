<?php

class Topmenu {
	
	private $_db,
			$_data;
	private	$_count = 0;
	
	public function __construct($topmenu = null){
		$this->_db = DB::getInstance();		
		if($topmenu) {
			$this->find($topmenu);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('topmenu',$id,$fields)){
			throw new Exception('There was a problem updating the topmenu.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('topmenu',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($topmenu = null){
		if($topmenu){
			$field = (is_numeric($topmenu)) ? 'id' : 'formhash';
			$data = $this->_db->get('topmenu', array($field,'=',$topmenu));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findname($topmenu = null){
		if($topmenu){
			$field = 'href';
			$data = $this->_db->get('topmenu', array($field,'=',$topmenu));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}


	public function hasaccess($ROLEID,$topmenuname = null){
		if($ROLEID){
			$field = 'href';
			$sqlquery = "SELECT * FROM topmenupermissions pp, topmenu p WHERE pp.deleted = 0 and pp.topmenuid = p.id and p.href = '$topmenuname' and pp.roleid = $ROLEID order by pp.id DESC";
			$data = $this->_db->query($sqlquery);
			if($data->count()){
				$this->_data = $data->first();
				$this->_count = $data->count();
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

	public function count(){
		return $this->_count;
	}
	

}


?>