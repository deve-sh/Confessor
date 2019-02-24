<?php
	// PHP Script to check whether the script has already been installed.

	session_start();

	$valfile1 = fopen("../inc/confirm","r");
	$valfile2 = fopen("../inc/config.php","r");
	
	$string1 = fread($valfile1,filesize("../inc/confirm"));
	$string2 = fread($valfile2,filesize("../inc/config.php"));

	fclose($valfile1);
	fclose($valfile2);

	if($string1!="0" && $string2!="0")	// Indicated that the script is already installed.
	{
		header("refresh:0;url=../");
		exit();
	}
?>