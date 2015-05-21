<?php

class Index extends Main {

	private static $basePath;
	protected static $db, $pageData; 

	public function LoadView($sys) {

		self::$basePath = get_include_path();
		
		$sys->SetPageTitle("Index");

		self::$db = $sys->DatabaseSystem();

		self::GetLatestNews();

		include "front-page.php";
	}



	public function GetLatestNews() {

		$sql = "SELECT *,(SELECT COUNT(`newsID`) FROM `news`) FROM `news` ORDER BY `datePosted` DESC LIMIT 5;";
		$params = array();

		$result = self::$db->Query($sql,$params);

		$Markdown = new Parsedown();
		foreach($result as $key => $value) {

			$fullBody = $value["full_body"];

			$result[$key]["overflow"] = "";
			if(strlen($fullBody) > 800){
				$fullBody = substr($value["full_body"],0, 800)."...";
				$result[$key]["overflow"] = "overflow";
			}

			$result[$key]["full_body"] = $Markdown->text($fullBody);

		}

		self::$pageData["newsList"] = $result;
	}

}


?>