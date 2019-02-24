<?php
	session_start();

	include 'inc/checker.php';	// Check if the script is installed.
	
	include 'inc/config.php';

	if($_SESSION['clogin']==true && $_SESSION['cuserid'])
    {
		header("refresh:0;url=usercp.php");
        exit();
    }
    
	if(isset($_COOKIE['clogin'])){
		$_SESSION['cuserid'] = json_decode($_COOKIE['clogin'])[0]->id;
		$_SESSION['clogin']=true;
		header("refresh:0;url=usercp.php");
        exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?> - Register</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<?php include 'header.php'; ?>
	<main align='center'>
		<form id='loginform' action="registering.php" method="POST">
			<h2>Register</h2>
			<input type="text" name="name" placeholder="Name" required/><br/><br/>
			<input type="text" required name="username" placeholder="Username"><br/><br/>
			<input type="email" name="email" placeholder="Email" required/><br/><br/>
			<input type="password" name="password" placeholder="Password" required/><br/><br/>
			<button id="submitbutton">Register</button>
		</form>
		<br><br>
		<a href="index.php">Home</a> &nbsp&nbsp<a href="login.php">Login</a>
	</main>
	<?php include 'footer.php'; ?>
	<?php include 'inc/scripts.php'; ?>
</body>
</html>