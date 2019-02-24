<?php
	session_start();

	require 'inc/checker.php';
	require 'inc/config.php';

	if(isset($_COOKIE['clogin']) && $_SESSION['clogin']==true && $_SESSION['cuserid']){
		header("refresh:0;url=usercp.php");
		exit("<br><br>Already Logged In.<br><br>");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?> - User Login</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<?php
		include 'header.php';
	?>
	<main align='center'>
		<br><br><br>
		<form id="loginform" action="loggingin.php" method="POST">
			<h2>Login</h2>
			<input type="text" class="username" name="username" placeholder="Username" required/>
			<br/><br/>
			<input type="password" class="password" name="password" placeholder="Password" required/>
			<br/><br/>
			<button type="submit" class="">Login</button>
		</form>
		<br/><br/>
		<a href="register.php">Register</a> &nbsp&nbsp<a href='./index.php'>Home</a>
	</main>
	<?php
		include 'inc/scripts.php';
		include 'footer.php';
	?>
</body>
</html>