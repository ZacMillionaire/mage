<?php 

class NewsEditModel extends Dashboard {

	protected static $db; 

	public function __construct(){

		self::$db = parent::$sys->DatabaseSystem();
		$actions = parent::ParseAction();
		self::GetArticleData($actions[1]);

		if(isset($_POST["action"])){
			foreach ($_POST as $key => $value) {
				if(!trim($value) && $key != "tags"){
					echo "$key is empty!<br>";
					die();
				}
			}

			if($_POST["action"] === "post") {
				self::ReParseInput($_POST);
			} else {
				self::PreviewArticle($_POST);
			}
		}


	}

	private function GetArticleData($articleID) {

		$sql = "SELECT * FROM `news` WHERE `newsID` = :newsID;";
		$params = array("newsID"=>$articleID);
		parent::$pageData["articleData"] = self::$db->Query($sql,$params)[0];
	}

	public function PreviewArticle($data) {
		$Markdown = new Parsedown();
		parent::$pageData["ArticlePreview"] = $Markdown->text($data["body"]);
	}

	public function ReParseInput($formData){

		$newsItem = array(
			"datePosted" => parent::$pageData["articleData"]["datePosted"],
			"title" => $formData["title"],
			"tags" =>$formData["tags"],
			"short_body" => self::format_short($formData["body"]),
			"full_body" => trim($formData["body"]),
			"newsID" => parent::$pageData["articleData"]["newsID"]
		);

		$result = self::UpdateArticleInDatabase($newsItem);

		if($result != false){
			parent::$pageData["articleLink"] = self::UrlifyArticleTitle($formData["title"],parent::$pageData["articleData"]["newsID"]);	
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

		$sql = "UPDATE `news` SET
					`datePosted` = :datePosted,
					`title` = :title,
					`tags` = :tags,
					`short_body` = :short_body,
					`full_body` = :full_body
				WHERE
					`newsID` = :newsID;";
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

}

?>