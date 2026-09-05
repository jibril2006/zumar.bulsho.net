<?php

class Lecturer {
	
	private $_db,
			$_data;
	
	public function __construct($lecturer = null){
		$this->_db = DB::getInstance();		
		if($lecturer) {
			$this->find($lecturer);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('users',$id,$fields)){
			throw new Exception('There was a problem updating the lecturer.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('users',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	public function delete($user = null){		
		$field = (is_numeric($lecturer)) ? 'id' : 'formhash';
		$this->_db->delete('users', array($field,'=',$lecturer));
		/*if(!$this->_db->delete('users', array($field,'=',$user)){
			throw new Exception('There was a problem updating the lecturer.');
			
		}*/
	}
	
	public function find($lecturer = null){
		if($lecturer){
			$field = (is_numeric($lecturer)) ? 'id' : 'formhash';
			$data = $this->_db->get('users', array($field,'=',$lecturer));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduser($lecturer = null){
		if($lecturer){
			$field = 'id';
			$data = $this->_db->get('users', array($field,'=',$lecturer));
			
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