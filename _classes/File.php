<?php

class File{

	
	private $_supportedFormats = ['image/png','image/jpeg','image/jpg','image/gif','application/pdf','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/octet-stream','application/vnd.openxmlformats-officedocument.wordprocessingml.document','text/csv','text/plain','application/vnd.openxmlformats-officedocument.presentationml.presentation'];

	private $_imageFormats = ['image/png','image/jpeg','image/jpg','image/gif'];
	private $_videoFormats = ['image/png','image/jpeg','image/jpg','image/gif'];

	private $_documentFormats = ['application/pdf','application/vnd.openxmlformats-officedocument.wordprocessingml.document','text/plain','application/vnd.openxmlformats-officedocument.presentationml.presentation','application/msword'];
	private $_excelFormats = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','text/csv','application/octet-stream'];

	private $_allowed_extensions = array('.mbz','.txt','.csv','.htm','.html','.xml','.css','.doc','.docx','.xls','.xlsx','.rtf','.ppt','.pptx','.pdf','.swf','.flv','.avi','.wmv','.mov','.jpg','.jpeg','.gif','.png','.mp3','.aac','.ogg','.mov','.mp4','.mkv');

	private $_allowed_ext = array('mbz','txt','csv','htm','html','xml','css','doc','docx','xls','xlsx','rtf','ppt','pptx','pdf','swf','flv','avi','wmv','mov','jpg','jpeg','gif','png','mp3','aac','ogg','mov','mp4','mkv');

	private $_db,
			$_extension,
			$_filename,
			$_humanfiletype,
			$_newfilename,
			$_filesize,
			$_lastinserid,
			$_allowed_byextension,
			$_allowed_byformat,
			$_humanfilesize,
			$_data;

		
	public function __construct($uploadfile = null){
		$this->_db = DB::getInstance();		
		if($uploadfile) {
			$this->find($uploadfile);
		}
		
	}

	public function uploadfile($folder, $file, $fileinfo){
		ini_set('post_max_size', '128M');
		ini_set('upload_max_filesize', '128M');

		if (is_array($file)) {

			// print_r($file);

			if (in_array($file['type'], $this->_supportedFormats)) {

				move_uploaded_file($file['tmp_name'], $folder.'/'.$fileinfo['newfilename']);
				return true;
				
			} else {
				return false;
			} 


		} else {
			return false;
		}

	}

	public function isimage($file) {
		if (is_array($file)) {
			if (in_array($file['type'], $this->_imageFormats)) {
				$this->_humanfiletype = 'image';
				return true;
			} else { return false; }
		} else { return false; }
	}

	public function isdocument($file) {
		if (is_array($file)) {
			if (in_array($file['type'], $this->_documentFormats)) {
				$this->_humanfiletype = 'document';
				return true;
			} else { return false; }
		} else { return false; }
	}

	public function isexcel($file) {
		if (is_array($file)) {
			if (in_array($file['type'], $this->_excelFormats)) {
				$this->_humanfiletype = 'excel';
				return true;
			} else { return false; }
		} else { return false; }
	}

	public function isvideo($file) {
		if (is_array($file)) {
			if (in_array($file['type'], $this->_videoFormats)) {
				$this->_humanfiletype = 'video';
				return true;
			} else { return false; }
		} else { return false; }
	}	

	public function fileinfo($file) {
		$this->isimage($file);
		$this->isexcel($file);
		$this->isdocument($file);
		$this->create_string($filesize);
		$filename   =   $file["name"];
		$filesize   =   $file["filesize"];
		$fLength    =   strlen($filename);
		$exParts    =   explode(".",$filename);
		$totalParts =   count($exParts);
		$extension  =   $exParts[$totalParts-1];
		$eLength    =   strlen($extension);
		$filename   =   substr($filename,0,($fLength-$eLength-1));
		$filename 	= preg_replace("/[^a-zA-Z0-9]+/", "-", $filename);
		$filename   =   strtolower($filename).'_'.date('Hjs');
		$thumpfilename   =  'thump_'.$filename;
	    $newfilename = $filename.'.'.$extension;
	    $humanfilesize = $this->create_string($filesize);

	    if (is_array($file)) {
			if (in_array($extension, $this->_allowed_ext)) {
				$this->_allowed_byextension = 1;
			} else { 
				$this->_allowed_byextension = 0;
			}
		} else { 
			$this->_allowed_byextension = 0;
		}

		$fileinfo = array(
		'humanfiletype' => $this->_humanfiletype,
		'filetype' => $file['type'],
		'extension'  =>   $extension,
		'filename'   =>   $filename,
		'filesize' => $filesize,
		'humanfilesize' => $this->_humanfilesize,
		'allowed' => $this->_allowed_byextension,
		'thumpfilename'   =>   $thumpfilename.'.'.$extension,
	    'newfilename' => $filename.'.'.$extension
	    );
		return $fileinfo;
	}

	public function create_string($size) {
		$piece = str_repeat("0", 1024);
		$str = "";
		$reps = $size / 1024;
		$rem = $size - 1024 * $reps;
		for ( $i = 0; $i < $reps; $i++ ) $str .= $piece;
		$str .= substr($piece, 0, $rem);
		$this->_humanfilesize = $str;
		return $str;
	}

	public function clean_name($label) {
		$clean = sanitize_file_name($label);
		$search = array ( '@[^a-zA-Z0-9._]@' );	 
		$replace = array ( '-' );
		$clean =  preg_replace($search, $replace, remove_accents($clean));
		return $clean;
	}


	public function createfolder($target) {
	    if(!is_dir($target))
		{
		$oldmask=umask(0);
		mkdir($target,0755);
		umask($oldmask);
		}
	}


	// ------------------- # # ----------------------------------------------------------- # # ----

	public function update($fields = array(), $id = null){		
		if(!$this->_db->update('uploadfiles',$id,$fields)){
			throw new Exception('There was a problem updating the uploadfile.');
			
		}
	}

	public function create($fields = array()){
		if($this->_db->insert('uploadfiles',$fields)){
			$this->_lastinserid = $this->_db->lastinsertid();
		} else {
			throw new Exception('There was a problem creating the new account.');
		}
	}

	public function find($uploadfile = null){
		if($uploadfile){
			$field = (is_numeric($uploadfile)) ? 'id' : 'formhash';
			$data = $this->_db->get('uploadfiles', array($field,'=',$uploadfile));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function lastinsertid(){
		return $this->_lastinserid;
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data(){
		return $this->_data;
	}


}

?>