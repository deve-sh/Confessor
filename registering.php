<?php
	session_start();

	require('inc/checker.php');	// Check if the script is installed.
	
	require('inc/config.php');

	require('inc/salt.php');

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
	<title><?php echo $appname; ?> - Registering ...</title>
	<?php include_once('inc/styles.php'); ?>
</head>
<body class="mainbody">
	<main>
		<?php
			$name = $_POST['name'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];

			if($name && $username && $email && $password){
				/* Escaping String */

				$name = escapestr($name);
				$username = escapestr($username);
				$email = escapestr($email);
				$password = escapestr($password);

				$salt = escapestr(saltgen());

				$password = md5(crypt($password,$salt));	// Crypting or Hashing.

				// Checker Queries

				$check1 = "SELECT * FROM ".$subs."users WHERE username='{$username}' OR email='{$email}'";

				if($db->numrows($db->query($check1))>0){
					echo "<br><br>A user with a similar username or email already exits.<br><br>Redirecting...<br>";
					header("refresh:2;url=register.php");
					exit();
				}
				else{
					$query = "INSERT INTO ".$subs."users(name,username,email,password,salt) VALUES('$name','$username','$email','$password','$salt')";

					if($db->query($query)){
						echo "<br><br>User Successfully Registered.<br><br>Redirecting to your login page...<br>";
						header("refresh:2;url=login.php");
						exit();
					}
					else{
						echo "<br>There was a problem registering.<br>";
					}
				}
			}
			else{
				echo "<br>Not enough information.<br>";
				header("refresh:1.5;url=register.php");
				exit();
			}		
		?>
	</main>
	<!-- Scripts -->
	<?php include 'inc/scripts.php'; ?>
</body>
</html>