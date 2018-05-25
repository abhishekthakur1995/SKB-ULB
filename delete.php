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

// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    // Prepare a select statement
    $sql = "DELETE FROM candidate_list WHERE id = ? AND ulbRegion = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "is", $param_id, $param_ulb_region);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        $param_ulb_region = $_SESSION['ulb_region'];
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(['response' => 'SUCCESS']);
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else {
    echo json_encode(['response' => 'FAILURE']);
    exit();
}
?>