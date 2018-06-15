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

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Duplicate Records</title>
    <style type="text/css">
        table tr td:last-child a{
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <?php include '../header.php';?>
    <div class="wrapper">
    	<div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix margin-bottom-4x">
                        <h2 class="pull-left padding-top-4x">Duplicate Record</h2>
                        <button onclick="Export()" class="btn btn-success pull-right fs4">
                        	<span class="fa fa-download fs4"></span>
                        	Export to CSV File
                        </button>
                    </div>
                    <?php
                    // Attempt select query execution
                    $sql = "SELECT t1.* FROM candidate_list t1
                            JOIN(
                                SELECT name, guardian
                                FROM candidate_list
                                GROUP BY name, guardian
                                HAVING count(*) > 1
                            ) t2 ON t1.name = t2.name AND t1.guardian = t2.guardian ORDER BY name, guardian";


                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>".$lang['name']."</th>";
                                        echo "<th>".$lang['guardian']."</th>";
                                        echo "<th>".$lang['dob']."</th>";
                                        echo "<th>".$lang['permanentAddress']."</th>";
                                        echo "<th>".$lang['district']."</th>";
                                        echo "<th>".$lang['birth_place']."</th>";
                                        echo "<th>".$lang['phone_number']."</th>";
                                        echo "<th>".$lang['gender']."</th>";
                                        echo "<th>".$lang['maritial_status']."</th>";
                                        echo "<th>".$lang['category']."</th>";
                                        echo "<th>".$lang['ulb_region']."</th>";
                                        echo "<th>".$lang['receipt_number']."</th>";
                                        echo "<th>".$lang['action']."</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                $i=0;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . ++$i . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['guardian'] . "</td>";
                                        echo "<td>" . $row['dob'] . "</td>";
                                        echo "<td>" . $row['permanentAddress'] . "</td>";
                                        echo "<td>" . $row['district'] . "</td>";
                                        echo "<td>" . $row['birthPlace'] . "</td>";
                                        echo "<td>" . $row['phoneNumber'] . "</td>";
                                        $fullGender = $row['gender'] == 'm' ? 'male' : 'female';
                                        echo "<td>" . $lang[$fullGender] . "</td>";
                                        echo "<td>" . $lang[ucwords(strtolower($row['maritialStatus']))] . "</td>";
                                        echo "<td>" . $lang[$row['category']] . "</td>";
                                        echo "<td>" . $row['ulbRegion'] . "</td>";
                                        echo "<td>" . substr($row['receiptNumber'], strpos($row['receiptNumber'], "_") + 1)
 . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
	</div>
</body>
</html>

<script>
    function Export() {
        var conf = confirm("Export users to CSV?");
        if(conf == true)
        {
            window.open("export.php", '_blank');
        }
    }
</script>