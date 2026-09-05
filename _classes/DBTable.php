<?php

class DBTable {
	
	private $_param;
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($_param){
		$this->_db = DB::getInstance();
		//$this->_param = "gbvcases";
		if($_param) {
			$this->_param = $_param;
		}
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update($this->_param,$id,$fields)){
			throw new Exception('There was a problem updating the table.');
			
		}
	}

	public function update2($fields = array(), $id = null, $idfield = null){		
		if(!$this->_db->update($this->_param,$id,$fields,$idfield)){
			throw new Exception('There was a problem updating the table.');
			
		}
	}


	public function create($fields = array()){
		if($this->_db->insert($this->_param,$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new record.');
		}
	}

	
	public function find($dbtable = null){
		if($dbtable){
			$field = (is_numeric($dbtable)) ? 'id' : 'formhash';
			$data = $this->_db->get($this->_param, array($field,'=',$dbtable));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findid($dbtable, $idname){
		if($dbtable){
			$field = (is_numeric($dbtable)) ? $idname : 'formhash';
			$data = $this->_db->get($this->_param, array($field,'=',$dbtable));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findname($tablename,$dbtable = null){
		if($dbtable){
			$field = $tablename;
			$data = $this->_db->get($this->_param, array($field,'=',$dbtable));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcode($dbtable = null){
		if($dbtable){
			$field = 'code';
			$data = $this->_db->get($this->_param, array($field,'=',$dbtable));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findfield($dbtable, $field){
		if($dbtable && $field){
			$data = $this->_db->get($this->_param, array($field,'=',$dbtable));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function delete($dbtable = null){		
		$field = (is_numeric($dbtable)) ? 'id' : 'formhash';
		$this->_db->delete($this->_param, array($field,'=',$dbtable));
		/*if(!$this->_db->delete('dbtables', array($field,'=',$dbtable)){
			throw new Exception('There was a problem updating the dbtable.');
			
		}*/
	}

	public function lastinsertid(){
		return $this->_lastinserid;
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data(){
		return $this->_data;
	}
	

}


?>