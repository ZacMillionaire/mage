<?php

class News extends Main {

	private static $basePath;
	protected static $db; 
	
	public function LoadView($sys) {

		self::$basePath = get_include_path();
		
		$sys->SetPageTitle("News");

		self::$db = $sys->DatabaseSystem();

		$actions = parent::ParseActions(2);

		if(isset($actions[0]) && $actions[0] == "p") {

			@$page = (isset($actions[1])) ? $actions[1] : 1;
			Main::$pageData["currentPage"] = $page;
			self::GetNewsList($page);
			include "news-page.php";

		} elseif($actions == "default") {

			@$page = (isset($actions[0]) && $actions[0] == "p") ? $actions[1] : 1;
			Main::$pageData["currentPage"] = $page;
			self::GetNewsList($page);
			include "news-page.php";

		} else {

			$requestUrl = explode("/",$_SERVER["REQUEST_URI"]);

			// reduce the url to words only, removing all empty (false) values
			// php has a dumb eval system though, so this'll probably break
			$requestUrl = array_reverse(array_values(array_filter($requestUrl)));
			$newsID = array_reverse(explode("-", $requestUrl[0]));
			self::GetNewsArticle($newsID[0]);
			include "news-article.php";

		}


	}

	private function GetNewsList($page) {

		$perPage = 5;

		$sql = "SELECT *,(SELECT COUNT(`newsID`) FROM `news`) as `articles` FROM `news` ORDER BY `datePosted` DESC LIMIT :lower, :upper;";
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

		Main::$pageData["newsList"] = $result;
		Main::$pageData["articles"] = $result[0]['articles'];
		Main::$pageData["pages"] = ceil(Main::$pageData["articles"]/$perPage);
	}

	private function GetNewsArticle($newsID) {

		$sql = "SELECT * FROM `news` WHERE `newsID` = :newsID;";
		$params = array(
			"newsID" => $newsID
			);

		$result = self::$db->Query($sql,$params);

		Main::$pageData["ToC"] = Main::GenerateToC($result[0]["full_body"]);
		$Markdown = new Parsedown();
		$result[0]["full_body"] = $Markdown->text($result[0]["full_body"]);

		Main::$pageData["article"] = $result[0];
	}

}


?>