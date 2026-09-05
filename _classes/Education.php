<?php

class education {
	
	private $_db,
			$_data;
	
	public function __construct($education = null){
		$this->_db = DB::getInstance();		
		if($education) {
			$this->find($education);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('educations',$id,$fields)){
			throw new Exception('There was a problem updating the education.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('educations',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($education = null){
		if($education){
			$field = (is_numeric($education)) ? 'id' : 'formhash';
			$data = $this->_db->get('educations', array($field,'=',$education));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findeducationname($education = null){
		if($education){
			$field = 'educationname';
			$data = $this->_db->get('educations', array($field,'=',$education));
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