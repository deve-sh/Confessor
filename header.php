<?php
	session_start();
	// Header part of the web app.
	if($_SESSION['clogin']==true && $_SESSION['cuserid']){
		if(isset($_COOKIE['clogin'])){
			$_SESSION['cuserid'] = json_decode($_COOKIE['clogin'])[0]->id;
			$_SESSION['clogin'] = true;
		}
	}
?>
<header id="bodyheader">
	<div class="left">
		<a href="./index.php"><?php echo $appname; ?></a>
	</div>

	<div class="right">
		<?php
			if($_SESSION['clogin']==true && $_SESSION['cuserid']){
				// User Logged in Options.
				?>
					<a href="search.php" title="Search"><i class="fas fa-search"></i></a>
					&nbsp&nbsp
					<?php

					if(strpos($_SERVER['PHP_SELF'],'usercp.php')!=false)
						{
							echo "
								<a href=\"profile.php?userid={$_SESSION['cuserid']}\" title='User Profile'><i class=\"fas fa-user\"></i></a> &nbsp&nbsp";

							echo "<a href='changepass.php' title='Change Password'><i class=\"fas fa-user-lock\"></i></a> &nbsp&nbsp";

							echo "<a href='changeusername.php' title='Change Username'><i class=\"fas fa-user-tag\"></i></a>";
						}
						else{
							echo '<a href=\'usercp.php\' title=\'User CP\'><i class="fas fa-cog"></i></a>';
						}
				    ?>
					&nbsp&nbsp
					<a title='Logout' href="logout.php"><i class="fas fa-door-open"></i></a>
				<?php
			}
			else{
				// User Logged Out.
				?>
					<a href="login.php">Login</a>&nbsp&nbsp<a href="register.php">Register</a>
				<?php
			}
		?>

	</div>
</header>