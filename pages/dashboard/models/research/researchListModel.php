<?php 

class ResearchListModel extends Dashboard {

	protected static $db; 

	public function __construct(){
		self::$db = Dashboard::$sys->DatabaseSystem();
		$actions = Dashboard::ParseAction();

		@$actions[1] = (!isset($actions[1])) ? 0 : $actions[1];
		self::GetResearchList($actions[1]);

	}

	public function GetResearchList($page) {

		$sql = "SELECT *,(SELECT COUNT(`researchID`) FROM `research`) FROM `research` ORDER BY `researchID` DESC LIMIT :lower, :upper;";
		$params = array(
			"lower" => 20*$page,
			"upper" => 20+(20*$page)
			);

		$result = self::$db->Query($sql,$params);

		Main::$pageData["researchList"] = $result;
	}

}

?>