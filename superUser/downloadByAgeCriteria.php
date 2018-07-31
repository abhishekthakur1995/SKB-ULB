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

$sql = "SELECT candidate_list.ulbRegion, candidate_list.name, candidate_list.guardian, candidate_list.permanentAddress, candidate_list.district, candidate_list.dob, candidate_list.gender, candidate_list.maritialStatus, candidate_list.category, candidate_list.receiptNumber, candidate_list.specialPreference, candidate_list.userFormValid, candidate_list.remark FROM selected_candidates INNER JOIN candidate_list ON selected_candidates.receiptNumber = candidate_list.receiptNumber WHERE selected_candidates.code IN (19, 20, 21, 22) AND ((candidate_list.dob LIKE '%-%' AND STR_TO_DATE(candidate_list.dob, '%Y-%m-%d') < '1979-01-01') OR (candidate_list.dob LIKE '%/%' AND STR_TO_DATE(candidate_list.dob, '%d/%m/%Y') < '1979-01-01'))";

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
        $row['specialPreference'] = $lang[$row['specialPreference']];
        $row['ulbRegion'] = $lang[$row['ulbRegion']];
        $users[] = $row;
    }
}
 
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Users.csv');
$output = fopen('php://output', 'w');

fputcsv($output, array($lang['ulb_region'], $lang['name'], $lang['guardian'], $lang['permanentAddress'], $lang['district'], $lang['dob'], $lang['gender'], $lang['maritial_status'], $lang['category'], $lang['receipt_number'], $lang['special_preference_list'], $lang['all_documents_provided'], $lang['remark']));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>

