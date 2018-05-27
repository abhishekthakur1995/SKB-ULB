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

// Define variables and initialize with empty values
$currentPassword = $newPassword = $confirmNewPassword = "";
$current_password_err = $new_password_err = $confirm_new_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate new password
    if(empty(trim($_POST['newPassword']))){
        $new_password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['newPassword'])) < PASSWORD_REQUIRED_LENGTH){
        $new_password_err = $lang['password_length_error'];
    } else{
        $newPassword = trim($_POST['newPassword']);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirmNewPassword"]))){
        $confirm_new_password_err = 'Please confirm password.';     
    } else{
        $confirmNewPassword = trim($_POST['confirmNewPassword']);
        if($newPassword != $confirmNewPassword){
            $confirm_new_password_err = $lang['password_mismatch_error'];
        }
    }

    // Validate current password
    if(empty(trim($_POST["currentPassword"]))){
        $current_password_err = $lang['currentPasswodErrMsg_1'];
    } elseif(strlen(trim($_POST['newPassword'])) < PASSWORD_REQUIRED_LENGTH){
        $current_password_err = $lang['password_length_error'];
    } else {
        $currentPassword = trim($_POST['currentPassword']);
    }

    if(empty($current_password_err) && empty($confirm_new_password_err) && empty($new_password_err)) {
        $sql = 'SELECT * from '.ULB_ADMIN_TABLE.' password = ?';

        if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM ulb_admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $_SESSION['username'];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)) {
                        if(password_verify($currentPassword, $hashed_password)){
                            /* Password is correct, so update the password */

                            $sql = "UPDATE ".ULB_ADMIN_TABLE." SET password = ? WHERE username = ?";
        
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_username);
                
                                // Set parameters
                                $param_username = $_SESSION['username'];
                                $param_password = password_hash($newPassword, PASSWORD_DEFAULT); // Creates a password hash
                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    $_SESSION = array();
                                    session_destroy();
                                    session_unset();      
                                    header("location: index.php");
                                } else {
                                    echo "Something went wrong. Please try again later.";
                                }
                            }
                            
                        } else {
                            // Display an error message if password is not valid
                            $current_password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reset Password</title>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 400px; padding: 20px; margin:auto; background-color: #fff; margin-top:100px;}
    </style>
</head>
<body>
    <?php include 'header.php';?>
    <div class="wrapper">
        <h2><?php echo $lang['reset_password'] ?></h2>
        <p><?php echo $lang['reset_password_header']; ?></p>
        <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group margin-bottom-4x">
                <label style="width:140px"><?php echo $lang['reset_password_msg_1']; ?></label>
                <input type="password" name="currentPassword" class="form-control" <?php echo (!empty($confirm_new_password_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback text-align-center"><?php echo $current_password_err; ?></span>
            </div>    
            <div class="form-group margin-bottom-4x">
                <label style="width:140px"><?php echo $lang['reset_password_msg_2']; ?></label>
                <input type="password" name="newPassword" class="form-control" <?php echo (!empty($confirm_new_password_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback text-align-center"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group margin-bottom-4x">
                <label style="width:140px"><?php echo $lang['reset_password_msg_3']; ?></label>
                <input type="password" name="confirmNewPassword" class="form-control <?php echo (!empty($confirm_new_password_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback text-align-center"><?php echo $confirm_new_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="<?php echo $lang['resetPasswordButton']; ?>" style="margin-left: 130px; margin-top: 10px;">
            </div>
        </form>
    </div>    
</body>
</html>