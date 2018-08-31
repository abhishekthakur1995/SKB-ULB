<?php

session_start();
 
if($_SESSION['user_role'] == 'SUPERADMIN') {
    require('../../config.php');

    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("location: ../../index.php");
        exit;
    } else {
        if (time()-$_SESSION['timestamp'] > IDLE_TIME) {
            header("location: ../../logout.php");
        }   else{
            $_SESSION['timestamp']=time();
        }
    }
} else {
    header("location: ../../error.php");
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>CSV-2-SQL</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    </head>
<body>
<br>
<h1> CSV to Mysql </h1>

</br>
<form class="form-horizontal" action="csv2sql.php" method="post">
	<div class="form-group">
        <label for="csvfile" class="control-label col-xs-2">Name of the file</label>
		<div class="col-xs-3">
            <input type="name" class="form-control" name="csv" id="csv">
		</div>
    </div>
	<div class="form-group">
	<label for="login" class="control-label col-xs-2"></label>
    <div class="col-xs-3">
    <button type="submit" class="btn btn-primary">Export to Database</button>
	</div>
	</div>
</form>
</div>

</body>

<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['csv'])) {

        $file=$_POST['csv'];
        $table = "candidate_list";

        $result1=mysqli_query($link,"select count(*) count from $table");
        $r1=mysqli_fetch_array($result1);
        $count1=(int)$r1['count'];

        mysqli_query($link, '
            LOAD DATA LOCAL INFILE "'.$file.'"
            INTO TABLE candidate_list
            CHARACTER SET utf8
            FIELDS TERMINATED BY \',\'
            OPTIONALLY ENCLOSED BY \'"\'
            LINES TERMINATED BY \'\n\'
            IGNORE 1 LINES
            (ulbRegion, name, guardian, permanentAddress, district, dob, gender, maritialStatus, category, receiptNumber, specialPreference, userFormValid, remark)'
        ) or die(mysqli_error($link));

        $result2=mysqli_query($link,"select count(*) count from $table");
        $r2=mysqli_fetch_array($result2);
        $count2=(int)$r2['count'];

        $count=$count2-$count1;
        if($count>0) {
            echo "Success";
            echo "<b> total $count records have been added to the table $table </b> ";
        } else {
            echo "No Record Entered";
        }
    } else {
        echo "Please enter file name";
    }
}
?>
</html>
