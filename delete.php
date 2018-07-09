<?php
session_start();

if(!in_array($_SESSION['ulb_region'], Common::TEMP_ALLOWED)) {
    header("location: error.php");
    die();
}

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

// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])) {
    
    $sql = "UPDATE candidate_list SET status = 1 WHERE id= ".trim($_POST["id"])."";

    if(mysqli_query($link, $sql)){
        echo json_encode(['response' => 'SUCCESS']);
        exit();
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    
    // Close connection
    mysqli_close($link);
    
} else {
    echo json_encode(['response' => 'FAILURE']);
    exit();
}
?>
