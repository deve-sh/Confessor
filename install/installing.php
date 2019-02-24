<?php
	session_start();
	require_once 'installchecker.php';
	require_once '../inc/connect.php';
	require_once '../inc/salt.php';

	$db = new dbdriver();	// DB Driver Object
?>
<!DOCTYPE html>
<html>
<head>
	<title>Installing ... </title>
	<?php include 'installstyles.html'; ?>
</head>
<body class="installpage">
	<main id='details'>
		<?php

			// Database Variables

			$dbhost = $_POST['dbhost'];
			$dbuser = $_POST['dbuser'];
			$dbpass = $_POST['dbpass'];
			$dbname = $_POST['dbname'];
			$subscr = $_POST['subscr'];
			$appname = $_POST['appname'];

			if($dbhost && $dbuser && $dbpass && $dbname){
				// Escaping

				$dbhost = escapestr($dbhost);
				$dbuser = escapestr($dbuser);
				$dbpass = escapestr($dbpass);
				$dbname = escapestr($dbname);

				if(!$subscr)
					$subscr = "conf_";
				else
					$subscr = escapestr($subscr);

				if(!$appname)
					$appname = "Confessor";

				if($db->connect($dbhost,$dbuser,$dbpass,$dbname)){

					// TABLE QUERIES

					$queries = array(
						"DROP TABLE IF EXISTS ".$subscr."confessions",
						"DROP TABLE IF EXISTS ".$subscr."users",
						"CREATE TABLE IF NOT EXISTS ".$subscr."users(
							userid integer primary key auto_increment,
							name text not null,
							username varchar(255) unique not null,
							email varchar(255) unique not null,
							password varchar(255) not null,
							salt text not null)",
						"CREATE TABLE IF NOT EXISTS ".$subscr."confessions(
							cid integer primary key auto_increment,
							sendid integer references ".$subscr."users(userid),
							recid integer references ".$subscr."users(userid) on delete cascade on update set null,
							confession text not null,
							cstamp timestamp,
							showonprofile boolean)"
					);

					$messages = array(
						"Dropping Previously Created User Table.",
						"Dropping Previously Created Confessions Table.",
						"Creating User Table.",
						"Creating Confessions Table."
					);

					$errors = array(
						"Could Not Drop User Table.",
						"Could not Drop Confessions Table.",
						"Could not Create the User Table.",
						"Could not Create Confessions Table."
					);

					// Variable to store the number of successes.

					$count = 0;
					$iterator = 0;	// A counter variable to access user and error messages from the messages and error arrays.

					// Execution

					foreach ($queries as $query) {
						echo "<br>".$messages[$iterator]."<br>";

						if($db->query($query))
							$count++;
						else
						{
							echo "<br>".$errors[$iterator]."<br>";
							break;		// No need to move any further.
						}

						$iterator++;	// Move to next message or error.
					}

					if($count!=4){
						echo "<br><br>The installation could not be processed fully.<br> Kindly Try Again (Recheck the entered credentials).";
						header("refresh:5;url=index.php");
						exit();
					}

					// If the above stuff was successful, write the configuration files.

					// Creating Confimation File.

					$filename1 = "../inc/confirm";
					$filename2 = "../inc/config.php";

					$handle1 = fopen($filename1,"w+");
					$handle2 = fopen($filename2,"w+");

					$configstring = "<?php\nerror_reporting(0);\ninclude 'inc/connect.php';\n\$appname = \"{$appname}\";\n\$dbhost=\"{$dbhost}\";\n\$dbuser=\"{$dbuser}\";\n\$dbpass=\"{$dbpass}\";\n\$dbname=\"{$dbname}\";\n\$subs=\"{$subscr}\";\n\$db = new dbdriver();\n\$db->connect(\$dbhost,\$dbuser,\$dbpass,\$dbname);\n?>";

					$confirmstring = "1";

					// Writing Strings

					echo "<br>Writing to Files.<br>";

					if(!fwrite($handle1,$confirmstring) || !fwrite($handle2,$configstring))
					{
						echo "<br>Could not write to files.<br>";
						header("refresh:1;url=index.php");
						exit();
					}
					else{	// If everything was successful.

						// Final Thing. Removing any previously leftover cookie on the installer's system.

						if (isset($_SERVER['HTTP_COOKIE'])) {
						    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
						    foreach($cookies as $cookie) {
						        $parts = explode('=', $cookie);
						        $name = trim($parts[0]);
						        setcookie($name, '', time()-1000);
						        setcookie($name, '', time()-1000, '/');
						    }
						}
						
						// Displaying Success Message

						echo "<br>Successful Installation.<br><br>Redirecting you to Home.";
						header("refresh:2;url=../");
						exit();
					}

				}
				else{
					echo "<br>There was a problem with the database credentials. Please try again.<br>";
					header("refresh:1;url=index.php");
					exit();
				}
			}
			else{
				echo "<br>Invalid Inputs.<br>";
				header("refresh:2;url=index.php");
				exit();
			}
		?>
	</main>
</body>
</html>