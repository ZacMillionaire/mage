<?php

// parent refers to Dashboard obv
// all views access pageData via self::$pageData
class NewsDeleteModel extends Dashboard {

	protected static $db;

	public function __construct() {

		self::$db = parent::$sys->DatabaseSystem();
		$actions = parent::ParseAction();
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
			parent::$pageData["error"] = "Article not found";
		} else {
			$Markdown = new Parsedown();
			parent::$pageData["articleData"] = $result[0];
			parent::$pageData["articleData"]["full_body"] = $Markdown->text(parent::$pageData["articleData"]["full_body"]);
		}
	}

	private function DeleteArticle($articleID){

		$sql = "DELETE FROM `news` WHERE `newsID` = :newsID;";
		$params = array("newsID" => $articleID);

		$result = self::$db->Delete($sql,$params);

		parent::$pageData["deleted"] = true;

	}

}



?>