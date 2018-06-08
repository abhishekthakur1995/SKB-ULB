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

if($_GET && $_GET['view']) {
    $view = htmlspecialchars(trim($_GET['view']));
}
 
if($view === 'all') {
	$sql = 'SELECT ulbRegion, 
	COUNT(CASE WHEN gender="m" AND status = 0 THEN 1 END) AS male, 
	COUNT(CASE WHEN gender="f" AND status = 0 THEN 1 END) AS female,
	COUNT(CASE WHEN gender="f" AND status = 0 AND maritialStatus="WIDOW" THEN 1 END ) AS "Female Widow",
	COUNT(CASE WHEN gender="f" AND status = 0 AND maritialStatus="DIVORCEE" THEN 1 END ) AS "Female Divorcee",
	COUNT(CASE WHEN gender="f" AND status = 0 AND maritialStatus="MARRIED" THEN 1 END ) AS "Female Married",
	COUNT(CASE WHEN gender="f" AND status = 0 AND maritialStatus="UNMARRIED" THEN 1 END ) AS "Female Unmarried",
	COUNT(*) AS total
	FROM candidate_list WHERE status = 0 GROUP BY ulbRegion ORDER BY total DESC';

	if (!$result = mysqli_query($link, $sql)) {
	    exit(mysqli_error($link));
	}
 
	$users = array();
	if (mysqli_num_rows($result) > 0) {
	    while ($row = mysqli_fetch_assoc($result)) {
	        $users[] = $row;
	    }
	}
} else if($view === 'formStatus') {
	$sql = "SELECT ulbRegion,
	COUNT(CASE WHEN userFormValid = 1 AND status = 0 THEN 1 END) AS valid,
	COUNT(CASE WHEN userFormValid = 0 AND status = 0 THEN 1 END) AS invalid,
	COUNT(CASE WHEN userFormValid = 2 AND status = 0 THEN 1 END) AS under_scrutiny,
	COUNT(*) AS total
	FROM candidate_list WHERE status = 0 GROUP BY ulbRegion ORDER BY total DESC";

	if (!$result = mysqli_query($link, $sql)) {
	    exit(mysqli_error($link));
	}
 
	$users = array();
	if (mysqli_num_rows($result) > 0) {
	    while ($row = mysqli_fetch_assoc($result)) {
	        $users[] = $row;
	    }
	}
} else {
	header("location: ../error.php?err_msg=Invalid value passed");
}
 
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Users.csv');
$output = fopen('php://output', 'w');

if($view == 'formStatus') {
	fputcsv($output, array('ULB', 'Valid', 'Invalid', 'Under Scrutiny', 'Total Candidates'));
}

if($view == 'all') {
	fputcsv($output, array('ULB', 'Male Candidates', 'Female Candidates', 'Female Widow Candidates', 'Female Divorcee Candidates','Female Married Candidates', 'Female Unmarried Candidates', 'Total Candidates'));
}
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>