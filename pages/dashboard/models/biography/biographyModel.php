<?php

class BiographyModel extends Dashboard {

	protected static $db;

	public function LoadModel(){
		
		$actions = Dashboard::ParseAction();

		if($actions === "default"){

			include "biographyDefaultModel.php";
			$class = "biographyDefaultModel";
			new $class();
			Dashboard::IncludeView("biography/biographyDefaultView.php");	

		} elseif(isset($actions[0])) {
			if(
				is_file("pages/dashboard/views/biography/biography".ucfirst($actions[0]).".php")
				&&
				is_file("pages/dashboard/models/biography/biography".ucfirst($actions[0])."Model.php")
			) {

				include "biography".ucfirst($actions[0])."Model.php";
				$class = "biography".ucfirst($actions[0])."Model";
				new $class();

				Dashboard::IncludeView("biography/biography".ucfirst($actions[0]).".php");
			} else {
				print_r($actions);
				include "biographyDefaultModel.php";
				$class = "biographyDefaultModel";
				new $class();
				Dashboard::IncludeView("biography/biographyDefaultView.php");
			}
		}

	}

}

?>