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

if($_SERVER["REQUEST_METHOD"] == "POST") {

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
    <title><?php echo $lang['select_candidates']; ?></title>
</head>
<body>
    <?php include 'header.php';?>
    <div id="get-candidates" class="get_candidates_wrapper">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group pull-left">
                            <label for="seedNumber" class="required"><?php echo $lang['seed_number']; ?></label>
                            <input type="number" autocomplete="off" name="seedNumber" min="0" class="seed-number form-control <?php echo(!empty($seed_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $seedNumber; ?>" required>
                            <span class="invalid-feedback text-align-center"><?php echo $seed_number_err; ?></span>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="<?php echo $lang['select_candidates']; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>    
</body>
</html>


<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty($seed_number_err) && empty($special_preference_err)) {

        function selectCandidate($criteria, $code, $seedNumber, $mustache, $lang) {
            $limit = Common::getCandidateSelectionLimitForSpecialPreferences($criteria);
            $data = Common::selectCandidatesForSpecialPrefCategory($criteria, $limit, $code, $seedNumber);
            $template = $mustache->loadTemplate('table_body');
            echo $template->render(array(
                'data'=>$data, 
                'lang'=>$lang,
                'totalSeats'=>$limit,
                'totalParticipated'=>Common::getTotalEnteriesBySpecialPreferences($criteria),
                'totalSelected'=>sizeof($data),
                'selectionFor'=>$criteria,
                'getReceiptNumber' => function($text, Mustache_LambdaHelper $helper) {
                    return substr($helper->render($text), strpos($helper->render($text), "_") + 1);
                },
                'getTextInHindi' => function($text, Mustache_LambdaHelper $helper) {
                    return Common::getTextInHindi(trim($helper->render($text)));
                }
            ));
        }

        $specialPreferenceArr = ['EXOFFICER', 'DISABLED', 'SPORTSPERSON'];

        for($i=0; $i<sizeof($specialPreferenceArr); $i++) {
            $criteria = strtoupper($specialPreferenceArr[$i]);
            $code = Common::getCodeForSelectionCriteria($criteria);
            if(Common::codeAndSeedExistsInDB($code, $seedNumber)) {
                $data = Common::getDataFromDbByCodeAndSeed($code, $seedNumber);
                $template = $mustache->loadTemplate('table_body');
                echo $template->render(array(
                    'data'=>$data, 
                    'lang'=>$lang,
                    'totalSeats'=>Common::getCandidateSelectionLimitForSpecialPreferences($criteria),
                    'totalParticipated'=>Common::getTotalEnteriesBySpecialPreferences($criteria),
                    'totalSelected'=>sizeof($data),
                    'selectionFor'=>$criteria,
                    'getReceiptNumber' => function($text, Mustache_LambdaHelper $helper) {
                        return substr($helper->render($text), strpos($helper->render($text), "_") + 1);
                    },
                    'getTextInHindi' => function($text, Mustache_LambdaHelper $helper) {
                        return Common::getTextInHindi(trim($helper->render($text)));
                    }
                ));
            } else {
                if(Common::existsInDB($code, 'code')) {
                    Common::showAlert($lang['candidate_already_selected']);
                    exit();
                } 
                selectCandidate($criteria, $code, $seedNumber, $mustache, $lang);
            }
        }

        mysqli_close($link);
    }
}

?>