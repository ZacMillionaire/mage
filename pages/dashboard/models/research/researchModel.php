<?php
class researchModel extends Dashboard {

	protected static $db;

	public function LoadModel(){
		
		$actions = parent::ParseAction();

		if($actions === "default"){

			include "researchDefaultModel.php";
			$class = "researchDefaultModel";
			new $class();
			parent::IncludeView("research/researchDefaultView.php");	

		} elseif(isset($actions[0])) {
			if(
				is_file("pages/dashboard/views/research/research".ucfirst($actions[0]).".php")
				&&
				is_file("pages/dashboard/models/research/research".ucfirst($actions[0])."Model.php")
			) {

				include "research".ucfirst($actions[0])."Model.php";
				$class = "research".ucfirst($actions[0])."Model";
				new $class();

				parent::IncludeView("research/research".ucfirst($actions[0]).".php");
			} else {
				echo "Model not found. Default view loaded.<br>";
				print_r($actions);
				include "researchDefaultModel.php";
				$class = "researchDefaultModel";
				new $class();
				parent::IncludeView("research/researchDefaultView.php");
			}
		}

	}

}
?>