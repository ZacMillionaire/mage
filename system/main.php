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

}

$Main = new Main();
$Router = new Router($Main);

//$Main->RegenerateCookie();

?>