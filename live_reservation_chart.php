<?php
session_start();
require('config.php');
require('languages/hi/lang.hi.php');
require('common/common.php');

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
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="table-container fleft full-width">
        <table class="ulb-table no-margin">
            <thead>
            	<tr>
            		<th><?php echo $lang['ulb_region']?></th>

            		<th><?php echo $lang['SC_FEMALE_WIDOW']?></th>
            		<th><?php echo $lang['SC_FEMALE_DIVORCEE']?></th>
            		<th><?php echo $lang['SC_FEMALE_COMMON']?></th>
            		<th><?php echo $lang['SC_MALE']?></th>

            		<th><?php echo $lang['ST_FEMALE_WIDOW']?></th>
            		<th><?php echo $lang['ST_FEMALE_DIVORCEE']?></th>
            		<th><?php echo $lang['ST_FEMALE_COMMON']?></th>
            		<th><?php echo $lang['ST_MALE']?></th>

            		<th><?php echo $lang['OBC_FEMALE_WIDOW']?></th>
            		<th><?php echo $lang['OBC_FEMALE_DIVORCEE']?></th>
            		<th><?php echo $lang['OBC_FEMALE_COMMON']?></th>
            		<th><?php echo $lang['OBC_MALE']?></th>

            		<th><?php echo $lang['SPECIALOBC_FEMALE_WIDOW']?></th>
            		<th><?php echo $lang['SPECIALOBC_FEMALE_DIVORCEE']?></th>
            		<th><?php echo $lang['SPECIALOBC_FEMALE_COMMON']?></th>
            		<th><?php echo $lang['SPECIALOBC_MALE']?></th>

            		<th><?php echo $lang['GENERAL_FEMALE_WIDOW']?></th>
            		<th><?php echo $lang['GENERAL_FEMALE_DIVORCEE']?></th>
            		<th><?php echo $lang['GENERAL_FEMALE_COMMON']?></th>
            		<th><?php echo $lang['GENERAL_MALE']?></th>

            	</tr>
            </thead>

           	<tbody>
           		<?php
           			$sql = "SELECT * from reservation_chart where ULB_REGION = '".$_SESSION['ulb_region']."'";
           			if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                        	while($row = mysqli_fetch_array($result)){
	                        	echo "<td>" . $row['ULB_REGION'] . "</td>";
	                        	echo "<td>" . $row['SC_FEMALE_WIDOW'] . "</td>";
	                        	echo "<td>" . $row['SC_FEMALE_DIVORCEE'] . "</td>";
	                        	echo "<td>" . $row['SC_FEMALE_COMMON'] . "</td>";
	                        	echo "<td>" . $row['SC_MALE'] . "</td>";

	                        	echo "<td>" . $row['ST_FEMALE_WIDOW'] . "</td>";
	                        	echo "<td>" . $row['ST_FEMALE_DIVORCEE'] . "</td>";
	                        	echo "<td>" . $row['ST_FEMALE_COMMON'] . "</td>";
	                        	echo "<td>" . $row['ST_MALE'] . "</td>";

	                        	echo "<td>" . $row['OBC_FEMALE_WIDOW'] . "</td>";
	                        	echo "<td>" . $row['OBC_FEMALE_DIVORCEE'] . "</td>";
	                        	echo "<td>" . $row['OBC_FEMALE_COMMON'] . "</td>";
	                        	echo "<td>" . $row['OBC_MALE'] . "</td>";

	                        	echo "<td>" . $row['SPECIALOBC_FEMALE_WIDOW'] . "</td>";
	                        	echo "<td>" . $row['SPECIALOBC_FEMALE_DIVORCEE'] . "</td>";
	                        	echo "<td>" . $row['SPECIALOBC_FEMALE_COMMON'] . "</td>";
	                        	echo "<td>" . $row['SPECIALOBC_MALE'] . "</td>";

	                        	echo "<td>" . $row['GENERAL_FEMALE_WIDOW'] . "</td>";
	                        	echo "<td>" . $row['GENERAL_FEMALE_DIVORCEE'] . "</td>";
	                        	echo "<td>" . $row['GENERAL_FEMALE_COMMON'] . "</td>";
	                        	echo "<td>" . $row['GENERAL_MALE'] . "</td>";
	                        }
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql";
                    }
           		?>
           	</tbody>
        </table>
    </div>
</body>
</html>