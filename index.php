<?php
session_start();
require('config.php');
require('languages/hi/lang.hi.php');
require('common/common.php');
require('vendor/autoload.php');
$sessionProvider = new EasyCSRF\NativeSessionProvider();
$easyCSRF = new EasyCSRF\EasyCSRF($sessionProvider);

if(isset($_SESSION['username']) || !empty($_SESSION['username'])){
    header("location: dashboard.php");
    exit;
} 
 
$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $easyCSRF->check('my_token', $_POST['token']);
    }
    catch(Exception $e) {
        die($e->getMessage());
    }

    $ipAddress = Common::getIPAddress();
    $result = Common::confirmIPAddress($ipAddress);
    if($result == 1) {
        Common::showAlert("Access denied for ".TIME_PERIOD." minutes. Please try again after some time.");
        return false;
    }
 
    $trimUserName = htmlspecialchars(trim($_POST["username"], ENT_QUOTES));
    if(empty($trimUserName)){
        $username_err = 'Please enter username.';
    } else{
        $username = $trimUserName;
    }
    
    $trimPassword = trim($_POST['password']);
    if(empty($trimPassword)){
        $password_err = 'Please enter your password.';
    } else{
        $password = $trimPassword;
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT username, password, region, role, firstLogin FROM ulb_admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $username, $hashedPassword, $ulbRegion, $userRole, $firstLogin);

                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashedPassword)){
                            $_SESSION['username'] = $username;
                            $_SESSION['ulb_region'] = $ulbRegion;
                            $_SESSION['user_role'] = $userRole;
                            $_SESSION['timestamp']=time();
                            session_regenerate_id();
                            Common::clearLoginAttempts($ipAddress);
                            if($firstLogin === 0) {
                                $sql = "UPDATE ulb_admins SET firstLogin = 1 WHERE username = '".$username."'";
                                if (mysqli_query($link, $sql)) {
                                    header("location: reset_password.php");
                                } else {
                                    header("location: error.php");
                                }
                            } else {
                                header("location: dashboard.php");
                            }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = $lang['login_password_not_valid'];
                            Common::addLoginAttempt($ipAddress);
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = $lang['login_no_account_found'];
                    Common::addLoginAttempt($ipAddress);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <input type="hidden" name="token" value="<?php echo $easyCSRF->generate('my_token'); ?>">
            <div class="form-group margin-bottom-4x full-width">
                <label><?php echo $lang['username']; ?></label>
                <input type="text" name="username" autocomplete="off" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"" value="<?php echo $username; ?>" required>
                <span class="invalid-feedback text-align-center"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group margin-bottom-4x full-width" required>
                <label><?php echo $lang['password']?></label>
                <input type="password" name="password" autocomplete="off" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback text-align-center"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group full-width">
                <input type="submit" class="btn btn-primary" value="<?php echo $lang['loginButton']?>" style="margin-left: 90px;">
            </div>
        </form>
    </div>   
    <div class="alert alert-info margin-horiz-2x info-header margin-5x text-align-center">
        <strong><?php echo $lang['view_alert1']; ?></strong> <strong><a href="https://www.google.co.in/chrome/index.html" target="block">
            Google Chrome</a></strong> <strong><?php echo $lang['view_alert2'];?><strong><a href="https://www.mozilla.org/en-US/firefox/new/" target="block">&nbsp;Firefox</a>
                 <strong ><?php echo $lang['view_alert3'];?></strong>
            </div> 
</body>
</html>
