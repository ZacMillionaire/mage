<ul class="side-menu">

	<li class="menu-item">
		<a href="/mage/">Home</a>
	</li>
	<li class="menu-item">
		<a href="/mage/news/">News</a>
	</li>
	<?php if(!$Main->UserStatus["loggedIn"]) { ?>
	<li class="menu-item">
		<a href="/mage/login/">Login</a><!--<a href="register">Register</a>-->
	</li>

	<?php } elseif($Main->UserStatus["loggedIn"]) { ?>
	<li class="menu-item">
		<a href="/mage/logout/">Logout</a>
	</li>
	<li class="menu-separator">
		Admin
	</li>
	<li class="menu-item">
		<a href="/mage/dashboard/">Dashboard</a>
	</li>
	<?php } ?>
</ul>