<?php
	session_start();

	require('inc/checker.php');	// Check if the script is installed.
    require('inc/config.php');

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
<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $appname; ?></title>
        <?php include 'inc/styles.php'; ?>
        <?php include 'inc/header.php'; ?>
    </head>
    <body>
    	<div id='indexintro'>
    		<div align="center">
                <span class="confheader">
                    <?php echo $appname; ?>
                </span>
                <br/>
                <span id='headertext'>
    			  Confess Anomynously.
    		    </span>
                <?php
                    if($_SESSION['clogin']!=true || !$_SESSION['cuserid'])
                        {   // User not logged in.
                ?>
                    <div class="secindex">
                        <a href='register.php'>
                            <div class='registerbutton'>Register</div>
                        </a>
                        
                        <a href='login.php'>
                            <div class='loginbutton'>
                                Login
                            </div>
                        </a>
                    </div>
                <?php
                    }
                ?>
            </div>
    	</div>
    	<?php include 'footer.php'; ?>
    	<?php include 'inc/scripts.php'; ?>
    </body>
</html>