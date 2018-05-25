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
                echo $result;
                //header("location: candidate_details.php");
            } else {
                $result='<div class="alert alert-danger">'.mysqli_error($link).'</div>';
                echo $result;
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}

?>