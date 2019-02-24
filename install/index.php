<?php
	session_start();
	require_once 'installchecker.php';
	require_once '../inc/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Install Confessor</title>
	
	<?php include 'installstyles.html'; ?>
</head>
<body class="installpage">
	<div id='installheader'>Install Confessor</div>
	<br/>
	<!-- FORM -->
	<form id='details' action="installing.php" method="POST">
		<br>
		<input type="text" name="appname" placeholder="App Name (Default : Confessor)">
		<h3>Database Details</h3>
		(Only MySQLI Databases are Supported.)
		<br/><br/>
		<input type="text" name="dbhost" placeholder="Database Host" required/>
		<br/><br/>
		<input type="text" name='dbuser' placeholder="Database User" required/>
		<br/><br/>
		<input type="password" name='dbpass' placeholder="Database Password" required/>
		<br/><br/>
		<input type="text" placeholder="Database Name" name="dbname" required/>
		<br/><br/>
		<input type="text" name="subscr" placeholder="Subscript(Default : conf_)"/>
		<br/><br/>
		<button type="submit" name='submit'>Install</button>
	</form>
</body>
</html>