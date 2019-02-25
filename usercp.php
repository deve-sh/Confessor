<?php
	session_start();

	require('inc/checker.php');	// Check if the script is installed.
    require('inc/config.php');

	if(isset($_COOKIE['clogin']) && $_SESSION['clogin']==true && $_SESSION['cuserid']){
		$_SESSION['cuserid'] = json_decode($_COOKIE['clogin'])[0]->id;
		$_SESSION['clogin'] = true;
	}
	else{
		header("refresh:0;url=login.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?> - User CP</title>
	<?php require('inc/styles.php'); ?>
</head>
<body class="mainbody">
	<?php include 'header.php'; ?>
	<main>
	<div align="center"><h3>Confessions</h3>
	<?php
		if($userquery = $db->query("SELECT * FROM ".$subs."confessions WHERE recid='".$_SESSION['cuserid']."'"))
		{
			$numrows = $db->numrows($userquery);
		}

		//	Getting the data from the database.

		if($numrows == 0){
			echo "<br><br><div align='center'>No Confessions Yet.</div><br><br>";
		}

		// Pagination

		$rowsperpage = 10;
	
		$totalpages = ceil($numrows / $rowsperpage);

		
		if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
		   $currentpage = (int) $_GET['currentpage'];
		} else {
		   $currentpage = 1;
		} 

		
		if ($currentpage > $totalpages) {
		   
		   $currentpage = $totalpages;
		} 
		
		if ($currentpage < 1) {
		   
		   $currentpage = 1;
		} 

		
		$offset = ($currentpage - 1) * $rowsperpage;

		
		$sql = "SELECT * FROM ".$subs."confessions WHERE recid='".$_SESSION['cuserid']."' LIMIT $offset, $rowsperpage";
		$result = $db->query($sql);
		
		while ($list = $db->fetch($result)) {
			// Displaying

			echo "<div class='confession'>
					<div class='act'>
						".$list['confession']."
					</div>
					<div class='options'>
						";

					echo "<div class='cstamp'>".$list['cstamp']."</div><div class='right'>";

					if($list['showonprofile']==true){
						echo "<a href='hidefromp.php?cid=".$list['cid']."'><span class='showonp'>Hide From Profile</span></a>";
					}
					else{
						echo "<a href='showonp.php?cid=".$list['cid']."'><span class='hidefromp'>Show On Profile</span></a>";	
					}

					echo "&nbsp&nbsp<a title='Share' href='share.php?cid=".$list['cid']."' target='_blank'><i class=\"fas fa-share-alt\"></i></a>";

				echo "</div>
				</div>
			</div><br/>";
		}

		?>
		<div align="center">
			<br><br>
		<?php

		$range = 5;

		if ($currentpage > 1) {
		   
		   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
		   
		   $prevpage = $currentpage - 1;
		   
		   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> ";
		} 

			
		for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
		
		   if (($x > 0) && ($x <= $totalpages)) {
		      if ($x == $currentpage) {
		         echo " <span class='activepage'>$x</span> ";
		      
		      } else {
		         echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
		      }
		   } 
		} 
		
		if ($currentpage != $totalpages) {
		   
		   $nextpage = $currentpage + 1;
		    
		   if($totalpages>1)
		   {
		   		echo " <span class='nextpage'><a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a></span> ";
		   
		   		echo " <span class='nextpage'><a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a></span> ";
		   }
		}
	?>
		</div></div>
	</main>
	<?php require('inc/scripts.php'); ?>
	<?php include 'footer.php'; ?>
</body>
</html>