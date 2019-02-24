<?php
	// PHP Script to Log a User In.

	session_start();
	require 'inc/checker.php';
	require 'inc/config.php';

	if(isset($_COOKIE['clogin']) && $_SESSION['clogin']==true && !$_SESSION['cuserid']){		// User is already logged in.
		header("refresh:0;url=usercp.php");
		exit("<br><br>Already Logged In.<br><br>");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Logging In ...</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<?php include 'header.php'; ?>
	<main>
		<?php
		
			$username = $_POST['username'];
			$password = $_POST['password'];

			if($username && $password){
				
				// Sanitising Inputs

				$username = $db->escape($username);
				$password = $db->escape($password);

				$query = "SELECT * FROM ".$subs."users WHERE username='{$username}' or email = '{$username}'";

				if($db->numrows($db->query($query))){
					$userobject = $db->fetch($db->query($query));

					$usersalt = $userobject['salt'];
				
					$hashedpass = md5(crypt($password,$usersalt));

					if(strcmp($hashedpass,$userobject['password'])==0){
						$_SESSION['clogin']=true;

						setcookie('clogin','[{"id":'.$userobject['userid'].'}]',(time()+84600*15));	// Set Cookie for 15 days.
						
						$_SESSION['cuserid'] = $userobject['userid'];

						echo "<br>Successfully Logged In.<br>";
						header("refresh:1;url=usercp.php");
						exit();
					}
					else{
						echo "<br>Wrong Credentials.<br>";
						header("refresh:1;url=login.php");
						exit();
					}
				}
				else{
					echo "<br>Invalid Username.<br>";
				}
			}
			else{
				echo "<br>Invalid Login Details.<br>";
				header("refresh:2;url=login.php");
				exit();
			}
		?>
	</main>
</body>
</html>