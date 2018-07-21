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

$sql = $_SESSION['download_data_query'];

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