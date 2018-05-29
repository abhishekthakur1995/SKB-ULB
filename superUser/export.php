<?php

session_start();

if($_SESSION['user_role'] == 'SUPERADMIN') {
	require('../config.php');

	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	    header("location: ../index.php");
	    exit;
	} else {
	    if (time()-$_SESSION['timestamp'] > IDLE_TIME) {
	        header("location: ../logout.php");
	    }   else{
	        $_SESSION['timestamp']=time();
	    }
	}
} else {
	header("location: ../error.php?err_msg=Access Not Allowed");
}
 

$sql = 'SELECT ulbRegion, 
COUNT(case when candidate_list.gender="m" then 1 end) as male, 
COUNT(case when candidate_list.gender="f" then 1 end) as female, 
COUNT(case when candidate_list.gender="f" AND maritialStatus="WIDOW" then 1 end ) as "Female Widow",
COUNT(case when candidate_list.gender="f" AND maritialStatus="DIVORCE" then 1 end ) as "Female Divorcee",
COUNT(case when candidate_list.gender="f" AND maritialStatus="MARRIED" then 1 end ) as "Female Married"
COUNT(case when candidate_list.gender="f" AND maritialStatus="SINGLE" then 1 end ) as "Female Single",
COUNT(*) as total
from candidate_list group by ulbRegion order by total desc';

if (!$result = mysqli_query($link, $sql)) {
    exit(mysqli_error($link));
}
 
$users = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
 
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Users.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('ULB', 'Male Candidates', 'Female Candidates', 'Female Widow Candidates', 'Female Divorcee Candidates','Female Married Candidates', 'Female Unmarried Candidates', 'Total Candidates'));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>