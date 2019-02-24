<?php
	session_start();
	require 'inc/checker.php';
	require 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?> - Logging Out</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<main>
	<?php
		if(isset($_COOKIE['clogin']) && $_SESSION['clogin']==true && $_SESSION['cuserid']){

			// If user is already actually signed in.

			setcookie('clogin','[]',time()-84600*15);	// Remove the cookie.

			$_SESSION['clogin'] = false;
			$_SESSION['cuserid'] = 0;

			echo "<br><br>Successfully Logged out.<br>";
			header("refresh:1.5;url=index.php");
			exit();
		}else{
			echo "<br><br>Already Logged Out.<br><br>";
			header("refresh:1.5;url=index.php");
			exit();
		}
	?>
	</main>
</body>
</html>