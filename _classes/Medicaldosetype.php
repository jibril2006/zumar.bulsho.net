<?php

class Medicaldosetype {
	
	private $_db,
			$_data;
	
	public function __construct($medicaldosetype = null){
		$this->_db = DB::getInstance();		
		if($medicaldosetype) {
			$this->find($medicaldosetype);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('medicaldosetypes',$id,$fields)){
			throw new Exception('There was a problem updating the medicaldosetype.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('medicaldosetypes',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($medicaldosetype = null){
		if($medicaldosetype){
			$field = (is_numeric($medicaldosetype)) ? 'id' : 'formhash';
			$data = $this->_db->get('medicaldosetypes', array($field,'=',$medicaldosetype));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findmedicaldosetypename($medicaldosetype = null){
		if($medicaldosetype){
			$field = 'medicaldosetypename';
			$data = $this->_db->get('medicaldosetypes', array($field,'=',$medicaldosetype));
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