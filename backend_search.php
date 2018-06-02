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

$term = $link->real_escape_string($_REQUEST['term']);
 
if(isset($term)){
    $sql = "SELECT * FROM candidate_list WHERE name LIKE '" . $term . "%' AND ulbRegion = '".trim($_SESSION['ulb_region'])."' ORDER BY created_at DESC ";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()) {
                echo "<a class='clr-black' href='update.php?id=". $row['id'] ."'> <p><span class='fs4 bold'>".$row['name']."</span>"."&nbsp;&nbsp;". $row['permanentAddress']  ."</p></a>";
            }
            $result->free();
        } else{
            echo "<p>".$lang['no_match_found']."</p>";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . link_error($link);
    }
}

$link->close();
?>