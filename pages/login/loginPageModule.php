<?php

class Login {

	private static $basePath;
	
	public function LoadView($sys) {

		self::$basePath = get_include_path();

		$Login["status"] = "default";

		if(empty($_POST) && !$sys->UserStatus["loggedIn"]) {

			$Login["showForm"] = true;

		} else {

			if(!$sys->UserStatus["loggedIn"]) {

				$LoginStatus = $sys->UserSystem->LoginUser($_POST["email"],$_POST["password"]);

				if($LoginStatus === true) {

					$Login["showForm"] = false;
					$Login["status"] = "success";

					$sys->Layout["showNavigation"] = false;

					header("refresh: 5; url=http://".$_SERVER["HTTP_HOST"].self::$basePath."/");

				} else {

					$Login["showForm"] = true;
					$errorMessage = $sys->GetErrorDetails($LoginStatus["error"]);

				}

			} elseif($sys->UserStatus["loggedIn"]) {
				$Login["showForm"] = false;
			}

		}

		$sys->SetPageTitle("Login");

		include "login-page.php";

	}
}


?>