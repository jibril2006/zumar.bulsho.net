<?php
class Token {
	public static function generate() {
		//Session::put(Config::get('session/token_name'), md5(uniqid()));
		$Tokenvalue = trim(Session::put(Config::get('session/token_name'), md5(uniqid())));
		return $Tokenvalue;
	}

	public static function check($token) {
		$tokenName =  Config::get('session/token_name');
		
			if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}
		
		return false;
		
	}

	public static function new($tokenname) {
		//Session::put(Config::get('session/token_name'), md5(uniqid()));
		if(Session::exists($tokenname)) {
			$Tokenvalue = Session::get($tokenname);
		} else {
			$Tokenvalue = trim(bin2hex(random_bytes(16)));
			Session::put($tokenname,$Tokenvalue);
		}
		
		return $Tokenvalue;
	}

	public static function verify($tokenname, $token) {
		if(Session::exists($tokenname) && $token === Session::get($tokenname)) {
			Session::delete($tokenname);
			return true;
		}		
		return false;
	}

	
}


?>