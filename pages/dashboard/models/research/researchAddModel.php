<?php

class ResearchAddModel extends Dashboard {

	public function __construct() {

		if(isset($_POST["action"])){
			foreach ($_POST as $key => $value) {
				if(!trim($value) && $key != "dateEnded"){
					echo "$key is empty!<br>";
					die();
				}
			}

			if($_POST["action"] === "post") {
				self::ParseInput($_POST);
			} else {
				self::PreviewEntry($_POST);
			}
		}
	}

	private function ParseInput($formData){



		$dateStart = explode("/", $formData["dateStarted"]);
		$dateStart = date("Y-m-d H:i:s T", strtotime($dateStart[1]."/".$dateStart[0]."/".$dateStart[2]));

		$dateEnd = null;

		if($formData["dateEnded"] != null) {
			$dateEnd = explode("/", $formData["dateEnded"]);
			$dateEnd = date("Y-m-d H:i:s T", strtotime($dateEnd[1]."/".$dateEnd[0]."/".$dateEnd[2]));	
		}

		$newsItem = array(
			"title" => $formData["title"],
			"dateStarted" => $dateStart,
			"dateEnded" => $dateEnd,
			"short_body" => self::format_short($formData["body"]),
			"full_body" => trim($formData["body"])
		);

		$result = self::InsertIntoDatabase($newsItem);

		if($result != false){
			Main::$pageData["researchLink"] = Main::UrlifyArticleTitle($formData["title"],$result[0]["researchID"]);
		}
	}


	private function format_short($bodyText) {

		preg_match_all('/(.){250}/s',trim($bodyText),$someMatch);
		array_filter($someMatch);

		if(isset($someMatch[0][0])){
			return trim($someMatch[0][0]);
		} else {
			return trim($bodyText);
		}

	}

	private function InsertIntoDatabase($data) {

		$db = Dashboard::$sys->DatabaseSystem();

		$sql = "INSERT INTO `research`(
					`title`,
					`dateStarted`,
					`dateEnded`,
					`short_body`,
					`full_body`
				) VALUES (
					:title,
					:dateStarted,
					:dateEnded,
					:short_body,
					:full_body
				)";
		$params = $data;
		if($db->Insert($sql,$params)){
			return $db->Query(
				"SELECT `researchID` FROM `research` WHERE `title` = :title AND `dateStarted` = :dateStarted",
				array(
					"title"=>$data["title"],
					"dateStarted" => $data["dateStarted"]
					)
				);
		} else {
			return false;
		}
	}

	private function PreviewEntry($data) {
		$Markdown = new Parsedown();
		Main::$pageData["researchPreview"] = $Markdown->text($data["body"]);

		self::GenerateToC($data);
	}

	// gets all headers and generates a toc based on their location in the text
	private function GenerateToC($data) {

		$headers = array();

		for($i = 1; $i <= 6; $i++) {
			$re = "/^#{".$i."}([\w|\s].*?)$/m"; 
			preg_match_all($re, $data["body"], $matches,PREG_OFFSET_CAPTURE);
			
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

		Main::$pageData["ToC"] = $headers;

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