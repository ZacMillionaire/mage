<?php

ob_start();
require "system/main.php";
$content = ob_get_contents();
ob_end_clean();
ob_end_flush();
?>
<!doctype html>
<html lang="en" id="top">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--<base href="/mage/">-->
		<title><?php echo $Main->GetPageTitle(); ?> &bull; Mage</title>
		<link rel="stylesheet" href="/mage/styles/style.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	</head>
	<body>
		<?php
			//include "pages/fragments/header.php";
		?>
		<div id="site-width-container">

			<?php if($Main->Layout["showNavigation"]) { ?>

			<div id="main-navigation-container">
				<?php
					include "pages/fragments/navigation.php";
				?>
			</div>

			<?php } ?>
			
			<div id="main-content-container">
				<?php
					echo $content;
				?>
			</div>
		</div>
		<?php
			//include "pages/fragments/footer.php";
		?>
	</body>
</html>