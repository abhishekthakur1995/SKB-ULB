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
    <title>Enteries by ULB</title>
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
                        <h2 class="pull-left padding-top-4x">Enteries by ULB</h2>
                        <button onclick="Export()" class="btn btn-success pull-right fs4">
                        	<span class="fa fa-download fs4"></span>
                        	Export to CSV File
                        </button>
                    </div>
                    <?php
                    // Attempt select query execution
                    $sql = 'SELECT ulbRegion, COUNT(*) as total, 
							COUNT(case when candidate_list.gender="m" then 1 end) as male, 
							COUNT(case when candidate_list.gender="f" then 1 end) as female, 
							COUNT(case when candidate_list.gender="f" AND maritialStatus="WIDOW" then 1 end ) as "Female Widow",
							COUNT(case when candidate_list.gender="f" AND maritialStatus="DIVORCE" then 1 end ) as "Female Divorcee",
							COUNT(case when candidate_list.gender="f" AND maritialStatus="SINGLE" then 1 end ) as "Female Single",
							COUNT(case when candidate_list.gender="f" AND maritialStatus="MARRIED" then 1 end ) as "Female Married"
							from candidate_list group by ulbRegion order by total desc';


                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>ULB</th>";
                                        echo "<th>Male Candidates</th>";
                                        echo "<th>Female Candidates</th>";
                                        echo "<th>Female Widow Candidates</th>";
                                        echo "<th>Female Divorcee Candidates</th>";
                                        echo "<th>Female MarriedCandidates</th>";
                                        echo "<th>Female Unmarried Candidates</th>";
                                        echo "<th>Total Candidates</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                $i=0;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . ++$i . "</td>";
                                        echo "<td>" . $row['ulbRegion'] . "</td>";
                                        echo "<td>" . $row['male'] . "</td>";
                                        echo "<td>" . $row['female'] . "</td>";
                                        echo "<td>" . $row['Female Widow'] . "</td>";
                                        echo "<td>" . $row['Female Divorcee'] . "</td>";
                                        echo "<td>" . $row['Female Single'] . "</td>";
                                        echo "<td>" . $row['Female Married'] . "</td>";
                                        echo "<td>" . $row['total'] . "</td>";
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