<div id="dashboard-container">
	<div id="dashboard-menu-container">
		<?php include "dashboard-menu.php" ?>
	</div>
	<div id="dashboard-content-container">
		<?php
			include self::$subpage;
		?>
	</div>
</div>