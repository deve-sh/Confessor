<?php
	session_start();

	require('inc/checker.php');
	require('inc/config.php');

	// Check if the user is logged in.

	if($_SESSION['clogin']==false || !$_SESSION['cuserid'])
    {	// User not logged in.
		header("refresh:0;url=login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?> - Show On Profile</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<main>
		<?php
			if(!$_GET['cid']){
				echo "<br>No Confession Passed.<br>";
				header("refresh:1;url=index.php");
				exit();
			}
			else{

				$cid = $db->escape($_GET['cid']);

				// Check if the confession exists with the user that is signed in.

				if($db->numrows($db->query("SELECT * FROM ".$subs."confessions WHERE cid='".$cid."' AND recid='".$_SESSION['cuserid']."'"))==0){
					echo "<br>You are either unauthorised or the confession does not exist. Redirecting to home.<br>";
					header("refresh:4;url=index.php");
					exit();
				}
				else{
					// If all the above tests passed. Show the confession on the user's profile.

					if($db->query("UPDATE ".$subs."confessions SET showonprofile=0 WHERE cid='".$cid."' AND recid='".$_SESSION['cuserid']."'")){
						echo "<br>Successfully Removed From Profile.<br>";
						header("refresh:1;url=usercp.php");
						exit();
					}
					else{
						echo "<br>An error occured. Please try again.<br>";
						header("refresh:1;url=usercp.php");
						exit();
					}
				}
			}
		?>
	</main>
</body>
</html>