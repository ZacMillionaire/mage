<?php

class Dashboard {

	protected static $basePath, $sys, $subpage, $pageData;
	
	public function LoadView($sys) {

		self::$basePath = get_include_path();
		self::$sys = $sys;

		if(!$sys->UserStatus["loggedIn"]) {
			header("Location: ".self::$basePath);
		}

		self::$sys->Layout["showNavigation"] = false;

		self::$sys->SetPageTitle("Dashboard");

		self::ParseRoute();

		include "dashboard-page.php";
	}

	private function ParseRoute() {

		$requestUrl = explode("/",$_SERVER["REQUEST_URI"]);

		// reduce the url to words only, removing all empty (false) values
		// php has a dumb eval system though, so this'll probably break
		$requestUrl = array_values(array_filter($requestUrl));

		if(@$requestUrl[2]) {
			self::$sys->SetActivePage($requestUrl[2]);
			self::LoadModule($requestUrl[2]);
		} else {
			self::$sys->SetActivePage("index");
			self::IncludeView("dashboard-index.php");
		}

	}

	private function LoadModule($page) {

		$filePath = "pages/dashboard/models/".strtolower($page)."/".strtolower($page)."Model.php";
		if(is_file($filePath)) {
			self::$sys->SetPageSubTitle($page);
			include $filePath;
			call_user_func_array(array("$page"."Model","LoadModel"),array());
		} else {
			self::IncludeView("dashboard-missing.php");
		}

	}

	protected function ParseAction() {

		$requestUrl = explode("/",$_SERVER["REQUEST_URI"]);

		// reduce the url to words only, removing all empty (false) values
		// php has a dumb eval system though, so this'll probably break
		$requestUrl = array_values(array_filter($requestUrl));

		if(@$requestUrl[3]) {
			for($i = 0; $i < 3; $i++){
				array_shift($requestUrl);			
			}
			return $requestUrl;
		} else {
			return "default";
		}
	}

	protected function IncludeView($page) {
		self::$subpage = "views/".$page;
	}


}


?>