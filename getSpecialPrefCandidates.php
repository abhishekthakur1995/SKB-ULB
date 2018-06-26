<?php

session_start();

require('config.php');
require('languages/hi/lang.hi.php');
require('common/common.php');
require('vendor/autoload.php');
$sessionProvider = new EasyCSRF\NativeSessionProvider();
$easyCSRF = new EasyCSRF\EasyCSRF($sessionProvider);

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
    try {
        $easyCSRF->check('my_token', $_POST['token']);
    }
    catch(Exception $e) {
        die($e->getMessage());
    }

    $trimSeedNumber = $_POST["seedNumber"];
    if(empty($trimSeedNumber)){
        $seed_number_err = "Please enter a seed number.";
    } else {
        $seedNumber = htmlspecialchars($trimSeedNumber);
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
    <?php include 'lottery_information.php';?>
    <div id="get-candidates" class="get_candidates_wrapper">
        <div class="row">
            <div class="col alert alert-info margin-5x text-align-center">
                <a data-toggle="modal" data-target="#lotteryInformation" class="fs4"><?php echo $lang['lottery_msg_1'];?>
                <strong class="text-decoration-underline clr-blue"><?php echo $lang['lottery_msg_2'];?></strong>
            </a>
            </div>
            <div class="col alert alert-info margin-5x text-align-center">
                <a class="fs4" href="getAllCategoryCandidates.php"><?php echo $lang['lottery_msg_7']; ?></a> 
                </a>
            </div>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="token" value="<?php echo $easyCSRF->generate('my_token'); ?>">
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group pull-left">
                            <label for="seedNumber" class="required"><?php echo $lang['seed_number']; ?></label>
                                <input type="text" autocomplete="off" name="seedNumber" maxlength="4" class="seed-number form-control <?php echo(!empty($seed_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $seedNumber; ?>" pattern="\d{4}" required/>
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
        function selectCandidate($criteria, $code, $seedNumber, $mustache, $lang, $print) {
            $limit = Common::getCandidateSelectionLimitForSpecialPreferences($criteria);
            $data = Common::selectCandidatesForSpecialPrefCategory($criteria, $limit, $code, $seedNumber);
            if($print) {
                $template = $mustache->loadTemplate('print_button');
                echo $template->render();
                $template = $mustache->loadTemplate('print_header');
                echo $template->render(array('lang'=>$lang));
            }
            $template = $mustache->loadTemplate('table_body');
            echo $template->render(array(
                'data'=>$data, 
                'lang'=>$lang,
                'totalSeats'=>$limit,
                'totalParticipated'=>Common::getTotalEnteriesBySpecialPreferences($criteria),
                'totalSelected'=>sizeof($data),
                'selectionFor'=>$criteria,
                'seedNumber'=>$seedNumber,
                'errorMessage'=>Common::getErrorMessage($limit, sizeof($data)),
                'getReceiptNumber' => function($text, Mustache_LambdaHelper $helper) {
                    return substr($helper->render($text), strpos($helper->render($text), "_") + 1);
                },
                'getTextInHindi' => function($text, Mustache_LambdaHelper $helper) {
                    return Common::getTextInHindi(trim($helper->render($text)));
                }
            ));
        }

        $specialPreferenceArr = ['EXOFFICER', 'SPORTSPERSON', 'DISABLED'];
        $print = true;
        for($i=0; $i<sizeof($specialPreferenceArr); $i++) {
            $criteria = strtoupper($specialPreferenceArr[$i]);
            $code = Common::getCodeForSelectionCriteria($criteria);
            if(Common::codeAndSeedExistsInDB($code, $seedNumber)) {
                $template = $mustache->loadTemplate('print_button');
                echo $template->render();
                $template = $mustache->loadTemplate('print_header');
                echo $template->render(array('lang'=>$lang));
                $data = Common::getDataFromDbByCodeAndSeed($code, $seedNumber);
                $template = $mustache->loadTemplate('table_body');
                echo $template->render(array(
                    'data'=>$data, 
                    'lang'=>$lang,
                    'totalSeats'=>Common::getCandidateSelectionLimitForSpecialPreferences($criteria),
                    'totalParticipated'=>Common::getTotalEnteriesBySpecialPreferences($criteria),
                    'totalSelected'=>sizeof($data),
                    'selectionFor'=>$criteria,
                    'seedNumber'=>$seedNumber,
                    'errorMessage'=>Common::getErrorMessage('', sizeof($data)),
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
                selectCandidate($criteria, $code, $seedNumber, $mustache, $lang, $print);
                $print = false;
            }
        }
        mysqli_close($link);
    }
}
?>

<script type="text/javascript">
    function printpage() {
        var printButton = document.getElementById("printbtn"); 
        var content = document.getElementById("get-candidates");
        var printHeader = document.getElementById("print-header");
        printButton.style.display = 'none';
        content.style.display = 'none';
        printHeader.style.display = 'block';
        window.print();
        printButton.style.display = 'block';
        content.style.display = 'block';
        printHeader.style.display = 'none';
    }
</script>