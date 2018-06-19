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

$gender = $category = $maritialStatus = $seedNumber = "";
$gender_err = $maritial_status_err = $seed_number_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $trimGender = trim($_POST["gender"]); 
    if(empty($trimGender)) {
        $gender_err = "Please select a gender.";
    } else {
        $gender = $trimGender;
    }

    $category = trim($_POST["category"]);

    $trimSeedNumber = $_POST["seedNumber"];
    if(empty($trimSeedNumber)){
        $seed_number_err = "Please enter a seed number.";
    } else {
        $seedNumber = $trimSeedNumber;
    }

    $maritialStatus = isset($_POST['maritialStatus']) ? trim($_POST['maritialStatus']) : '';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Get Candidates</title>
</head>
<body>
    <?php include 'header.php';?>
    <div id="get-candidates_2" class="get_candidates_wrapper">
        <div class="form-detail">
            <h2>Get Candidates</h2>
            <p>Select the criteria to select a candidate</p>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="container no-margin">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="seedNumber" class="required"><?php echo $lang['seed_number']; ?></label>
                            <input type="number" autocomplete="off" min="0" name="seedNumber" class="form-control <?php echo(!empty($seed_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $seedNumber; ?>" required>
                            <span class="invalid-feedback text-align-center"><?php echo $seed_number_err; ?></span>
                        </div>
                    </div>
                    <div class="col-sm">
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
                    </div>
                    <div class="col-sm">
                        <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                            <label class="required"><?php echo $lang['gender']; ?></label>
                            <select class="form-control gender" name="gender">
                                <option value="m"><?php echo $lang['male']; ?></option>
                                <option value="f"><?php echo $lang['female']; ?></option>
                            </select>
                            <span class="invalid-feedback text-align-center"><?php echo $gender_err; ?></span>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="maritialStatus" class="required"><?php echo $lang['maritial_status']; ?></label>
                            <select class="form-control maritial_status" name="maritialStatus">
                                <?php 
                                    $maritialStatusJson = file_get_contents(__DIR__ . '/data/maritial_status_reservation.json');
                                    $maritialStatusArr = json_decode($maritialStatusJson, true);
                                    foreach($maritialStatusArr as $key => $value) {
                                        echo "<option value=".$value['CODE'].">".$lang[$value['NAME']]."</option>"; 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Get Candidate List">
            </div>
        </form>
    </div>    
</body>
</html>


<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($gender_err) && empty($category_err) && empty($seed_number_err)) {
        $genderCode = $gender == 'm' ? 'MALE' : 'FEMALE';
        $criteria = strtoupper($category.'_'.$genderCode);
        if($maritialStatus) {
            $criteria = strtoupper($criteria.'_'.$maritialStatus);
        }
        $code = Common::getCodeForSelectionCriteria($criteria);

        if(Common::codeAndSeedExistsInDB($code, $seedNumber)) {
            $data = Common::getDataFromDbByCodeAndSeed($code, $seedNumber);
            $template = $mustache->loadTemplate('table_body');
            echo $template->render(array('data'=>$data, 'total'=>sizeof($data)));
        } else {
            if(Common::existsInDB($code, 'code')) {
                echo "Candidates have already been selected from this criteria";
            } else if(Common::existsInDB($seedNumber, 'seedNumber')) {
                echo "This seed number is already used.";
            } else {
                $limit = Common::getCandidateSelectionLimit($criteria);

                $data = Common::selectCandidatesForOthersCategory($criteria, $limit, $code, $seedNumber);

                $template = $mustache->loadTemplate('table_body');
                echo $template->render(array('data'=>$data, 'total'=>sizeof($data)));

                // $carriedForwardSeats = $limit - sizeof($totalData[0]);
                // $discardSeats = 0;
                // $newData = $totalData[1];

                // if($carriedForwardSeats > 0) {
                //     if(sizeof($newData > 0)) {
                //         if(sizeof($newData) < $carriedForwardSeats) {
                //             $discardSeats = $carriedForwardSeats - sizeof($newData);
                //         }
                //         $carriedForwardSeats = sizeof($newData);    
                //     }
                //     Common::carryForwardSeats($carriedForwardSeats, $code, $discardSeats);
                // }
            }
        }
        mysqli_close($link);
    }
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.maritial_status').attr('disabled', true);
        $('.gender').change(function() {
            if($('.gender').val() !== '') {
                $('.maritial_status').attr('disabled', true);
                if($('.gender').val() === 'f') {
                    $('.maritial_status').attr('disabled', false);
                } else {
                    $('.maritial_status').attr('disabled', true);
                } 
            } else {
                $('.maritial_status').attr('disabled', true);
            }
        });
    });  
</script>    