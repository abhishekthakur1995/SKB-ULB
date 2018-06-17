<?php

session_start();

if($_SESSION['user_role'] == 'ULBADMIN') {
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
} else {
	header("location: error.php?err_msg=Access Not Allowed");
}
 
$sql = "SELECT name, guardian, permanentAddress, temporaryAddress, dob, phoneNumber, birthPlace, district, ulbRegion, category, gender, maritialStatus, religion, receiptNumber, userFormValid, specialPreference, remark FROM candidate_list WHERE status = 0 AND ulbRegion = '".$_SESSION['ulb_region']."'";

if (!$result = mysqli_query($link, $sql)) {
    exit(mysqli_error($link));
}

$users = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

    	if($row['userFormValid'] == 1) {
    		$row['userFormValid'] = $lang['yes'];
    	} else if($row['userFormValid'] == 0) {
    		$row['userFormValid'] = $lang['no'];
    	} else {
    		$row['userFormValid'] = $lang['under_scrutiny'];
    	}
    	$row['maritialStatus'] = $lang[$row['maritialStatus']];
    	$row['receiptNumber'] = substr($row['receiptNumber'], strpos($row['receiptNumber'], "_") + 1);
    	$row['gender'] = $row['gender'] == 'm' ? $lang['male'] : $lang['female'];
    	$row['category'] = $lang[$row['category']];
        $users[] = $row;
    }
}
 
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');
$output = fopen('php://output', 'w');

fputcsv($output, array($lang['name'], $lang['guardian'], $lang['permanentAddress'], $lang['temporaryAddress'], $lang['dob'], $lang['phone_number'], $lang['birth_place'], $lang['district'], $lang['ulb_region'], $lang['category'], $lang['gender'], $lang['maritial_status'], $lang['religion'], $lang['receipt_number'], $lang['all_documents_provided'], $lang['special_preference'], $lang['remark']));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>