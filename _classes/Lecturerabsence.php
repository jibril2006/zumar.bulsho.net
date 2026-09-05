<?php

class Lecturerabsence {
	
	private $_db,
			$_data;
	
	public function __construct($lecturerabsence = null){
		$this->_db = DB::getInstance();		
		if($lecturerabsence) {
			$this->find($lecturerabsence);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('lecturerabsences',$id,$fields)){
			throw new Exception('There was a problem updating the lecturerabsence.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('lecturerabsences',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($lecturerabsence = null){
		if($lecturerabsence){
			$field = (is_numeric($lecturerabsence)) ? 'id' : 'formhash';
			$data = $this->_db->get('lecturerabsences', array($field,'=',$lecturerabsence));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findcode($lecturerabsence = null){
		if($lecturerabsence){
			$field = 'code';
			$data = $this->_db->get('lecturerabsences', array($field,'=',$lecturerabsence));
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