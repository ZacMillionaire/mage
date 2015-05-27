<?php

// parent refers to Dashboard obv
// all views access pageData via self::$pageData
class ResearchDeleteModel extends Dashboard {

	protected static $db;

	public function __construct() {

		self::$db = parent::$sys->DatabaseSystem();
		$actions = parent::ParseAction();
		self::GetResearchEntryData($actions[1]);

		if(isset($_POST["action"])){

			if($_POST["action"] === "delete" && isset($actions[1])) {

				if(isset(parent::$pageData["researchEntryData"])){
					self::DeleteResearchEntry($actions[1]);				
				} else {
					parent::$pageData["error"] = "Research Entry not found";
				}

			} elseif($_POST["action"] === "cancel") {
				header("Location: /mage/dashboard/research/");
			}

		}
	}

	private function GetResearchEntryData($researchID) {

		$sql = "SELECT * FROM `research` WHERE `researchID` = :researchID;";
		$params = array("researchID"=>$researchID);

		$result = self::$db->Query($sql,$params);
		if(empty($result)) {
			parent::$pageData["error"] = "Research Entry not found";
		} else {
			$Markdown = new Parsedown();
			parent::$pageData["researchEntryData"] = $result[0];
			parent::$pageData["researchEntryData"]["full_body"] = $Markdown->text(parent::$pageData["researchEntryData"]["full_body"]);
		}
	}

	private function DeleteResearchEntry($researchID){

		$sql = "DELETE FROM `research` WHERE `researchID` = :researchID;";
		$params = array("researchID" => $researchID);

		$result = self::$db->Delete($sql,$params);

		parent::$pageData["deleted"] = true;

	}

}



?>