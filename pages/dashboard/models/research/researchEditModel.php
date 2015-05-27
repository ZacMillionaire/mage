<?php 

class ResearchEditModel extends Dashboard {

	protected static $db; 

	public function __construct(){

		self::$db = parent::$sys->DatabaseSystem();
		$actions = parent::ParseAction();
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
		parent::$pageData["researchEntryData"] = self::$db->Query($sql,$params)[0];
	}

	public function PreviewEntry($data) {
		$Markdown = new Parsedown();
		parent::$pageData["researchPreview"] = $Markdown->text($data["body"]);
		self::GenerateToC($data);
	}

	public function ReParseInput($formData){

		$researchItem = array(
			"title" => $formData["title"],
			"dateStarted" => parent::$pageData["researchEntryData"]["dateStarted"],
			"dateEnded" => parent::$pageData["researchEntryData"]["dateEnded"],
			"short_body" => self::format_short($formData["body"]),
			"full_body" => trim($formData["body"]),
			"researchID" => parent::$pageData["researchEntryData"]["researchID"]
		);

		$result = self::UpdateArticleInDatabase($researchItem);

		if($result != false){
			parent::$pageData["researchEntryLink"] = self::UrlifyArticleTitle($formData["title"],parent::$pageData["researchEntryData"]["researchID"]);	
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

	private function UrlifyArticleTitle($title,$databaseID) {
		$titleArray = preg_replace('/[^A-Za-z0-9-\s]/', '', $title);
		$titleArray = strtolower($title);
		$titleArray = preg_replace("/\s/", '-', $titleArray);
		return "$titleArray-$databaseID";
	}

	// gets all headers and generates a toc based on their location in the text
	private function GenerateToC($data) {

		$headers = array();

		for($i = 1; $i <= 6; $i++) {
			$re = "/^#{".$i."}([\w|\s].*?)$/m"; 
			preg_match_all($re, $data["body"], $matches, PREG_OFFSET_CAPTURE);
			
			foreach ($matches[1] as $key => $value) {
				$header = array(
					"depth" => $i,
					"title" => trim($value[0]),
					"pos" => $value[1]
				);
				array_push($headers, $header);
			}		
		}

		uasort($headers, array($this,"HeaderSort"));

		parent::$pageData["ToC"] = $headers;

		//" <a href=\"#top\"><i class=\"fa fa-chevron-circle-up\"></i></a>"
	}

	private function HeaderSort($a,$b) {

		if($a["pos"] > $b["pos"]){
			return 1;
		} else  {
			return -1;
		}

	}

}

?>