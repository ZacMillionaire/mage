<?php

// parent refers to Dashboard obv
// all views access pageData via self::$pageData
class ResearchDeleteModel extends Dashboard {

	protected static $db;

	public function __construct() {

		self::$db = Dashboard::$sys->DatabaseSystem();
		$actions = Dashboard::ParseAction();
		self::GetResearchEntryData($actions[1]);

		if(isset($_POST["action"])){

			if($_POST["action"] === "delete" && isset($actions[1])) {

				if(isset(Main::$pageData["researchEntryData"])){
					self::DeleteResearchEntry($actions[1]);				
				} else {
					Main::$pageData["error"] = "Research Entry not found";
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
			Main::$pageData["error"] = "Research Entry not found";
		} else {
			$Markdown = new Parsedown();
			Main::$pageData["researchEntryData"] = $result[0];
			Main::$pageData["researchEntryData"]["full_body"] = $Markdown->text(Main::$pageData["researchEntryData"]["full_body"]);
		}
	}

	private function DeleteResearchEntry($researchID){

		$sql = "DELETE FROM `research` WHERE `researchID` = :researchID;";
		$params = array("researchID" => $researchID);

		$result = self::$db->Delete($sql,$params);

		Main::$pageData["deleted"] = true;

	}

}



?>