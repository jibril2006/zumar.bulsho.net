<?php

class Medicaltype {
	
	private $_db,
			$_data;
	
	public function __construct($medicaltype = null){
		$this->_db = DB::getInstance();		
		if($medicaltype) {
			$this->find($medicaltype);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('medicaltypes',$id,$fields)){
			throw new Exception('There was a problem updating the medicaltype.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('medicaltypes',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($medicaltype = null){
		if($medicaltype){
			$field = (is_numeric($medicaltype)) ? 'id' : 'formhash';
			$data = $this->_db->get('medicaltypes', array($field,'=',$medicaltype));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findmedicaltypename($medicaltype = null){
		if($medicaltype){
			$field = 'medicaltypename';
			$data = $this->_db->get('medicaltypes', array($field,'=',$medicaltype));
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