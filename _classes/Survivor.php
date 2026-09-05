<?php

class Survivor {
	
	private $_db,
			$_lastinserid,
			$_data;
	
	public function __construct($survivor = null){
		$this->_db = DB::getInstance();		
		if($survivor) {
			$this->find($survivor);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('survivors',$id,$fields)){
			throw new Exception('There was a problem updating the survivor.');
			
		}
	}


	public function create($fields = array()){
		if($this->_db->insert('survivors',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	
	public function find($survivor = null){
		if($survivor){
			$field = (is_numeric($survivor)) ? 'id' : 'formhash';
			$data = $this->_db->get('survivors', array($field,'=',$survivor));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcontactnumber($survivor = null){
		if($survivor){
			$field = 'contactnumber';
			$data = $this->_db->get('survivors', array($field,'=',$survivor));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

public function findcode($survivor = null){
		if($survivor){
			$field = 'survivorcode';
			$data = $this->_db->get('survivors', array($field,'=',$survivor));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function delete($survivor = null){		
		$field = (is_numeric($survivor)) ? 'id' : 'formhash';
		$this->_db->delete('survivors', array($field,'=',$survivor));
		/*if(!$this->_db->delete('survivors', array($field,'=',$survivor)){
			throw new Exception('There was a problem updating the survivor.');
			
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