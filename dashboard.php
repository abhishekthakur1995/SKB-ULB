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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $lang['dashboard_title']; ?></title>
</head>
<body class="fleft">
    <?php include 'header.php';?>
    <?php include 'reservation_table.php';?>

    <div class="fleft full-width text-align-center" >
        <a href="candidate_details.php" class="btn btn-primary btn-lg"><?php echo $lang['dashboard_btn_1']; ?></a>
        <a href="candidates_details.php" class="btn btn-primary btn-lg"><?php echo $lang['dashboard_btn_2']; ?></a>
    </div>
</body>
</html>