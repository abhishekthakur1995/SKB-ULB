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

if($_GET && $_GET['page']) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$items = 50;
$offset = ($page * $items) - $items;

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

                    $sql = "SELECT ulbRegion, COUNT(*) AS total,
							COUNT(CASE WHEN userFormValid = 1 AND status = 0 THEN 1 END) AS valid,
							COUNT(CASE WHEN userFormValid = 0 AND status = 0 THEN 1 END) AS invalid,
							COUNT(CASE WHEN userFormValid = 2 AND status = 0 THEN 1 END) AS under_scrutiny
							FROM candidate_list WHERE status = 0 GROUP BY ulbRegion ORDER BY total DESC LIMIT ".$items." OFFSET ".$offset."";


                    if($result = mysqli_query($link, $sql)){
                        $count = mysqli_num_rows($result);
                        if($count > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>ULB</th>";
                                        echo "<th>Valid</th>";
                                        echo "<th>Invalid</th>";
                                        echo "<th>Under Scrutiny</th>";
                                        echo "<th>Total Enteries</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . ++$offset . "</td>";
                                        echo "<td>" . $row['ulbRegion'] . "</td>";
                                        echo "<td>" . $row['valid'] . "</td>";
                                        echo "<td>" . $row['invalid'] . "</td>";
                                        echo "<td>" . $row['under_scrutiny'] . "</td>";
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
            <ul class="pagination pagination-lg fright">
                <?php if ($page != 1) { ?>        
                    <li class="page-item"><a class="page-link" href="formStatusCandidateReport.php?page=<?php echo $page - 1; ?>">&laquo;</a></li>

                    <li class="page-item"><a class="page-link" href="formStatusCandidateReport.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?></a></li>
                <?php } ?>

                <li class="page-item active"><a class="page-link" href="formStatusCandidateReport.php?page=<?php echo $page; ?>"><?php echo $page; ?></a></li>

                <?php if ($count == $items) { ?>
                    <li class="page-item"><a class="page-link" href="formStatusCandidateReport.php?page=<?php echo $page + 1 ; ?>"><?php echo $page + 1; ?></a></li>

                    <li class="page-item"><a class="page-link" href="formStatusCandidateReport.php?page=<?php echo $page + 1; ?>">&raquo;</a></li>
                <?php } ?>
            </ul>       
        </div>
	</div>
</body>
</html>

<script>
    function Export() {
        var conf = confirm("Export users to CSV?");
        if(conf == true){
            window.open("export.php?view=formStatus", '_blank');
        }
    }
</script>