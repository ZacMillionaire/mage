<?php

class NewsModel extends Dashboard {

	protected static $db;

	public function LoadModel(){
		
		$actions = parent::ParseAction();

		if($actions === "default"){

			include "newsDefaultModel.php";
			$class = "NewsDefaultModel";
			new $class();
			parent::IncludeView("news/newsDefaultView.php");	

		} elseif(isset($actions[0])) {
			if(
				is_file("pages/dashboard/views/news/news".ucfirst($actions[0]).".php")
				&&
				is_file("pages/dashboard/models/news/news".ucfirst($actions[0])."Model.php")
			) {

				include "news".ucfirst($actions[0])."Model.php";
				$class = "News".ucfirst($actions[0])."Model";
				new $class();

				parent::IncludeView("news/news".ucfirst($actions[0]).".php");
			} else {
				print_r($actions);
				include "newsDefaultModel.php";
				$class = "NewsDefaultModel";
				new $class();
				parent::IncludeView("news/newsDefaultView.php");
			}
		}

	}

}

?>