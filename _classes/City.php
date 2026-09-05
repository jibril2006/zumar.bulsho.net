<?php

class City {
	
	private $_db,
			$_data;
	
	public function __construct($city = null){
		$this->_db = DB::getInstance();		
		if($city) {
			$this->find($city);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('cities',$id,$fields)){
			throw new Exception('There was a problem updating the city.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('cities',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($city = null){
		if($city){
			$field = (is_numeric($city)) ? 'id' : 'formhash';
			$data = $this->_db->get('cities', array($field,'=',$city));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcityname($city = null){
		if($city){
			$field = 'cityname';
			$data = $this->_db->get('cities', array($field,'=',$city));
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