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

    <div class="wrapper fleft full-width margin-top-6x">

        <?php if($_SESSION['user_role'] === 'SUPERADMIN') { ?>
            <div class="container width500">
                <div class="jumbotron text-align-center">
                    <h1>Total Enteries: <?php echo Common::getCountOfTotalEnteries(); ?></h1>
                </div>    
            </div>

            <div class="fleft full-width text-align-center" >
                <a href="superUser/forgotPassword.php" class="btn btn-primary btn-lg fs4 width450">
                    <span class="fa fa-unlock fs4"></span>
                    <?php echo $lang['dashboard_btn_6']; ?>
                </a>
                <a href="superUser/viewAllCandidateReport.php" class="btn btn-primary btn-lg fs4 width450">
                    <span class="fa fa-eye fs4"></span>
                    <?php echo $lang['dashboard_btn_7']; ?>
                </a>
            </div>
            <div class="fleft full-width text-align-center">
                <a href="superUser/formStatusCandidateReport.php" class="btn btn-primary btn-lg fs4 width450">
                    <span class="fa fa-eye fs4"></span>
                    <?php echo $lang['dashboard_btn_8']; ?>
                </a>
                <a href="superUser/lotterySelectedCandidate.php" class="btn btn-primary btn-lg fs4 width450">
                    <span class="fa fa-list fs4"></span>
                    <?php echo $lang['dashboard_btn_12']; ?>
                </a>
            </div>
        <?php } else { ?>
        <div class="fleft full-width text-align-center" >
            <div class="container width500">
                <div class="jumbotron text-align-center">
                    <h1><?php echo $lang['total_enteries']; ?>: <?php echo Common::getTotalEnteries(); ?></h1>
                    <a href="reservation_table.php" class="btn btn-primary btn-sm fs4">
                        <span class="fa fa-table fs4"></span>
                        <?php echo $lang['reservation_chart']; ?>
                    </a>
                    <a href="candidate_count_table.php" class="btn btn-primary btn-sm fs4">
                        <span class="fa fa-table fs4"></span>
                        <?php echo $lang['detailed_table']; ?>
                    </a>
                </div>    
            </div>
            <a href="exportUlbData.php" target="_blank" class="btn btn-primary btn-lg fs4 width450">
                <span class="fa fa-download fs4"></span>
                <?php echo $lang['download']; ?>
            </a>
            <a href="getSpecialPrefCandidates.php" class="btn btn-primary btn-lg fs4 width450">
                <span class="fa fa-users fs4 margin-right-1x"></span><?php echo $lang['dashboard_btn_10'];?>
            </a>
            <a href="getAllCategoryCandidates.php" class="btn btn-primary btn-lg fs4 width450">
                <span class="fa fa-users fs4 margin-right-1x"></span><?php echo $lang['dashboard_btn_11']; ;?>
            </a>
        </div>
    <?php } ?>
    </div>
</body>
</html>