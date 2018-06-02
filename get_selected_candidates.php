<?php
session_start();

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

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Selected Candidates</title>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin: auto;}
        .text-align-center { text-align: center; }
    </style>
</head>
<body>
    <?php include 'header.php';?>
    <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-detail">
                <div class="form-group-new">
                    <label><?php echo $lang['seed_number']; ?></label>
                    <input type="text" name="seedNumber" class="form-control" required>
                </div>
                <div class="form-group-new">
                    <input type="submit" class="btn btn-primary" value="Get Candidate List">
                </div>
            </div>
    </form>
</body>
</html>


<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $sql = "SELECT * FROM candidate_list WHERE STATUS = 1 AND seedNumber = '".$_POST['seedNumber']."'";

    if ($res = mysqli_query($link, $sql)) {
                echo "<h3 class='text-align-center'>Selected Candidates</h3>";
                echo "<table class='table table-striped table-hover table-condensed'>";
                echo "<tr>";
                echo "<th>S.No</th>";
                echo "<th>Name</th>";
                echo "<th>Guardian</th>";
                echo "<th>Address</th>";
                echo "<th>Gender</th>";
                echo "<th>DOB</th>";
                echo "<th>Category</th>";
                echo "</tr>";
                if (mysqli_num_rows($res) > 0) {
                    $sno = 0;
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<tr>";
                        echo "<td>".++$sno."</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['guardian']."</td>";
                        echo "<td>".$row['permanentAddress']."</td>";
                        $fullGender = $row['gender'] == 'm' ? 'Male' : 'Female';
                        echo "<td>".$fullGender."</td>";
                        echo "<td>".$row['dob']."</td>";
                        echo "<td>".$row['category']."</td>";
                        echo "</tr>";  
                    }
                } else {
                    echo "<tr>";
                        echo "<td>No Record Found</td>";
                    echo "</tr>";
                }
            }
            echo "</table>";

            echo "<div class='text-align-center'><input type='button' id='printbtn' class='btn btn-primary' onclick='printpage()' value='Print'></div>";
}
?>

<script type="text/javascript">
    function printpage() {
        var printButton = document.getElementById("printbtn"); 
        printButton.style.visibility = 'hidden';
        window.print()
        printButton.style.visibility = 'visible';
    }
</script>