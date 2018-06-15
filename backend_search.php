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
    $sql = "SELECT * FROM candidate_list WHERE receiptNumber LIKE '" . $_SESSION['ulb_region'].'_'.$term . "%' AND ulbRegion = '".trim($_SESSION['ulb_region'])."' AND status = 0 ORDER BY created_at DESC LIMIT 200";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            $visibleClass = ($result->num_rows > 7) ? 'height-8x' : '';

            echo "<div class='dropdown-result ".$visibleClass."'>";

            while($row = $result->fetch_array()) {
                echo "<a class='clr-black' href='update.php?id=". $row['id'] ."'> <p><span class='fs4 bold'>".substr($row['receiptNumber'], strpos($row['receiptNumber'], "_") + 1)."</span>"."&nbsp;&nbsp;". $row['name']  ."</p></a>";
            }
            echo "</div>";
            $result->free();
        } 
        else{
            echo "<p>".$lang['no_match_found']."</p>";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . link_error($link);
    }
}

$link->close();
?>