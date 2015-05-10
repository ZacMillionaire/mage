<?php

require "../main.php";

$RegisterSystem = $Main->GetRegistrationSystem();

$LoginStatus = $RegisterSystem->LoginUser($_POST["email"],$_POST["password"]);

if($LoginStatus === true) {
		header("Location: ../../");
} else {
	print_r($LoginStatus);

	if($LoginStatus["error"] === "PASSWORD_INCORRECT") {

		header("Location: ../../login.php?e=bad_pw");
		die();

	} elseif($LoginStatus["error"] === "EMAIL_NOT_EXIST") {

		header("Location: ../../login.php?e=no_email");
		die();

	} elseif($LoginStatus["error"] === "FIELD_NULL") {

		header("Location: ../../login.php?e=field_null");
		die();

	}

	header("Location: ../../login.php?e=general");
	die();

}
?>