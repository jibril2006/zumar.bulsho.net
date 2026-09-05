<?php

class Month {
	
	private $_db,
			$_data;
	
	public function __construct($month = null){
		$this->_db = DB::getInstance();		
		if($month) {
			$this->find($month);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('months',$id,$fields)){
			throw new Exception('There was a problem updating the month.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('months',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($month = null){
		if($month){
			$field = (is_numeric($month)) ? 'id' : 'formhash';
			$data = $this->_db->get('months', array($field,'=',$month));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

public function findcode($month = null){
		if($month){
			$field = 'survivorcode';
			$data = $this->_db->get('months', array($field,'=',$month));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function delete($month = null){		
		$field = (is_numeric($month)) ? 'id' : 'formhash';
		$this->_db->delete('months', array($field,'=',$month));
		/*if(!$this->_db->delete('months', array($field,'=',$month)){
			throw new Exception('There was a problem updating the month.');
			
		}*/
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data(){
		return $this->_data;
	}
	

}


?>