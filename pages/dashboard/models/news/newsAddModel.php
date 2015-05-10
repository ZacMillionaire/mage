<?php

// parent refers to Dashboard obv
// all views access pageData via self::$pageData
class NewsAddModel extends Dashboard {

	public function __construct() {

		if(isset($_POST["action"])){
			foreach ($_POST as $key => $value) {
				if(!trim($value) && $key != "tags"){
					echo "$key is empty!<br>";
					die();
				}
			}

			if($_POST["action"] === "post") {
				self::ParseInput($_POST);
			} else {
				self::PreviewArticle($_POST);
			}
		}
	}

	public function ParseInput($formData){

		$newsItem = array(
			"datePosted" => date('Y-m-d H:i:s T', time()),
			"title" => $formData["title"],
			"tags" =>$formData["tags"],
			"short_body" => self::format_short($formData["body"]),
			"full_body" => trim($formData["body"])
		);

		$result = self::InsertIntoDatabase($newsItem);

		if($result != false){
			parent::$pageData["articleLink"] = self::UrlifyArticleTitle($formData["title"],$result[0]["newsID"]);	
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

	private function InsertIntoDatabase($data) {

		$db = parent::$sys->DatabaseSystem();

		$sql = "INSERT INTO `news`(
					`datePosted`,
					`title`,
					`tags`,
					`short_body`,
					`full_body`
				) VALUES (
					:datePosted,
					:title,
					:tags,
					:short_body,
					:full_body
				)";
		$params = $data;

		if($db->Insert($sql,$params)){
			return $db->Query(
				"SELECT `newsID` FROM `news` WHERE `title` = :title AND `datePosted` = :datePosted",
				array(
					"title"=>$data["title"],
					"datePosted" => $data["datePosted"]
					)
				);
		} else {
			return false;
		}
	}

	public function PreviewArticle($data) {
		$Markdown = new Parsedown();
		parent::$pageData["ArticlePreview"] = $Markdown->text($data["body"]);
	}

	private function UrlifyArticleTitle($title,$databaseID) {
		$titleArray = preg_replace('/[^A-Za-z0-9-\s]/', '', $title);
		$titleArray = strtolower($title);
		$titleArray = preg_replace("/\s/", '-', $titleArray);
		return "$titleArray-$databaseID";
	}

}



?>