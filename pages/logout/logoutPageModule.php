<?php

class Logout {

	private static $basePath;
	
	public function LoadView($sys) {

		self::$basePath = get_include_path();

		$sys->SetPageTitle("Logout");
		
		if($sys->UserStatus["loggedIn"]===true){

			$SystemSettings = $sys->SystemSettings();

			setcookie(
				"loginHash",
				"",
				time()-3600,
				$SystemSettings["dir"],
				$SystemSettings["host"]
			);

			$Logout["loggedOut"] = true;
			$sys->UserStatus["loggedIn"] = false;

		} else {
			$Logout["loggedOut"] = false;
		}

		
		include "logout-page.php";

	}
}


?>