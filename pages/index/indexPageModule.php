<?php

class Index {

	private static $basePath;
	
	public function LoadView($sys) {

		self::$basePath = get_include_path();
		
		$sys->SetPageTitle("Index");

		include "front-page.php";
	}
}


?>