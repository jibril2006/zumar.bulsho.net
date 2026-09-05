<?php

class Medicalsupplie {
	
	private $_db,
			$_data;
	
	public function __construct($medicalsupplie = null){
		$this->_db = DB::getInstance();		
		if($medicalsupplie) {
			$this->find($medicalsupplie);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('medicalsupplies',$id,$fields)){
			throw new Exception('There was a problem updating the medicalsupplie.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('medicalsupplies',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($medicalsupplie = null){
		if($medicalsupplie){
			$field = (is_numeric($medicalsupplie)) ? 'id' : 'formhash';
			$data = $this->_db->get('medicalsupplies', array($field,'=',$medicalsupplie));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findmedicalsuppliename($medicalsupplie = null){
		if($medicalsupplie){
			$field = 'medicalsuppliename';
			$data = $this->_db->get('medicalsupplies', array($field,'=',$medicalsupplie));
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