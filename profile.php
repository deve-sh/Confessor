<?php
	session_start();
	require("inc/checker.php");
	require("inc/config.php");

	if($_SESSION['clogin']==false || !$_SESSION['cuserid'])
    {	// User not logged in.
		header("refresh:0;url=login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?> - Profile</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<?php
		include 'header.php';
	?>
	<main>
		
	</main>
</body>
</html>