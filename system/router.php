<?php

	class Router {

		private static $systemObj;

		public function __construct($sys) {

			self::$systemObj = $sys;
			self::ParseRoute();
			
		}

		public function ParseRoute() {

			if(@!$this) {
				throw new Exception("Router called incorrectly: Must be a class instance.");
			}

			$requestUrl = explode("/",$_SERVER["REQUEST_URI"]);

			// reduce the url to words only, removing all empty (false) values
			// php has a dumb eval system though, so this'll probably break
			$requestUrl = array_values(array_filter($requestUrl));

			if(isset($requestUrl[1])){
				self::LoadModule($requestUrl[1]);
			} elseif(!isset($requestUrl[1])) {
				self::LoadModule("Index");
			} else {
				self::LoadModule("Index");
			}

				
		}

		private function LoadModule($page) {

			if(is_dir("pages/".strtolower($page))) {
				include "pages/".strtolower($page)."/".strtolower($page)."PageModule.php";
				call_user_func_array(array("$page","LoadView"),array(self::$systemObj));
			} else {
				include "pages/errors/404PageModule.php";
				call_user_func_array(array("Error","LoadView"),array(self::$systemObj));
			}

		}

	}

?>