<?php
session_start();

require('config.php');
require('languages/hi/lang.hi.php');
require('common/common.php');

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
$name = $gender = $dob = $category = $phoneNumber = $guardian = $permanentAddress = $temporaryAddress = $birthPlace = $district = $receiptNumber = $remark = $userFormValid = $specialPreference = "";
$name_err = $gender_err = $dob_err = $phone_number_err = $guardian_err = $receipt_number_err = $permanent_address_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $trimName = trim($_POST["name"]); 
    if(empty($trimName)){
        $name_err = "Please enter a name.";
    } else {
        $name = $trimName;
    }

    // Validate gender
    $trimGender = trim($_POST["gender"]); 
    if(empty($trimGender)) {
        $gender_err = "Please select a gender.";
    } else {
        $gender = $trimGender;
    }

    // Validate dob
    $trimDOB = trim($_POST["dob"]);
    if(empty($trimDOB)) {
        $dob_err = "Please select a DOB.";
    } else {
        $dob = $trimDOB;
    }

    // Validate name
    $trimGuardianName = trim($_POST["guardian"]);
    if(empty($trimGuardianName)) {
        $guardian_err = "Please enter a guardian name.";
    } else {
        $guardian = $trimGuardianName;
    }

    //validate receipt number
    $trimReceiptNumber = trim($_POST["receiptNumber"]);
    if(empty($trimReceiptNumber)) {
        $receipt_number_err = $lang['receipt_number_err'];
    } else {
        $receiptNumber = $_SESSION['ulb_region'].'_'.$trimReceiptNumber;
    }

    //validate permanent address
    $trimPermanentAddress = trim($_POST["permanentAddress"]);
    if(empty($trimPermanentAddress)) {
        $permanent_address_err = $lang['permanent_address_err'];
    } else {
        $permanentAddress = $trimPermanentAddress;
    }

    $category = trim($_POST['category']);
    $maritialStatus = trim($_POST['maritialStatus']);
    $ulbRegion = trim($_SESSION['ulb_region']);
    $phoneNumber = isset($_POST['phoneNumber']) ? trim($_POST['phoneNumber']) : '';
    $guardian = trim($_POST['guardian']);
    $temporaryAddress = isset($_POST['temporaryAddress']) ? trim($_POST['temporaryAddress']) : '';
    $birthPlace = trim($_POST['birthPlace']);
    $religion = trim($_POST['religion']);
    $district = trim($_POST['district']);
    $userFormValid = trim($_POST['userFormValid']);
    $remark = isset($_POST['remark']) ? trim($_POST['remark']) : '';
    $specialPreference = isset($_POST['specialPreference']) ? implode(',', $_POST['specialPreference']) : '';

    // Check input errors before inserting in database
    if(empty($name_err) && empty($dob_err) && empty($guardian_err) && empty($receipt_number_err) && empty($gender_err)) {
        // Prepare an insert statement
        $sql = "UPDATE candidate_list SET name=?, gender=?, dob=?, category=?, maritialStatus=?, ulbRegion=?, phoneNumber=?, guardian=?, birthPlace=?, religion=?, permanentAddress=?, temporaryAddress=?, district=?, userFormValid = ?, receiptNumber=?, remark=?, specialPreference=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssssssssssssi", $param_name, $param_gender, $param_dob, $param_category, $param_maritialStatus, $param_ulbRegion, $param_phoneNumber, $param_guardian, $param_birthPlace, $param_religion, $param_permanentAddress, $param_temporaryAddress, $param_district, $param_userFormValid, $param_receiptNumber, $param_remark, $param_specialPreference, $param_id);
            
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
            $param_specialPreference = $specialPreference;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                $_SESSION['message'] = $lang['update_success'];
                header("location: dashboard.php");
                exit();
            } else{
                if(mysqli_errno($link) === 1062) {
                    $receipt_number_err = $lang['duplicate_receipt_no'];
                } else{
                    print_r(mysqli_error($link));
                }
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM candidate_list WHERE id = ".$id." AND ulbRegion = '".$_SESSION['ulb_region']."'";

        $result = mysqli_query($link, $sql);
        if(mysqli_num_rows($result) == 1) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $dob = $row['dob'];
            $ulbRegion = $row['ulbRegion'];
            $phoneNumber = $row['phoneNumber'];
            $guardian = $row['guardian'];
            $permanentAddress = $row['permanentAddress'];
            $temporaryAddress = $row['temporaryAddress'];
            $birthPlace = $row['birthPlace'];
            $receiptNumber = $row['receiptNumber'];
            $religion = $row['religion'];
            $district = $row['district'];
            $category = $row['category'];
            $maritialStatus = $row['maritialStatus'];
            $gender = $row['gender'];
            $remark = $row['remark'];
            $userFormValid = $row['userFormValid'];
            $specialPreference = $row['specialPreference'];
            $specialPreferenceArr = isset($specialPreference) ? explode(",", $specialPreference) : [] ;
        } else {
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $lang['update_detail_title']; ?></title>
</head>
<body>
    <?php include 'header.php';?>
    <div class="wrapper">
        <div class="form-detail">
            <h2><?php echo $lang['update_detail_title']; ?></h2>
        </div>
        <form class="form-inline update_candidate_detail" role="form" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" style="margin-top: 10px; margin-left: 3px;">

            <div class="alert alert-info full-width margin-horiz-2x info-header">
                <strong><?php echo $lang['alert_msg_1']; ?></strong> <?php echo $lang['alert_msg_2']; ?> <strong><?php echo $lang['alert_msg_3']; ?></strong> <?php echo $lang['alert_msg_4']; ?>
            </div>

            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label class="required"><?php echo $lang['name'] ?></label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>

            <div class="form-group">
                <label class="required"><?php echo $lang['guardian']; ?></label>
                <input type="text" name="guardian" class="form-control" value="<?php echo $guardian; ?>" required>
            </div>

            <div class="form-group">
                <label class="required"><?php echo $lang['dob']; ?></label>
                    <input type="text" name="dob" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" class="form-control <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?>" placeholder="dd/mm/yyyy" value="<?php echo $dob; ?>" required><br>
                <span class="invalid-feedback text-align-center"><?php echo $dob_err; ?></span>
            </div>

            <div class="form-group">
                <label class="required"><?php echo $lang['permanentAddress']; ?></label>
                    <input type="text" name="permanentAddress" class="form-control <?php echo (!empty($permanent_address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $permanentAddress; ?>" required><br>
                    <span class="invalid-feedback text-align-center"><?php echo $permanent_address_err; ?></span>
            </div>

            <div class="form-group">
                <label><?php echo $lang['temporaryAddress']; ?></label>
                    <input type="text" name="temporaryAddress" class="form-control" value="<?php echo $temporaryAddress; ?>"><br>
            </div>

            <div class="form-group">
                <label for="district" class="required"><?php echo $lang['district']; ?></label>
                <select class="form-control district" name="district">
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
                <label class="required"><?php echo $lang['ulb_region'] ?></label>
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
                <span class="help-block"><?php echo $phone_number_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                <label class="required"><?php echo $lang['gender']; ?></label>
                <select class="form-control gender" name="gender">
                    <option value="m"><?php echo $lang['male']; ?></option>
                    <option value="f"><?php echo $lang['female']; ?></option>
                </select>
                <span class="help-block"><?php echo $gender_err; ?></span>
            </div>

            <div class="form-group">
                <label class="required"><?php echo $lang['nationality']; ?></label>
                <input type="text" class="form-control" value="<?php echo $lang['indian']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="maritialStatus" class="required"><?php echo $lang['maritial_status'] ?></label>
                <select class="form-control maritialStatus" name="maritialStatus">
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
                            if(in_array($_SESSION['ulb_region'], Common::TSP_AREA)) {
                                if(!in_array($value['CODE'], Common::TSP_AREA_EXCLUDE_CATEGORY)) {
                                    echo "<option value=".$value['CODE'].">".$lang[$value['NAME']]."</option>";
                                }
                            } else {
                                echo "<option value=".$value['CODE'].">".$lang[$value['NAME']]."</option>";   
                            } 
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="religion"class="required"><?php echo $lang['religion']; ?></label>
                <select class="form-control religion" name="religion">
                    <?php 
                        $religionJson = file_get_contents(__DIR__ . '/data/religion_list.json');
                        $religionArr = json_decode($religionJson, true);
                        foreach($religionArr as $key => $value) {
                            echo "<option value=".$value['NAME'].">".$lang[$value['NAME']]."</option>"; 
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label style="width: 200px;"><?php echo $lang['special_preference']; ?></label>                  
                <label style="width: 150px;">
                    <input type="checkbox" class="margin-horiz-2x" name="specialPreference[]" value="EXOFFICER" style="width: 10px !important" <?php echo (in_array("EXOFFICER", $specialPreferenceArr) ? 'checked' : '');?>><?php echo $lang['EXOFFICER']; ?>
                </label>
                <label style="width: 150px;"> 
                    <input type="checkbox" class="margin-horiz-2x" name="specialPreference[]" value="DISABLED" style="width: 10px !important" <?php echo (in_array("DISABLED", $specialPreferenceArr) ? 'checked' : '');?>><?php echo $lang['DISABLED']; ?>
                </label>
                <label style="width: 150px;"> 
                    <input type="checkbox" class="margin-horiz-2x" name="specialPreference[]" value="SPORTSPERSON" style="width: 10px !important" <?php echo (in_array("SPORTSPERSON", $specialPreferenceArr) ? 'checked' : '');?>><?php echo $lang['SPORTSPERSON']; ?>
                </label>
            </div>

            <div class="form-group">
                <label class="required" style="width: 200px;"><?php echo $lang['all_documents_provided']; ?></label>                  
                <label style="width: 60px;">                  
                    <input type="radio" class="margin-horiz-2x" name="userFormValid" value="1" style="width: 10px !important" required><?php echo $lang['yes']; ?>
                </label>
                <label style="width: 60px;"> 
                    <input type="radio" class="margin-horiz-2x" name="userFormValid" value="0" style="width: 10px !important"><?php echo $lang['no']; ?>
                </label>
                <label style="width: 150px;"> 
                    <input type="radio" class="margin-horiz-2x" name="userFormValid" value="2" style="width: 10px !important"><?php echo $lang['under_scrutiny']; ?>
                </label>
                <textarea name="remark" rows="4" cols="50" class="form-control textarea margin-left-6x" maxlength="500" value="<?php echo $remark; ?>" placeholder="<?php echo $lang['remark_place_holder']; ?>" disabled required></textarea>
            </div>

            <div class="form-group">
                <label class="required" style="width: 148px;"><?php echo $lang['receipt_number']; ?></label>
                <?php $receiptNumber = !empty($receiptNumber) ? explode('_', $receiptNumber)[1] : ""; ?>
                <input type="number" name="receiptNumber" class="form-control <?php echo (!empty($receipt_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $receiptNumber; ?>" required>
                <span class="invalid-feedback text-align-center"><?php echo $receipt_number_err; ?></span>
            </div>

            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <input type="submit" class="btn btn-primary fs4" value="<?php echo $lang['updateButton']; ?>">
                <a href="dashboard.php" class="btn btn-warning fs4"><?php echo $lang['cancelButton']; ?></a>
                <input type="button" data-id="<?php echo $id; ?>" class="btn btn-danger delete-button fs4" value="<?php echo $lang['delete_record']; ?>" />
            </div>
        </form>                
    </div>

    <button type="button" class="btn btn-info btn-lg display-none first-modal" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close margin-left-none" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo $lang['delete_alert']; ?></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default delete-data" data-dismiss="modal"><?php echo $lang['yes']?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['no']?></button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-info btn-lg display-none second-modal" data-toggle="modal" data-target="#myModalSmall">Open Small Modal</button>
    <div class="modal fade" id="myModalSmall" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close margin-left-none" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body fs20">
                    <p><?php echo $lang['delete_alert1']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default confirm-delete" data-dismiss="modal"><?php echo $lang['delete_alert2']; ?></button>
                </div>
            </div>
        </div>
    </div>


</body>
</html>

<script type="text/javascript">
    $(document).ready(function() {
        $(".maritialStatus").val('<?php echo $maritialStatus; ?>');
        $(".category").val('<?php echo $category; ?>');
        $(".district").val('<?php echo $district; ?>');
        $(".gender").val('<?php echo $gender; ?>');
        $(".religion").val('<?php echo $religion; ?>');
        $('[name="remark"]').val('<?php echo $remark; ?>');

        $('[name="userFormValid"]').on('change', function() {
            if($("input[name='userFormValid']:checked").val() == '0') {
                $('.textarea').attr('disabled', false);
            } else {
                $('.textarea').attr('disabled', true);
            }
        });

        var id = '';
        $('[data-toggle="tooltip"]').tooltip();
        $('.delete-button').on('click', function() {
            id = $('.delete-button').data('id');
            $('.first-modal').trigger('click');
        });

        $('.delete-data').on('click', function() {
            $.ajax({
                type: 'POST',
                url: 'delete.php',
                data: {id : id},
                success: function(data) {
                    data = JSON.parse(data);
                    if(data.response == 'SUCCESS') {
                        $('.second-modal').trigger('click');
                    }
                    if(data.response == 'FAILURE') {
                        $('.second-modal').trigger('click');
                    } 
                }
            });
        });

        $('.confirm-delete').on('click', function() {
            document.location.href = '<?php echo BASE_URL; ?>/dashboard.php';
        });

    });
</script>