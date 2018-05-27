<?php

session_start();
 
require('config.php');
require('languages/hi/lang.hi.php');

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

if (isset($_SESSION['message'])) {
    $msg = $_SESSION['message'];
    echo '<script language="javascript">';
    echo "alert('$msg')";
    echo '</script>';
    unset($_SESSION['message']);
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
    <div class="wrapper">
        <div class="fleft full-width text-align-center" >
            <a href="candidate_details.php" class="btn btn-primary btn-lg fs4">
                <span class="fa fa-plus-square fs4"></span>
                <?php echo $lang['dashboard_btn_1']; ?>
            </a>
            <a href="candidates_details.php" class="btn btn-primary btn-lg fs4">
                <span class="fa fa-edit fs4"></span>
                <?php echo $lang['dashboard_btn_2']; ?>
            </a>
        </div>  
    </div>
</body>
</html>