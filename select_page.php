<?php

session_start();

require('config.php');
require('languages/hi/lang.hi.php');
require('common/common.php');

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: index.php");
    exit;
} else {
    if (time()-$_SESSION['timestamp'] > IDLE_TIME) {
        header("location: logout.php");
    }   else{
        $_SESSION['timestamp']=time();
    }
}

?>


<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title><?php echo $lang['dashboard_title']; ?></title>
	</head>
	<body>
	    <?php include 'header.php';?>

	    <div class="wrapper fleft full-width margin-top-6x">

			<div class="fleft full-width text-align-center" >
                <a href="get_candidates_1.php" class="btn btn-primary btn-lg fs4">
                    <span class="fa fa-unlock fs4"></span>EXOFFICER/PLAYER/HANDICAPPED
                </a>
                <a href="get_candidates_2.php" class="btn btn-primary btn-lg fs4">
                    <span class="fa fa-eye fs4"></span>SC/SC/OBC/MBC/General
                </a>
            </div>

	    </div>
	</body>
</html>