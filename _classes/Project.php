<?php

class Project {
	
	private $_db,
			$_data;
	
	public function __construct($project = null){
		$this->_db = DB::getInstance();		
		if($project) {
			$this->find($project);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('projects',$id,$fields)){
			throw new Exception('There was a problem updating the project.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('projects',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($project = null){
		if($project){
			$field = (is_numeric($project)) ? 'id' : 'formhash';
			$data = $this->_db->get('projects', array($field,'=',$project));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findprojectname($project = null){
		if($project){
			$field = 'projectname';
			$data = $this->_db->get('projects', array($field,'=',$project));
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