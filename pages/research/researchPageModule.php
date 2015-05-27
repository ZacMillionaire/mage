<?php

class Research extends Main {

	private static $basePath;
	protected static $db, $pageData; 
	
	public function LoadView($sys) {

		self::$basePath = get_include_path();
		
		$sys->SetPageTitle("Research");

		self::$db = $sys->DatabaseSystem();

		$actions = parent::ParseActions(2);

		if(isset($actions[0]) && $actions[0] == "p") {

			@$page = (isset($actions[1])) ? $actions[1] : 1;
			self::$pageData["currentPage"] = $page;
			self::GetResearchEntryList($page);
			include "research-page.php";

		} elseif($actions == "default") {

			@$page = (isset($actions[0]) && $actions[0] == "p") ? $actions[1] : 1;
			self::$pageData["currentPage"] = $page;
			self::GetResearchEntryList($page);
			include "research-page.php";

		} else {

			$requestUrl = explode("/",$_SERVER["REQUEST_URI"]);

			// reduce the url to words only, removing all empty (false) values
			// php has a dumb eval system though, so this'll probably break
			$requestUrl = array_reverse(array_values(array_filter($requestUrl)));
			$researchID = array_reverse(explode("-", $requestUrl[0]));
			self::GetNewsArticle($researchID[0]);
			include "research-entry.php";

		}


	}

	private function GetResearchEntryList($page) {

		$perPage = 5;

		$sql = "SELECT *,(SELECT COUNT(`researchID`) FROM `research`) as `entries` FROM `research` ORDER BY `researchID` DESC LIMIT :lower, :upper;";
		$params = array(
			"lower" => $perPage*($page-1),
			"upper" => $perPage+($perPage*($page-1))
			);

		$result = self::$db->Query($sql,$params);

		$Markdown = new Parsedown();
		foreach($result as $key => $value) {

			$result[$key]["overflow"] = "";
			if(strlen($result[$key]["full_body"]) > 800){
				$result[$key]["full_body"] = $Markdown->text(substr($result[$key]["full_body"],0, 800))."...";
				$result[$key]["overflow"] = "overflow";
			}

		}

		self::$pageData["researchEntriesList"] = $result;
		self::$pageData["entries"] = $result[0]['entries'];
		self::$pageData["pages"] = ceil(self::$pageData["entries"]/$perPage);
	}

	private function GetNewsArticle($researchID) {

		$sql = "SELECT * FROM `research` WHERE `researchID` = :researchID;";
		$params = array(
			"researchID" => $researchID
			);

		$result = self::$db->Query($sql,$params);

		self::$pageData["ToC"] = Main::GenerateToC($result[0]["full_body"]);

		$Markdown = new Parsedown();
		$result[0]["full_body"] = $Markdown->text($result[0]["full_body"]);

		self::$pageData["researchEntry"] = $result[0];

	}

}


?>