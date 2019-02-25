<?php
	session_start();
	require("inc/checker.php");
	require("inc/salt.php");
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
	<title><?php echo $appname; ?> - Change Username</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<?php include 'header.php'; ?>
	<main align='center'>
		<br><br>
		<form action="" method="POST" id="loginform">
			<h3>Change Username</h3>
			<input type="text" placeholder="New Username" name="newpass" required><br><br>
			<input type="text" placeholder="Confirm Username" name="confpass" required><br><br>
			<button type="submit">Change Username</button>
		</form>
		<?php
			// Script to update the username.

			// Taking the user inputs.

			$newpass = $db->escape($_POST['newpass']);
			$confpass = $db->escape($_POST['confpass']);

			// Checking if the old username is correct.

			if($newpass && $confpass){
				$query1 = $db->query("SELECT * FROM ".$subs."users WHERE username='".$newpass."'");

				if($db->numrows($query1)>0){
					// If a user with the same username already exists.

					echo "<br><br>User with the same username already exists.<br> Try Another Name.";
				}
				else{
					if(strcmp($newpass,$confpass)!=0){	// If the new usernames match.
						echo "<br><br>New usernames do not match.<br>";
					}
					else{
						// Now Updating the username and salt for the user.

						if($db->query("UPDATE ".$subs."users SET username='".$newpass."' WHERE userid='".$_SESSION['cuserid']."'")){
							echo "<br><br>Username Successfully Updated. You will be logged out.<br>";
							header("refresh:2;url=logout.php");
							exit();
						}
						else{
							echo "<br><br>A Problem Occurred. Please Try Again.<br>";
						}
					}
				}
			}
		?>
	</main>
	<?php include 'footer.php'; ?>
</body>
</html>