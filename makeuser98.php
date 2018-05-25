<?php
// Include config file
require('config.php');
require('languages/hi/lang.hi.php');
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $region = $role = "";
$username_err = $password_err = $confirm_password_err = $region_err = $role_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    $trimUserName = trim($_POST["username"]);
    if(empty($trimUserName)) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM ulb_admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    $trimPassword = trim($_POST['password']);
    if(empty($trimPassword)) {
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    $trimConfirmPassword = trim($_POST["confirm_password"]);
    if(empty($trimConfirmPassword)) {
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = $lang['password_mismatch_error'];
        }
    }

    $role = trim($_POST['role']);

    //validate region
    $trimRegion = trim($_POST["region"]);
    if(empty($trimRegion)) {
        $region_err = 'Please select an ULB region.';
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM ulb_admins WHERE region = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_region);
            
            // Set parameters
            $param_region = trim($_POST["region"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $region_err = "An admin user has already been created for this ulb";
                } else{
                    $region = trim($_POST["region"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($region_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO ulb_admins (username, password, region, role) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variabless to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_region, $param_role);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_region = $region;
            $param_role = $role;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                echo "ULB User Created.";
            } else{
                echo "Something went wrong. Please try again later.";
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
    <title>Sign Up</title>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin:auto;}
    </style>
</head>
<body>
     <?php include 'header.php';?>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label for="region">ULB</label>
                    <select class="form-control <?php echo (!empty($region_err)) ? 'is-invalid' : ''; ?>"" name="region">
                        <?php 
                            $ulbListJson = file_get_contents(__DIR__ . '/data/ulb_list.json');
                            $ulbListArr = json_decode($ulbListJson, true);
                            foreach($ulbListArr as $key => $value) {
                                echo "<option value=".$value['CODE'].">".$value['NAME']."</option>"; 
                            }
                        ?>
                    </select>
                <span class="invalid-feedback"><?php echo $region_err; ?></span>
            </div>
            <div class="form-group">
                <label for="role">ROLE</label>
                    <select class="form-control" name="role">
                        <?php 
                            $roleListJson = file_get_contents(__DIR__ . '/data/role_list.json');
                            $roleListArr = json_decode($roleListJson, true);
                            foreach($roleListArr as $key => $value) {
                                echo "<option value=".$value['NAME'].">".$value['NAME']."</option>"; 
                            }
                        ?>
                    </select>
                <span class="invalid-feedback"><?php echo $region_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>