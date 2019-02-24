<?php
	// PHP Script to Return JSON Response Concerning a user.
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';

	function ismore($userid, $start){	// Function to check if there are more confessions left after querying.
		$queryob3 = $db->query("SELECT * FROM ".$subs."confessions WHERE recid={$userid} LIMIT {$start},20");

		if($db->numrows($queryob3)>0){
			return $queryob3;
		}
		else{
			return false;
		}
	}

	if(!isset($_GET['cusername']) || empty($_GET['cusername']))		// If no input obtained.
	{
		exit("[{\"response\":\"406\"}]");		// Invalid Input.
	}

	if(($_SESSION['clogin'] && $_SESSION['cuserid']) || isset($_COOKIE['clogin'])){
		// If user is logged in. Send a different response.

		$username = $db->escape($_GET['cusername']);

		$queryob1 = $db->query("SELECT * FROM ".$subs."users WHERE username='".$username."'");
		
		if($db->numrows($queryob1)==0){
			exit("[{\"response\":\"400\"}]");	// No such user found.
		}

		$queryob1 = $db->fetch($queryob1);
		
		$resstring="[";

		// User Info

		$resstring.="{\"name\":\"{$queryob1['name']}\",\"username\":\"{$queryob1['username']}\",";

		// Confessions

		$queryob2 = $db->query("SELECT * FROM ".$subs."confessions WHERE recid='{$queryob1['userid']}' LIMIT 0,20");

		if($db->numrows($queryob2)==0)
			$resstring.="\"noofconfessions\":0}";
		else
			$resstring.="\"noofconfessions\":".$db->numrows($queryob2)."}";

		// Next ... The List of Confessions in another Object.

		$resstring.="]";

		echo $resstring;
	}
	else{
		// If the user isn't logged in send a restricted amount of data.

		exit("[{\"response\":\"403\"}]");	// Unauthorised.
	}
?>