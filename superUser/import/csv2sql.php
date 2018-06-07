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
    header("location: ../../error.php?err_msg=Access Not Allowed");
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
<p> This Php Script Will Import very large CSV files to MYSQL database in a minute</p>

</br>
<form class="form-horizontal" action="csv2sql.php" method="post">
    <div class="form-group">
        <label for="mysql" class="control-label col-xs-2">Mysql Server address (or)<br>Host name</label>
		<div class="col-xs-3">
        <input type="text" class="form-control" name="mysql" value="localhost" id="mysql" placeholder="">
		</div>
    </div>
	<div class="form-group">
        <label for="username" class="control-label col-xs-2">Username</label>
		<div class="col-xs-3">
        <input type="text" class="form-control" name="username" value="root" id="username" placeholder="">
		</div>
    </div>
	<div class="form-group">
        <label for="password" class="control-label col-xs-2">Password</label>
		<div class="col-xs-3">
        <input type="text" class="form-control" name="password" value="" id="password" placeholder="">
		</div>
    </div>
	<div class="form-group">
        <label for="db" class="control-label col-xs-2">Database name</label>
		<div class="col-xs-3">
        <input type="text" class="form-control" value="candidate_selection_portal" name="db" id="db" placeholder="">
		</div>
    </div>
	
	<div class="form-group">
        <label for="table" class="control-label col-xs-2">table name</label>
		<div class="col-xs-3">
        <input type="name" class="form-control" value="candidate_list" name="table" id="table">
		</div>
    </div>
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

if(isset($_POST['username'])&&isset($_POST['mysql'])&&isset($_POST['db'])&&isset($_POST['username'])) {
$sqlname=$_POST['mysql'];
$username=$_POST['username'];
$table=$_POST['table'];
$password=isset($_POST['password']) ? $_POST['password'] : '';
$db=$_POST['db'];
$file=$_POST['csv'];

$result1=mysqli_query($link,"select count(*) count from $table");
$r1=mysqli_fetch_array($result1);
$count1=(int)$r1['count'];
//If the fields in CSV are not seperated by comma(,)  replace comma(,) in the below query with that  delimiting character
//If each tuple in CSV are not seperated by new line.  replace \n in the below query  the delimiting character which seperates two tuples in csv
// for more information about the query http://dev.mysql.com/doc/refman/5.1/en/load-data.html
mysqli_query($link, '
    LOAD DATA LOCAL INFILE "'.$file.'"
    INTO TABLE candidate_list
    CHARACTER SET utf8
    FIELDS TERMINATED BY \',\'
    OPTIONALLY ENCLOSED BY \'"\'
    LINES TERMINATED BY \'\n\'
    IGNORE 0 LINES
    (name, guardian, permanentAddress, temporaryAddress,  phoneNumber, birthPlace, gender, district, ulbRegion, maritialStatus, dob, category, receiptNumber, religion, userFormValid, remark)'
) or die(mysqli_error());

$result2=mysqli_query($link,"select count(*) count from $table");
$r2=mysqli_fetch_array($result2);
$count2=(int)$r2['count'];

$count=$count2-$count1;
if($count>0)
echo "Success";
echo "<b> total $count records have been added to the table $table </b> ";
}
else{
echo "Mysql Server address/Host name ,Username , Database name ,Table name , File name are the Mandatory Fields";
}

?>

</html>
