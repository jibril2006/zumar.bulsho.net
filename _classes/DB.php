<?php
class DB {
	private static 	$_instance = null; // Nony: Underscore is just to tell that these properties are private
		private 	$_pdo,  // Nony: represents the instanciated PDO object so we can use it elsewhere
	               	$_query, // Nony: the last query that is executed
	               	$_error = false, // Nony: represents if the query failed or not
	               	$_results, // Nony: will store the result set
	               	$_count = 0, // Nony: is there any results returned?
	               	$_lastinsertid,
	               	$_glsql = null;
	
	private function __construct(){
	  try{
			$host = Config::get('mysql/host');
			$db = Config::get('mysql/db');
			$port = Config::get('mysql/port');
			$dsn = 'mysql:host=' . $host . ';dbname=' . $db;
			if ($port !== null && $port !== false && $port !== '' && !is_array($port)) {
				$dsn .= ';port=' . $port;
			}
			$this->_pdo = new PDO($dsn, Config::get('mysql/username'), Config::get('mysql/password'));
	
	  }catch(PDOException $e){
			die($e->getMessage());
	  }
	
	}
	
	public static function getInstance() {
	        if(!isset(self::$_instance)) {
	                self::$_instance = new DB();
	        }
	        return self::$_instance;
	}
	
	public function query($sql, $params = array()) {
		$_glsql = $sql;
	  $this->_error = false;
	  if($this->_query = $this->_pdo->prepare($sql)) {
	    $x = 1;
	    if(count($params)) {
	      foreach($params as $param){
	      	$this->_query->bindValue($x, $param);
	      	$x++;
	      }
	    }
	
	    if($this->_query->execute()) {
	    	$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
	    	$this->_count = $this->_query->rowCount();
	    	$this->_lastinsertid = $this->_pdo->lastInsertId();
	    	//$this->_query->fetch(PDO::FETCH_ASSOC);
	    } else {
	            $this->_error = true;
      }
	  }
		// fetch( PDO::FETCH_OB );
	  return $this;
	}
	
	public function row($sql, $params = array()) {
		$_glsql = $sql;
	  $this->_error = false;
	  if($this->_query = $this->_pdo->prepare($sql)) {
	    $x = 1;
	    if(count($params)) {
	      foreach($params as $param){
	      	$this->_query->bindValue($x, $param);
	      	$x++;
	      }
	    }
	
	    if($this->_query->execute()) {
	    	$this->_results = $this->_query->fetch( PDO::FETCH_OB );
	    } else {
	            $this->_error = true;
      	}
	  }
		// fetch( PDO::FETCH_OB );
	  return $this->_results;
	}

	public function action($action, $table, $where = array()) {
	  if(count($where) === 3){
	    $operators = array('=', '>', '<', '>=', '<=');
	
	    $field          = $where[0];
	    $operator       = $where[1];
	    $value          = $where[2];
	
	    if(in_array($operator, $operators)) {
	      $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
	     
	      if(!$this->query($sql, array($value))->error()) {
	      	return $this;	
	      }
	    }
	  }
	  return false;
	}
	
	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}
	
	public function delete($table, $where) {
		return $this->action('DELETE', $table, $where);
	}

  public function insert($table, $fields = array()) {
	  if(count($fields)) {
      $keys = array_keys($fields);
    	$values = '';
    	$x = 1;

	    foreach ($fields as $field) {
	      $values .= '?';
	      if($x < count($fields)) {
	        $values .= ', ';
	
	      }
      	$x++;
	    }

    	$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

    	// ERRORCHECK ECHO SQL
    	$_SESSION["sql"] = $sql;

    	if(!$this->query($sql, $fields)->error()) {
      	return $sql;
	    }
	  }
	  return false;
  }
 
  public function update($table, $id, $fields) {
    $set = '';
    $x = 1;

    foreach ($fields as $name => $value) {
      $set .= "{$name} = ?";
      if($x < count($fields)) {
              $set .= ', ';
      }
      $x++;
    }

    //if ($table == "transactions") {
    //	$sql = "UPDATE {$table} SET {$set} WHERE transaction_id = {$id} ";
    //} else 

    $sql = "UPDATE {$table} SET {$set} WHERE id = {$id} ";
    $_SESSION["updsql"] = $sql;
   
    if(!$this->query($sql, $fields)->error()) {
      return true;
    }
    return false;
  }

  public function update2($table, $id, $fields, $idfield) {
    $set = '';
    $x = 1;

    foreach ($fields as $name => $value) {
      $set .= "{$name} = ?";
      if($x < count($fields)) {
              $set .= ', ';
      }
      $x++;
    }

    $sql = "UPDATE {$table} SET {$set} WHERE $idfield = {$id} ";
    $_SESSION["updsql"] = $sql;
   
    if(!$this->query($sql, $fields)->error()) {
      return true;
    }
    return false;
  }

  public function esql() {
    return $this->_glsql;
  }

  public function lastinsertid() {
    return $this->_lastinsertid;
  }
 
  public function results() {
    return $this->_results;
  }

  public function first() {
		return $this->results()[0];
  }

  public function error() {
		return $this->_error;
  }

  public function count() {
		return $this->_count;
  }
 
}

?>