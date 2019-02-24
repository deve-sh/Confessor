<?php
	// Page to display an aesthetically pleasing webpage that users can take screenshots of and share.
	session_start();
	require('inc/checker.php');	// Check if the script is installed.
    require('inc/config.php');

    if(!$_SESSION['clogin'] || !$_SESSION['cuserid']){
    	header("refresh:0;url=index.php");
    	exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?> - Share Confession</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="sharepage">
	<div align="center">
		<div class="confheader"><?php echo $appname; ?></div>
		<br><br>
		<div class="confession">
			<?php
				if(!$_GET['cid']){	// No Cid Passed.
					header("refresh:0;url=index.php");
					exit();
				}

				$confgetter = $db->query("SELECT * FROM ".$subs."confessions WHERE cid = '".$db->escape($_GET['cid'])."'");

				if($db->numrows($confgetter)==0){
					// If no such confession exists.
					echo "No such Confession Found.";
				}
				else{
					$conf = $db->fetch($confgetter);
					echo $conf['confession'];
				}
			?>
		</div>
	</div>

	<script type="text/javascript" src="scripts/colorpallete.js"></script>
</body>
</html>