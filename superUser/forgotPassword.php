<?php
session_start();

if (isset($_SESSION['message'])) {
    $msg = $_SESSION['message'];
    echo '<script language="javascript">';
    echo "alert('$msg')";
    echo '</script>';
    unset($_SESSION['message']);
}

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

$ulb = $ulb_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){

	$trimUlb = trim($_POST['ulb']);
	if(empty($trimUlb)) {
		$ulb_err = 'Please select a ulb to proceed further';
	} else {
		$ulb = $trimUlb;
	}

	if(empty($ulb_err)) {
		$passsword = password_hash(DEFAULT_PASSWORD, PASSWORD_DEFAULT);
		$sql = "UPDATE ulb_admins SET firstLogin = 0, password = '".$passsword."' WHERE region = '".$ulb."'";
		if(mysqli_query($link, $sql)){
    		$_SESSION['message'] = 'Password has been successfully resetted for the selected ulb';
            header("Location: forgotPassword.php");
		} else {
    		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}
 
		// Close connection
		mysqli_close($link);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Set Password for ULB</title>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 400px; padding: 20px; margin:auto; background-color: #fff; margin-top:100px;}
    </style>
</head>
<body>
    <?php include '../header.php';?>
    <div class="wrapper">
        <h2>Forgot Password</h2>
        <form class="form-inline" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group full-width">
                <label>Select the ULB for which you want to reset the password</label>
                <select class="form-control <?php echo (!empty($ulb_err)) ? 'is-invalid' : ''; ?>"" name="ulb">
                	<option value="">Select</option>
                    <?php 
                        $ulbListJson = file_get_contents(__DIR__ . '/../data/ulb_list.json');
                        $ulbListArr = json_decode($ulbListJson, true);
                        foreach($ulbListArr as $key => $value) {
                            echo "<option value=".$value['CODE'].">".$value['NAME']."</option>"; 
                        }
                    ?>
                </select>
                <span class="invalid-feedback"><?php echo $ulb_err; ?></span>
            </div>
            <div class="form-group full-width margin-top-3x">
                <input type="submit" class="btn btn-primary" value="Get New Password">
            </div>
        </form>
    </div>    
</body>
</html>