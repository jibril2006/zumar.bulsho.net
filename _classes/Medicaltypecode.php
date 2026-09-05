<?php

class Medicaltypecode {
	
	private $_db,
			$_data;
	
	public function __construct($medicaltypecode = null){
		$this->_db = DB::getInstance();		
		if($medicaltypecode) {
			$this->find($medicaltypecode);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('medicaltypecodes',$id,$fields)){
			throw new Exception('There was a problem updating the medicaltypecode.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('medicaltypecodes',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($medicaltypecode = null){
		if($medicaltypecode){
			$field = (is_numeric($medicaltypecode)) ? 'id' : 'formhash';
			$data = $this->_db->get('medicaltypecodes', array($field,'=',$medicaltypecode));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findmedicaltypecodename($medicaltypecode = null){
		if($medicaltypecode){
			$field = 'medicaltypecodename';
			$data = $this->_db->get('medicaltypecodes', array($field,'=',$medicaltypecode));
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