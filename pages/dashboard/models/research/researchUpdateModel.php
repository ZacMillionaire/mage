<?php 

class ResearchUpdateModel extends Dashboard {

	protected static $db; 

	public function __construct(){

		self::$db = Dashboard::$sys->DatabaseSystem();
		$actions = Dashboard::ParseAction();
		self::GetResearchEntryData($actions[1]);

		if(isset($_POST["action"])){
			foreach ($_POST as $key => $value) {
				if(!trim($value) && $key != "dateEnded"){
					echo "$key is empty!<br>";
					die();
				}
			}

			if($_POST["action"] === "post") {
				self::ReParseInput($_POST);
			} else {
				self::PreviewEntry($_POST);
			}
		}


	}

	private function GetResearchEntryData($researchID) {

		$sql = "SELECT * FROM `research` WHERE `researchID` = :researchID;";
		$params = array("researchID"=>$researchID);

		Main::$pageData["researchEntryData"] = self::$db->Query($sql,$params)[0];
	}

	public function PreviewEntry($data) {
		$Markdown = new Parsedown();
		Main::$pageData["updatePreview"] = $Markdown->text($data["updateBody"]);
	}

	public function ReParseInput($formData){

		Main::$pageData["researchEntryData"]["full_body"] .= "\n"."#".$formData["updateTitle"]."\n".$formData["updateBody"];

		$researchItem = array(
			"title" => Main::$pageData["researchEntryData"]["title"],
			"dateStarted" => Main::$pageData["researchEntryData"]["dateStarted"],
			"dateEnded" => Main::$pageData["researchEntryData"]["dateEnded"],
			"short_body" => self::format_short(Main::$pageData["researchEntryData"]["full_body"]),
			"full_body" => trim(Main::$pageData["researchEntryData"]["full_body"]),
			"researchID" => Main::$pageData["researchEntryData"]["researchID"]
		);

		$result = self::UpdateArticleInDatabase($researchItem);

		if($result != false){
			Main::$pageData["researchEntryLink"] = Main::UrlifyArticleTitle(Main::$pageData["researchEntryData"]["title"],Main::$pageData["researchEntryData"]["researchID"]);	
		} else {
			print_r($result);
		}
	}


	private function format_short($bodyText) {

		preg_match_all('/((.*?)\\n)/',trim($bodyText),$someMatch);
		array_filter($someMatch);

		if(isset($someMatch[0][0])){
			return trim($someMatch[0][0]);
		} else {
			return trim($bodyText);
		}

	}

	private function UpdateArticleInDatabase($data) {

		$db = parent::$sys->DatabaseSystem();

		$sql = "UPDATE `research` SET
					`title` = :title,
					`dateStarted` = :dateStarted,
					`dateEnded` = :dateEnded,
					`short_body` = :short_body,
					`full_body` = :full_body
				WHERE
					`researchID` = :researchID;";
		$params = $data;


		if($db->Update($sql,$params)){
			return true;
		} else {
			return false;
		}
	}

}

?>