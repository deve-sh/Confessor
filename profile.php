<?php
	session_start();
	require("inc/checker.php");
	require("inc/config.php");

	if($_SESSION['clogin']==false || !$_SESSION['cuserid'])
    {	// User not logged in.
		header("refresh:0;url=login.php");
        exit();
    }

    if(!$_GET['userid']){	// If no userid is passed.
    	header("refresh:0;url=index.php");
    	exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?> - Profile</title>
	<?php include 'inc/styles.php'; ?>
</head>
<body class="mainbody">
	<?php
		include 'header.php';
	?>
	<main>
		<?php
			// Retreiving all the information about the user.

			$query1 = $db->query("SELECT * FROM ".$subs."users WHERE userid='".$_GET['userid']."'");

			if($db->numrows($query1)==0){
				// No user with the userid found.

				echo "<br><br>No such user found. Redirecting to home.<br><br>";
				header("refresh:2;url=index.php");
				exit();
			}

			// If found.

			$userdet = $db->fetch($query1);

			// Printing the details of each user.

			?>
			<div align="center">
				<?php
					echo "<h2>".$userdet['username']."</h2>";
					echo $userdet['name']."<br><br>";

					// Gathering all the public confessions.

					$query2 = $db->query("SELECT * FROM ".$subs."confessions WHERE recid='".$_GET['userid']."' AND showonprofile=1");

					if($db->numrows($query2)==0){
						echo "<br>No Public Confessions.<br>";
					}
					else{
						$numrows = $db->numrows($query2);
							// ------------
							// Paginating
							// ------------

							$rowsperpage = 5;

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

							
							$sql = "SELECT * FROM ".$subs."confessions WHERE recid='".$_GET['userid']."' AND showonprofile=1 LIMIT $offset, $rowsperpage";
							$result = $db->query($sql);
							
							while ($list = $db->fetch($result)) {
								// Displaying

								echo "<div class='confession' style='text-align:left;'>
										<div class='act'>
											".$list['confession']."
										</div>
										<div class='options'>
											";

							echo "<div class='cstamp'>".$list['cstamp']."</div><div class='right'>";

									echo "</div>
									</div>
								</div><br>";
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
							         echo " <span class='activepage'>{$x}</span> ";
							      
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
					</div>
					<?php
				}
				?>
			</div>
			<br>
			<div align="center"><h4><u>Submit Confession</u></h4></div>
			<form id='confessionsform' align='center' action="submitconf.php" method="POST">
				<!-- FORM FOR SUBMITTING CONFESSIONS TO THE USER -->
				<textarea name='confession' placeholder="Confession" id='confessionarea'></textarea>
				<br>
				<button type="submit" id='submit'>Submit</button>
			</form>
			<?php
		?>
	</main>

	<?php
		include 'footer.php';
	?>
</body>
</html>