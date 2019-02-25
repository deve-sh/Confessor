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
	<title><?php echo $appname; ?> - Change Password</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<?php include 'header.php'; ?>
	<main align='center'>
		<br><br>
		<form action="" method="POST" id="loginform">
			<h3>Change Password</h3>
			<input type="password" placeholder="Old Password" name="oldpass" required><br><br>
			<input type="password" placeholder="New Password" name="newpass" required><br><br>
			<input type="password" placeholder="Confirm Password" name="confpass" required><br><br>
			<button type="submit">Change Password</button>
		</form>
		<?php
			// Script to update the password.

			// Taking the user inputs.

			$oldpass = $db->escape($_POST['oldpass']);
			$newpass = $db->escape($_POST['newpass']);
			$confpass = $db->escape($_POST['confpass']);

			// Checking if the old password is correct.

			if($oldpass && $newpass && $confpass){
				$query1 = $db->query("SELECT * FROM ".$subs."users WHERE userid='".$_SESSION['cuserid']."'");

				$curuser = $db->fetch($query1);

				if(strcmp($curuser['password'],md5(crypt($oldpass,$curuser['salt'])))==0){

					// If the passwords match.

					if(strcmp($newpass,$confpass)!=0){	// If the new passwords match.
						echo "<br><br>New Passwords do not match.<br>";
					}
					else{
						// Generating a new salt.
						$newsalt = saltgen();

						$newpass = md5(crypt($newpass,$newsalt));

						// Now Updating the password and salt for the user.

						if($db->query("UPDATE ".$subs."users SET password='".$newpass."',salt = '".$newsalt."' WHERE userid='".$_SESSION['cuserid']."'")){
							echo "<br><br>Password Successfully Updated. You will be logged out.<br>";
							header("refresh:2;url=logout.php");
							exit();
						}
						else{
							echo "<br><br>A Problem Occurred. Please Try Again.<br>";
						}
					}
				}
				else{
					echo "<br><br>Wrong Password Entered. Try Again.";
				}
			}
		?>
	</main>
	<?php include 'footer.php'; ?>
</body>
</html>