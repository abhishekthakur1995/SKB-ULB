<?php
session_start();

if($_SESSION['user_role'] == 'SUPERADMIN') {
	require('../config.php');

	if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
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

$ulbListJson = file_get_contents(__DIR__ . '/../data/ulb_list.json');
$ulbListArr = json_decode($ulbListJson, true);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=NewUlbPassword.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('ULB NAME', 'PASSWORD'));
ini_set('max_execution_time', 300);
foreach ($ulbListArr as $key => $value) {
	if($value['NAME'] != 'DLBSUPERADMIN') {
		$customPassword = $value['CODE']."__".mt_rand(1000,9999);
		$passsword = password_hash($customPassword, PASSWORD_DEFAULT);
		$sql = "UPDATE ulb_admins SET password = '".$passsword."' WHERE region = '".$value['CODE']."'";
		if(mysqli_query($link, $sql)){
			$list = array($value['NAME'], $customPassword);
			fputcsv($output, $list);
		} else {
			echo "Error processing query.";
		}
	}
}
mysqli_close($link);		

?>