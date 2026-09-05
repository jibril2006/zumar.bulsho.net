<?php

class jobtype {
	
	private $_db,
			$_data;
	
	public function __construct($jobtype = null){
		$this->_db = DB::getInstance();		
		if($jobtype) {
			$this->find($jobtype);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('jobtypes',$id,$fields)){
			throw new Exception('There was a problem updating the jobtype.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('jobtypes',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($jobtype = null){
		if($jobtype){
			$field = (is_numeric($jobtype)) ? 'id' : 'formhash';
			$data = $this->_db->get('jobtypes', array($field,'=',$jobtype));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findjobtypename($jobtype = null){
		if($jobtype){
			$field = 'jobtypename';
			$data = $this->_db->get('jobtypes', array($field,'=',$jobtype));
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