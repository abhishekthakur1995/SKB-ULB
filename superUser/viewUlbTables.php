<?php

session_start();
 
if($_SESSION['user_role'] == 'SUPERADMIN') {
	require_once('../config.php');
    require_once('../common/common.php');

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

$ulb = $tableType = $ulb_err = $table_type_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$trimUlb = trim($_POST['ulb']);
	if(empty($trimUlb)) {
		$ulb_err = 'Please select a ulb to proceed further';
	} else {
		$ulb = htmlspecialchars($trimUlb);
	}

	$trimTableType = trim($_POST['tableType']);
	if(empty($trimTableType)) {
		$table_type_err = 'Please select a table type';
	} else {
		$tableType = htmlspecialchars($trimTableType);
	}
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View ULB Table</title>
    </head>
    <body>
        <?php include '../header.php';?>
        <div class="wrapper">
	        <form class="form-inline" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	            <div class="form-group full-width">
	            	<div class="full-width text-align-center margin-top-4x">

                        <select class="form-control tableType <?php echo (!empty($table_type_err)) ? 'is-invalid' : ''; ?>" name="tableType" required>
                            <option value=""><?php echo $lang['table_type_select']; ?></option>
                            <option value="both"><?php echo $lang['both_table']; ?></option>
                            <option value="candidateReservation"><?php echo $lang['tbl1_heading']; ?></option>
                            <option value="candidateCount"><?php echo $lang['tbl2_heading']; ?></option>
                        </select>

		                <select class="form-control ulb margin-horiz-2x <?php echo (!empty($ulb_err)) ? 'is-invalid' : ''; ?>" name="ulb" required>
		                	<option value=""><?php echo $lang['ulb_region']; ?></option>
		                    <?php 
		                        $ulbListJson = file_get_contents(__DIR__ . '/../data/ulb_list.json');
		                        $ulbListArr = json_decode($ulbListJson, true);
		                        asort($ulbListArr);
		                        foreach($ulbListArr as $key => $value) {
		                            echo "<option value=".$value['CODE'].">".$value['NAME']."</option>"; 
		                        }
		                    ?>
		                </select>
		                <input type="submit" class="btn btn-primary no-margin-top" value="<?php echo $lang['view_ulb_table']; ?>">
		            </div>
	            </div>
	        </form>
	    </div> 
    </body>
</html>

<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($ulb_err) && empty($table_type_err)) {
			$currentUlb = $_SESSION['ulb_region'];
			$_SESSION['ulb_region'] = $ulb;
			if($tableType === 'candidateReservation') {
				include 'ulb_reservation_table.php';
			} else if($tableType === 'candidateCount') {
				include 'ulb_candidate_count_table.php';
			} else {
				include 'ulb_reservation_table.php';
				include 'ulb_candidate_count_table.php';
			}
			$_SESSION['ulb_region'] = $currentUlb;
       }
	}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $(".ulb").val('<?php echo $ulb; ?>');
        $(".tableType").val('<?php echo $tableType; ?>');
    });
</script>