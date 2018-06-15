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

$seedNumber = $specialPreference = '';
$seed_number_err = $special_preference_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $trimSpecialPreference = $_POST["specialPreference"];
    if(empty($trimSpecialPreference)){
        $special_preference_err = "Please enter a special number.";
    } else {
        $specialPreference = $trimSpecialPreference;
    }

    $trimSeedNumber = $_POST["seedNumber"];
    if(empty($trimSeedNumber)){
        $seed_number_err = "Please enter a seed number.";
    } else {
        $seedNumber = $trimSeedNumber;
    }
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
    <div id="get-candidates" class="get_candidates_wrapper">
        <div class="form-detail">
            <h2>Get Candidates</h2>
            <p>Select the criteria to select a candidate</p>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="seedNumber" class="required"><?php echo $lang['seed_number']; ?></label>
                            <input type="number" name="seedNumber" min="0" class="form-control <?php echo(!empty($seed_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $seedNumber; ?>" required>
                            <span class="invalid-feedback text-align-center"><?php echo $seed_number_err; ?></span>
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="form-group">
                            <label for="specialPreference" class="required"><?php echo $lang['category']; ?></label>
                            <select class="form-control" name="specialPreference">
                                <?php 
                                    $specialPreferenceListJson = file_get_contents(__DIR__ . '/data/special_preference.json');
                                    $specialPreferenceArr = json_decode($specialPreferenceListJson, true);
                                    foreach($specialPreferenceArr as $key => $value) {
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
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty($seed_number_err) && empty($special_preference_err)) {

        $criteria = strtoupper($specialPreference);
        $code = Common::getCodeForSelectionCriteria($criteria);

        if(Common::codeAndSeedExistsInDB($code, $seedNumber)) {
            $data = Common::getDataFromDbByCodeAndSeed($code, $seedNumber);
            $template = $mustache->loadTemplate('table_body');
            echo $template->render(array('data'=>$data, 'total'=>sizeof($data)));
        } else {
            if(Common::existsInDB($code, 'code')) {
                echo "Candidates have already been selected from this criteria";
            } else if(Common::existsInDB($seedNumber, 'seedNumber')){
                echo "This seed number is already used.";
            } else {
                $limit = Common::getCandidateSelectionLimitForSpecialPreferences($criteria);
                $data = Common::selectCandidatesForSpecialPrefCategory($criteria, $limit, $code, $seedNumber);
                $template = $mustache->loadTemplate('table_body');
                echo $template->render(array('data'=>$data, 'total'=>sizeof($data)));
            }
        }
        mysqli_close($link);
    }
}

?>