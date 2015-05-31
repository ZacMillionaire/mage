<?php

class NewsDeleteModel extends Dashboard {

	protected static $db;

	public function __construct() {

		self::$db = Dashboard::$sys->DatabaseSystem();
		$actions = Dashboard::ParseAction();
		self::GetArticleData($actions[1]);

		if(isset($_POST["action"]) && isset($actions[1])){
			if($_POST["action"] === "delete") {
				self::DeleteArticle($actions[1]);
			} elseif($_POST["action"] === "cancel") {
				header("Location: /mage/dashboard/news/");
			}
		}
	}

	private function GetArticleData($articleID) {

		$sql = "SELECT * FROM `news` WHERE `newsID` = :newsID;";
		$params = array("newsID"=>$articleID);

		$result = self::$db->Query($sql,$params);
		if(empty($result)) {
			Main::$pageData["error"] = "Article not found";
		} else {
			$Markdown = new Parsedown();
			Main::$pageData["articleData"] = $result[0];
			Main::$pageData["articleData"]["full_body"] = $Markdown->text(Main::$pageData["articleData"]["full_body"]);
		}
	}

	private function DeleteArticle($articleID){

		$sql = "DELETE FROM `news` WHERE `newsID` = :newsID;";
		$params = array("newsID" => $articleID);

		$result = self::$db->Delete($sql,$params);

		Main::$pageData["deleted"] = true;

	}

}



?>