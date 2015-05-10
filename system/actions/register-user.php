<?php

require "../main.php";

$RegisterSystem = $Main->GetRegistrationSystem();

$RegisterStatus = $RegisterSystem->RegisterUser($_POST["email"],$_POST["password"]);

if($RegisterStatus === true) {

	header("Location: ../../login.php");

} else {

	if($RegisterStatus["error"] === "EMAIL_IN_USE") {

		header("Location: ../../register.php?e=in_use");
		die();

	} elseif($RegisterStatus["error"] === "FIELD_NULL") {

		header("Location: ../../register.php?e=field_null");
		die();

	}

	header("Location: ../../register.php?e=general");
	die();

}


?>