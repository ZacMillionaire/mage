<?php

	require "system/main.php";

	$SystemSettings = $Main->GetSystemSettings();

	setcookie(
		"loginHash",
		"",
		time()-3600,
		$SystemSettings["dir"],
		$SystemSettings["host"]
	);

	header("Location: ./");
	
?>