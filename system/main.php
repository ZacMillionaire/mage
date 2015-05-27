<?php
/*
9:20 PM - Rams: WHAT IS ONE WARNING AMONG BILLIONS
9:21 PM - hip musician w complicated shoes: you won't need compilers where we're going
 */
date_default_timezone_set('UTC');

// Lets makesure php isn't trying to fuck me
set_include_path(".");
require_once "config.php";
set_include_path($siteConfig["baseDir"]);

require_once "router.php";
require_once "inc/Database.php";
require_once "inc/User/UserSystem.php";

require_once "inc/MarkdownParser.php";

class Main {

	private static $dbConf, $siteConf, $pageTitle, $userSys;

	function __construct() {

		global $databaseDetails,$siteConfig;

		self::$dbConf = $databaseDetails;
		self::$siteConf = $siteConfig;

		$this->UserSystem = self::UserSystem();
		$this->UserStatus = $this->UserSystem->UserManagement->GetUserLoggedInStatus();

		$this->Layout = array("showNavigation" => true);
		$this->ActivePage = null;
		
	}

	public function DatabaseSystem() {


		$Database = new Database(
			self::$dbConf["host"],
			self::$dbConf["database"],
			self::$dbConf["user"],
			self::$dbConf["password"]
		);

		return $Database;
	}

	public function UserSystem() {
		return new UserSystem();
	}

	public function SystemSettings() {
		return array(
			"host" => self::$siteConf["host"],
			"dir" => self::$siteConf["baseDir"]
		);
	}

	public function GetErrorDetails($errorString) {
		$error = self::DatabaseSystem()->Query("SELECT * FROM `error_dictionary` WHERE `error_string` = :errorString;",array("errorString"=>$errorString));

		return $error[0];

	}

	public function RegenerateCookie() {
		$data = self::DatabaseSystem()->dbQuery("SELECT * FROM `users_loggedin` WHERE `cookieHash` = \"".$_COOKIE["loginHash"]."\";",null);
		print_r($data[0]);
		echo "<br />";
		echo strtotime($data[0]["login_timestamp"]);
		echo "<br />";
		echo time();
	}

	public function SetPageTitle($title) {
		self::$pageTitle = $title;
	}

	public function SetPageSubTitle($subtitle) {
		self::$pageTitle .= " - ".ucfirst($subtitle);
	}

	public function SetActivePage($page) {
		$this->ActivePage = $page;
	}

	public function GetPageTitle(){
		return self::$pageTitle;
	}

	public function LoadNavigation(){
		include "pages/fragments/navigation.php";
	}

	public function ParseActions($urlOffset) {

		$requestUrl = explode("/",$_SERVER["REQUEST_URI"]);

		// reduce the url to words only, removing all empty (false) values
		// php has a dumb eval system though, so this'll probably break
		$requestUrl = array_values(array_filter($requestUrl));

		if(@$requestUrl[$urlOffset]) {
			for($i = 0; $i < $urlOffset; $i++){
				array_shift($requestUrl);			
			}
			return $requestUrl;
		} else {
			return "default";
		}
	}

	public function AdjustDate($date,$time = true) {

		$datePosted = new DateTime($date,new DateTimeZone("Etc/GMT+10"));
		if($time){			
			return date("d/m/Y - h:mA",$datePosted->format("U"));
		}
		return date("d/m/Y",$datePosted->format("U"));

	}

	public function UrlifyArticleTitle($title,$databaseID) {
		$titleArray = preg_replace('/[^A-Za-z0-9-\s]/', '', $title);
		$titleArray = strtolower($title);
		$titleArray = preg_replace("/\s/", '-', $titleArray);
		return "$titleArray-$databaseID";
	}

	// gets all headers and generates a toc based on their location in the text
	public function GenerateToC($body) {

		$headers = array();

		for($i = 1; $i <= 6; $i++) {
			$re = "/^#{".$i."}([\w|\s].*?)$/m"; 
			preg_match_all($re, $body, $matches,PREG_OFFSET_CAPTURE);
			
			foreach ($matches[1] as $key => $value) {
				$header = array(
					"depth" => $i,
					"title" => trim($value[0]),
					"pos" => $value[1]
				);
				array_push($headers, $header);
			}		
		}

		uasort($headers, "self::HeaderSort");

		return $headers;

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

$Main = new Main();
$Router = new Router($Main);

//$Main->RegenerateCookie();

?>