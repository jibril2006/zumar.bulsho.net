<?php

class Userpage {
	
	private $_db,
			$_data;
	
	public function __construct($page = null){
		$this->_db = DB::getInstance();		
		if($page) {
			$this->find($page);
		}
		
	}
	
	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('userpages',$id,$fields)){
			throw new Exception('There was a problem updating the page.');
			
		}
	}

	public function create($fields = array()){
		if(!$this->_db->insert('userpages',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	public function find($page = null){
		if($page){
			$field = (is_numeric($page)) ? 'id' : 'formhash';
			$data = $this->_db->get('userpages', array($field,'=',$page));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcode($page = null){
		if($page){
			$field = 'code';
			$data = $this->_db->get('userpages', array($field,'=',$page));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduserid($page = null){
		if($page){
			$field = 'userid';
			$data = $this->_db->get('userpages', array($field,'=',$page));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function delete($fields = array()){
		if(!$this->_db->delete('userpages',$fields)){
			throw new Exception('There was a problem deleting the right to page.');
			
		}
	}

	public function get($fields = array()){
		if(!$this->_db->get('userpages',$fields)){
			throw new Exception('There was a problem deleting the right to page.');
			
		}
	}
	
	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data(){
		return $this->_data;
	}
	

}


?>