<?php

class Page {
	
	private $_db,
			$_data;
	private	$_count = 0;
	
	public function __construct($page = null){
		$this->_db = DB::getInstance();		
		if($page) {
			$this->find($page);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('pages',$id,$fields)){
			throw new Exception('There was a problem updating the page.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('pages',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($page = null){
		if($page){
			$field = (is_numeric($page)) ? 'id' : 'formhash';
			$data = $this->_db->get('pages', array($field,'=',$page));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function findname($page = null){
		if($page){
			$field = 'href';
			$data = $this->_db->get('pages', array($field,'=',$page));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}


	public function hasaccess($ROLEID,$pagename = null){
		if($ROLEID){
			$field = 'href';
			$sqlquery = "SELECT * FROM pagepermissions pp, pages p WHERE pp.deleted = 0 and pp.pageid = p.id and p.href = '$pagename' and pp.roleid = $ROLEID order by pp.id DESC";
			$data = $this->_db->query($sqlquery);
			if($data->count()){
				$this->_data = $data->first();
				$this->_count = $data->count();
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

	public function count(){
		return $this->_count;
	}
	

}


?>