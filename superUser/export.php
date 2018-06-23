<?php

session_start();

if($_SESSION['user_role'] == 'SUPERADMIN') {
	require_once('../config.php');
    require_once('../languages/hi/lang.hi.php');

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
	header("location: ../error.php");
}

if($_GET && $_GET['view']) {
    $view = htmlspecialchars(trim($_GET['view']), ENT_QUOTES);
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
	FROM candidate_list WHERE status = 0 and userFormValid = 1 GROUP BY ulbRegion ORDER BY total DESC';

	if (!$result = mysqli_query($link, $sql)) {
	    exit("Error processing query");
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
	    exit("Error processing query");
	}
 
	$users = array();
	if (mysqli_num_rows($result) > 0) {
	    while ($row = mysqli_fetch_assoc($result)) {
	        $users[] = $row;
	    }
	}
} else if($view === 'duplicateRecord') {
	$sql = "SELECT t1.name, t1.guardian, t1.permanentAddress, t1.temporaryAddress, t1.dob, t1.phoneNumber, t1.birthPlace, t1.district, t1.ulbRegion, t1.category, t1.gender, t1.maritialStatus, t1.religion, t1.receiptNumber, t1.userFormValid, t1.specialPreference, t1.remark FROM candidate_list t1 JOIN(
    		SELECT name, guardian, dob FROM candidate_list GROUP BY name, guardian, dob HAVING COUNT(*) >= 2
        ) t2 ON t1.name = t2.name AND t1.guardian = t2.guardian AND t1.dob = t2.dob WHERE status = 0 and userFormValid = 1 ORDER BY name, guardian";

	if (!$result = mysqli_query($link, $sql)) {
	    exit("Error processing query");
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

} else {
	header("location: ../error.php");
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

if($view == 'duplicateRecord') {
	fputcsv($output, array($lang['name'], $lang['guardian'], $lang['permanentAddress'], $lang['temporaryAddress'], $lang['dob'], $lang['phone_number'], $lang['birth_place'], $lang['district'], $lang['ulb_region'], $lang['category'], $lang['gender'], $lang['maritial_status'], $lang['religion'], $lang['receipt_number'], $lang['all_documents_provided'], $lang['special_preference'], $lang['remark']));
}
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>