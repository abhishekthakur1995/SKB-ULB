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
$name = $gender = $dob = $category = $phoneNumber = $guardian = $permanentAddress = $temporaryAddress = $birthPlace = $district = $remark = $receiptNumber = $userFormValid = "";
$name_err = $gender_err = $dob_err = $phone_number_err = $permanent_address_err = "";

// Processing form data when form is submitted
$result = '';
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    $trimName = trim($_POST["name"]);
    if(empty($trimName)) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST['name']);
    }

    // Validate gender
    $trimGender = trim($_POST["gender"]); 
    if(empty($trimGender)) {
        $gender_err = "Please select a gender.";
    } else {
        $gender = trim($_POST['gender']);
    }

    // Validate dob
    $trimDob = trim($_POST["dob"]); 
    if(empty($trimDob)) {
        $dob_err = "Please select a DOB.";
    } else {
        $dob = trim($_POST['dob']);
    }

    $category = trim($_POST['category']);
    $maritialStatus = trim($_POST['maritialStatus']);
    $ulbRegion = trim($_SESSION['ulb_region']);
    $phoneNumber = isset($_POST['phoneNumber']) ? trim($_POST['phoneNumber']) : '';
    $guardian = trim($_POST['guardian']);
    $permanentAddress = trim($_POST['permanentAddress']);
    $temporaryAddress = isset($_POST['temporaryAddress']) ? trim($_POST['temporaryAddress']) : '';
    $birthPlace = trim($_POST['birthPlace']);
    $religion = trim($_POST['religion']);
    $district = trim($_POST['district']);
    $userFormValid = $_POST['userFormValid'];
    $receiptNumber = $_SESSION['ulb_region'].'_'.$_POST['receiptNumber'];
    $remark = isset($_POST['remark']) ? trim($_POST['remark']) : '';

    // Check input errors before inserting in database
    if(empty($name_err) && empty($dob_err)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO candidate_list (name, gender, dob, category, maritialStatus, ulbRegion, phoneNumber, guardian, birthPlace, religion, permanentAddress, temporaryAddress , district, userFormValid, receiptNumber, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssssssssss", $param_name, $param_gender, $param_dob, $param_category, $param_maritialStatus, $param_ulbRegion, $param_phoneNumber, $param_guardian, $param_birthPlace, $param_religion, $param_permanentAddress, $param_temporaryAddress, $param_district, $param_userFormValid, $param_receiptNumber, $param_remark);
            
            // Set parameters
            $param_name = $name;
            $param_gender = $gender;
            $param_dob = $dob;
            $param_category = $category;
            $param_maritialStatus = $maritialStatus;
            $param_ulbRegion = $ulbRegion;
            $param_phoneNumber = $phoneNumber;
            $param_guardian = $guardian;
            $param_permanentAddress = $permanentAddress;
            $param_temporaryAddress = $temporaryAddress;
            $param_birthPlace = $birthPlace;
            $param_religion = $religion;
            $param_district = $district;
            $param_userFormValid = $userFormValid;
            $param_receiptNumber = $receiptNumber;
            $param_remark = $remark;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $result='<div class="alert alert-success">SUCCESS</div>';
                //header("location: candidate_details.php");
            } else {
                $result='<div class="alert alert-danger">'.mysqli_error($link).'</div>';
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
    <title><?php echo $lang['enter_candidate_details']?></title>
</head>
<body>
    <?php include 'header.php';?>
    <div class="wrapper">
        <div class="form-detail">
            <h2><?php echo $lang['enter_candidate_details']?></h2>
            <p><?php echo $lang['detail_header']?></p>
        </div>
        <?php echo $result; ?>
        <form class="form-inline candidate_detail" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="margin-top: 10px;" method="post">

            <div class="alert alert-info full-width margin-horiz-2x info-header">
                <strong><?php echo $lang['alert_msg_1']; ?></strong> <?php echo $lang['alert_msg_2']; ?> <strong><?php echo $lang['alert_msg_3']; ?></strong> <?php echo $lang['alert_msg_4']; ?>
            </div>

            <div class="form-group">
                <label class="required"><?php echo $lang['name']; ?></label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" required>
                <span class="invalid-feedback text-align-center"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label class="required"><?php echo $lang['guardian']; ?></label>
                <input type="text" name="guardian" class="form-control" value="<?php echo $guardian; ?>" required>
            </div>
            <div class="form-group">
                <label><?php echo $lang['dob']; ?></label>
                    <input type="date" name="dob" class="form-control <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?>" min="1950-01-01" onkeydown="return false"><br>
                <span class="invalid-feedback text-align-center"><?php echo $dob_err; ?></span>
            </div>
            <div class="form-group">
                <label class="required"><?php echo $lang['permanentAddress']; ?></label>
                    <input type="text" name="permanentAddress" class="form-control" value="<?php echo $permanentAddress; ?>" required><br>
            </div>
            <div class="form-group">
                <label><?php echo $lang['temporaryAddress']; ?></label>
                    <input type="text" name="temporaryAddress" class="form-control" value="<?php echo $temporaryAddress; ?>"><br>
            </div>
            <div class="form-group">
                <label for="district"><?php echo $lang['district']; ?></label>
                <select class="form-control" name="district">
                    <?php 
                        $districtJson = file_get_contents(__DIR__ . '/data/district_list.json');
                        $districtArr = json_decode($districtJson, true);
                        foreach($districtArr as $key => $value) {
                            echo "<option value=".$value['NAME'].">".$value['NAME']."</option>"; 
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label><?php echo $lang['birth_place']; ?></label>
                <input type="text" name="birthPlace" class="form-control" value="<?php echo $birthPlace; ?>">
            </div>
            <div class="form-group">
                <label class="required"><?php echo $lang['ulb_region']; ?></label>
                <input type="hidden" name="ulbRegion" value="<?php echo ucwords(strtolower($_SESSION['ulb_region']))?>" />
                <input type="text" name="ulbRegion" class="form-control" value="<?php echo ucwords(strtolower($_SESSION['ulb_region']))?>" readonly>
            </div>
            <div class="form-group <?php echo (!empty($phone_number_err)) ? 'has-error' : ''; ?>">
                <label><?php echo $lang['phone_number']; ?></label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">+91</div>
                    </div>
                    <input type="number" name="phoneNumber" class="form-control" onKeyPress="if(this.value.length==10) return false;" value="<?php echo $phoneNumber; ?>" style="width: 200px !important;">
                </div>
                <span class="invalid-feedback text-align-center"><?php echo $phone_number_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                <label class="required"><?php echo $lang['gender']; ?></label>
                <select class="form-control" name="gender">
                    <option value="m"><?php echo $lang['male']; ?></option>
                    <option value="f"><?php echo $lang['female']; ?></option>
                </select>
                <span class="invalid-feedback text-align-center"><?php echo $gender_err; ?></span>
            </div>
            <div class="form-group">
                <label class="required"><?php echo $lang['nationality']; ?></label>
                <input type="text" class="form-control" value="<?php echo $lang['indian']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="maritialStatus" class="required"><?php echo $lang['maritial_status']; ?></label>
                <select class="form-control maritial_status" name="maritialStatus">
                    <?php 
                        $maritialStatusJson = file_get_contents(__DIR__ . '/data/maritial_status.json');
                        $maritialStatusArr = json_decode($maritialStatusJson, true);
                        foreach($maritialStatusArr as $key => $value) {
                            echo "<option value=".$value['CODE'].">".$lang[$value['NAME']]."</option>"; 
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category" class="required"><?php echo $lang['category']; ?></label>
                <select class="form-control category" name="category">
                    <?php 
                        $categoryListJson = file_get_contents(__DIR__ . '/data/category_list.json');
                        $categoryListArr = json_decode($categoryListJson, true);
                        foreach($categoryListArr as $key => $value) {
                            echo "<option value=".$value['CODE'].">".$lang[$value['NAME']]."</option>"; 
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="religion" class="required"><?php echo $lang['religion']; ?></label>
                <select class="form-control" name="religion">
                    <?php 
                        $religionJson = file_get_contents(__DIR__ . '/data/religion_list.json');
                        $religionArr = json_decode($religionJson, true);
                        foreach($religionArr as $key => $value) {
                            echo "<option value=".$value['NAME'].">".$lang[$value['NAME']]."</option>"; 
                        }
                    ?>
                </select>
            </div>

            <div class="form-group full-width">
                <label class="required" style="width: 200px;"><?php echo $lang['all_documents_provided']; ?></label>                  
                <label style="width: 60px;">                  
                    <input type="radio" class="margin-horiz-2x" name="userFormValid" style="width: 10px !important" value="1" required><?php echo $lang['yes']; ?>
                </label>
                <label style="width: 60px;"> 
                    <input type="radio" class="margin-horiz-2x" name="userFormValid" value="0" style="width: 10px !important"><?php echo $lang['no']; ?>
                </label>
                <textarea name="remark" rows="4" cols="50" class="form-control textarea margin-left-6x" maxlength="500" value="<?php echo $remark; ?>" placeholder="<?php echo $lang['remark_place_holder']; ?>" disabled required></textarea>
            </div>

            <div class="form-group full-width">
                <label class="required" style="width: 148px;"><?php echo $lang['receipt_number']; ?></label>
                <input type="number" name="receiptNumber" class="form-control" value="<?php echo $receiptNumber; ?>" required>
            </div>

            <div class="form-group full-width margin-left-3x">
                <input type="submit" name="submit" class="btn btn-primary save" value="<?php echo $lang['saveButton'] ?>">
                <input type="reset" class="btn btn-default" value="<?php echo $lang['resetButton'] ?>">
            </div>
        </form>
    </div>    
</body>
</html>

<script type="text/javascript">
$('document').ready(function() {

    $('.save').on('click', function() {
        if($('.alert-success').is(":visible")) {
            
        }
    });

    $('[name="userFormValid"]').on('change', function() {
        if($("input[name='userFormValid']:checked").val() == '1') {
            $('.textarea').attr('disabled', true);
        } else {
            $('.textarea').attr('disabled', false);
        }
    });
});
</script>