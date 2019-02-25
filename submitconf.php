<?php
	session_start();

	require('inc/checker.php');	// Check if the script is installed.
    require('inc/config.php');	// Essentials.
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?> - Submitting Confession</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<?php include 'header.php'; ?>
	<main>
	<?php
		if(isset($_COOKIE['clogin']) && $_SESSION['clogin']==true && $_SESSION['cuserid']){
			$_SESSION['cuserid'] = json_decode($_COOKIE['clogin'])[0]->id;
			$_SESSION['clogin'] = true;
		}
		else{
			echo "<br><br>Not Logged In. Redirecting to Login Page.";
			header("refresh:2;url=login.php");
			exit();
		}
		
		// If user is logged in.

		$conf = $_POST['confession'];

		if(empty($conf)){
			echo "<br>No Confession Entered.<br>";
			header("refresh:2;url=".$_SERVER['HTTP_REFERER']."");
			exit();
		}
		else{

			// Checking if the link the user came from is valid.

			if(strpos($_SERVER['HTTP_REFERER'],"profile.php")==false){
				echo "<br>Invalid Referring Link.<Br>";
				exit();
			}

			// If not, then proceed.

			$conf = $db->escape($conf);	// Sanitising to prevent SQL Injection.

			$recid = $db->escape((string)$_SERVER['HTTP_REFERER'][strlen($_SERVER['HTTP_REFERER'])-1]);

			if($db->query("INSERT INTO ".$subs."confessions(sendid,recid,confession,showonprofile) VALUES('".$_SESSION['cuserid']."','".$recid."','".$conf."',0)")){
				echo "<br>Confession Successfully Submitted.<br>";
				header("refresh:2;url=".$_SERVER['HTTP_REFERER']."");
				exit();
			}
			else{
				echo "<br>Sorry. A Problem Occured.<br>";
			}
		}
	?>
	</main>
</body>
</html>