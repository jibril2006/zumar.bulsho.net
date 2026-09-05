<?php

class Office {
	
	private $_db,
			$_data;
	
	public function __construct($office = null){
		$this->_db = DB::getInstance();		
		if($office) {
			$this->find($office);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('offices',$id,$fields)){
			throw new Exception('There was a problem updating the office.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('offices',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($office = null){
		if($office){
			$field = (is_numeric($office)) ? 'id' : 'formhash';
			$data = $this->_db->get('offices', array($field,'=',$office));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findofficename($office = null){
		if($office){
			$field = 'officename';
			$data = $this->_db->get('offices', array($field,'=',$office));
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