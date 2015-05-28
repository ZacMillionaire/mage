<?php 

class NewsListModel extends Dashboard {

	protected static $db; 

	public function __construct(){
		self::$db = Dashboard::$sys->DatabaseSystem();
		$actions = Dashboard::ParseAction();

		@$actions[1] = (!isset($actions[1])) ? 0 : $actions[1];
		self::GetNewsList($actions[1]);

	}

	public function GetNewsList($page) {

		$sql = "SELECT *,(SELECT COUNT(`newsID`) FROM `news`) FROM `news` ORDER BY `datePosted` DESC LIMIT :lower, :upper;";
		$params = array(
			"lower" => 20*$page,
			"upper" => 20+(20*$page)
			);

		$result = self::$db->Query($sql,$params);

		Main::$pageData["newsList"] = $result;
	}

}

?>