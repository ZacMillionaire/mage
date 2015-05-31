<?php

class UserManagement extends UserSystem {

	function __construct() {}
	
	public function GetUserLoggedInStatus() {

		$status = array();

		if(isset($_COOKIE["loginHash"])){
			$status["loggedIn"] = true;
		} else {
			$status["loggedIn"] =  false;
		}

		return $status;

	}

}