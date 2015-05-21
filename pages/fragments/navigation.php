<ul class="side-menu">

	<li class="menu-item">
		<a href="./">Home</a>
	</li>
	<li class="menu-item">
		<a href="news/">News</a>
	</li>
	<?php if(!$Main->UserStatus["loggedIn"]) { ?>
	<li class="menu-item">
		<a href="login/">Login</a><!--<a href="register">Register</a>-->
	</li>

	<?php } elseif($Main->UserStatus["loggedIn"]) { ?>
	<li class="menu-item">
		<a href="logout/">Logout</a>
	</li>
	<li class="menu-separator">
		Admin
	</li>
	<li class="menu-item">
		<a href="dashboard/">Dashboard</a>
	</li>
	<?php } ?>
</ul>