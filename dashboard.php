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

$total_general_candidate = $total_sc_candidate = $total_st_candidate = 0;

$sql = "SELECT * FROM candidate_list WHERE category = 'GENERAL' AND ulbRegion = '".$_SESSION['ulb_region']."'";
$res = mysqli_query($link, $sql);
$total_general_candidate = mysqli_num_rows($res);

$sql = "SELECT * FROM candidate_list WHERE category = 'SC' AND ulbRegion = '".$_SESSION['ulb_region']."'";
if ($res = mysqli_query($link, $sql)) {
    $total_sc_candidate = mysqli_num_rows($res);
}

$sql = "SELECT * FROM candidate_list WHERE category = 'ST' AND ulbRegion = '".$_SESSION['ulb_region']."'";
if ($res = mysqli_query($link, $sql)) {
    $total_st_candidate = mysqli_num_rows($res);
}


// Close connection
mysqli_close($link);

?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['dashboard_title']; ?></title>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <style type="text/css">
        @-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}
    </style>
</head>
<body>
    <?php include 'header.php';?>
    <div class="page-header">
        <h1>Welcome</h1>
        <h1><b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. <?php echo $lang['welcome_msg_2']; ?></h1>
    </div>

    <div class="records">
        <p>Total General Candidate: <?php echo $total_general_candidate;?></p>
        <p>Total SC Candidate: <?php echo $total_sc_candidate;?></p>
        <p>Total ST Candidate: <?php echo $total_st_candidate;?></p>
    </div>
    <?php include 'reservation_table.php';?>

    <p>
        <a href="candidate_details.php" class="btn btn-primary btn-lg"><?php echo $lang['dashboard_btn_1']; ?></a>
        <a href="candidates_details.php" class="btn btn-primary btn-lg"><?php echo $lang['dashboard_btn_2']; ?></a>
    </p>
</body>
</html>