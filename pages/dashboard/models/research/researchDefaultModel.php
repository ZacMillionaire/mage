<?php

class ResearchDefaultModel extends Dashboard {

	protected static $db; 

	public function __construct(){
		self::$db = Dashboard::$sys->DatabaseSystem();
		self::GetResearchList();
	}

	public function GetResearchList($limit = 5) {

		$sql = "SELECT * FROM `research` ORDER BY `researchID` DESC LIMIT 0, :limit;";
		$params = array("limit" => $limit);

		Main::$pageData["researchList"] = self::$db->Query($sql,$params);
	}

}

?>