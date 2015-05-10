<?php

class NewsDefaultModel extends Dashboard {

	protected static $db; 

	public function __construct(){
		self::$db = parent::$sys->DatabaseSystem();
		self::GetNewsList();
	}

	public function GetNewsList($limit = 5) {

		$sql = "SELECT * FROM `news` ORDER BY `datePosted` DESC LIMIT 0, :limit;";
		$params = array("limit" => $limit);

		parent::$pageData["shortNewsList"] = self::$db->Query($sql,$params);
	}

}

?>