<?php

class Region {
	
	private $_db,
			$_data;
	
	public function __construct($region = null){
		$this->_db = DB::getInstance();		
		if($region) {
			$this->find($region);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('regions',$id,$fields)){
			throw new Exception('There was a problem updating the region.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('regions',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($region = null){
		if($region){
			$field = (is_numeric($region)) ? 'id' : 'formhash';
			$data = $this->_db->get('regions', array($field,'=',$region));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findregionname($region = null){
		if($region){
			$field = 'regionname';
			$data = $this->_db->get('regions', array($field,'=',$region));
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