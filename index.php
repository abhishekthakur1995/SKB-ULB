<?php
// Include config file
require('config.php');
require('languages/hi/lang.hi.php');
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    $trimUserName = trim($_POST["username"]);
    if(empty($trimUserName)){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    $trimPassword = trim($_POST['password']);
    if(empty($trimPassword)){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password, region, role, firstLogin FROM ulb_admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashedPassword, $ulbRegion, $userRole, $firstLogin);

                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashedPassword)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();

                            $_SESSION['username'] = $username;
                            $_SESSION['ulb_region'] = $ulbRegion;
                            $_SESSION['user_role'] = $userRole;
                            $_SESSION['timestamp']=time();
                            if($firstLogin === 0) {
                                $sql = "UPDATE ulb_admins SET firstLogin = 1 WHERE username = '".$username."'";
                                if (mysqli_query($link, $sql)) {
                                    header("location: reset_password.php");
                                } else {
                                    $msg = mysqli_error($link);
                                    header("location: error.php?err_msg=$msg");
                                }
                            } else {
                                header("location: dashboard.php");
                            }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = $lang['login_password_not_valid'];
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = $lang['login_no_account_found'];
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <meta charset="UTF-8">
    <title><?php echo $lang['login']; ?></title>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin:auto; background-color: #fff; margin-top:100px;}
    </style>
</head>
<body>
    <?php include 'header.php';?>
    <div class="wrapper">
        <h2><?php echo $lang['login']; ?></h2>
        <p><?php echo $lang['login_detail_header']; ?></p>
        <form class="form-inline login_detail" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group margin-bottom-4x full-width">
                <label><?php echo $lang['username']; ?></label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"" value="<?php echo $username; ?>" required>
                <span class="invalid-feedback text-align-center"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group margin-bottom-4x full-width" required>
                <label><?php echo $lang['password']?></label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback text-align-center"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group full-width">
                <input type="submit" class="btn btn-primary" value="<?php echo $lang['loginButton']?>" style="margin-left: 90px;">
            </div>
        </form>
    </div>   
    <div class="alert alert-info full-width margin-horiz-2x info-header margin-5x text-align-center"F>
        <strong><?php echo $lang['view_alert1']; ?></strong> <strong><a href="https://www.google.co.in/chrome/index.html" target="block">
            Google Chrome</a></strong> <strong><?php echo $lang['view_alert2'];?><strong><a href="https://www.mozilla.org/en-US/firefox/new/" target="block">&nbsp;Firefox</a>
                 <strong ><?php echo $lang['view_alert3'];?></strong>
            </div> 
</body>
</html>