<?php 

class ResearchListModel extends Dashboard {

	protected static $db; 

	public function __construct(){
		self::$db = parent::$sys->DatabaseSystem();
		$actions = parent::ParseAction();

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

		parent::$pageData["researchList"] = $result;
	}

}

?>