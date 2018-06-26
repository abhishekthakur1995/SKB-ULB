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

$category = $gender = $maritialStatus = $seedNumber = "";
$gender_err = $category_err = $maritial_status_err = $seed_number_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try {
        $easyCSRF->check('my_token', $_POST['token']);
    }
    catch(Exception $e) {
        die($e->getMessage());
    }

    $maritialStatus = isset($_POST['maritialStatus']) ? htmlspecialchars(trim($_POST['maritialStatus'])) : '';

    $trimGender = trim($_POST["gender"]); 
    if(empty($trimGender)) {
        $gender_err = "Please select a gender.";
    } else {
        $gender = htmlspecialchars($trimGender);
    }

    $trimCategory = trim($_POST["category"]); 
    if(empty($trimCategory)) {
        $category_err = "Please select a category.";
    } else {
        $category = htmlspecialchars($trimCategory);
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
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['select_candidates']; ?></title>
</head>
<body>
    <?php include 'header.php';?>
    <?php include 'lottery_information.php';?>
    <div id="get-all-candidates" class="get_candidates_wrapper">
        <div class="modal fade" id="lotteryTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $lang['lottery_msg_6']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="classTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <td class="text-align-center half-width"><?php echo $lang['seed_number']; ?></td>
                                    <td class="text-align-center half-width"><?php echo $lang['lottery_table_criteria']; ?></td>
                                </tr>
                            </thead>
                            <?php
                                $usedCodes = Common::getSelectedCodeByUlb();
                                foreach ($usedCodes as $key => $value) {
                                ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-align-center"><?php echo $value['seedNumber']; ?></td>
                                            <td class="text-align-center"><?php echo $lang[array_search($value['code'], Common::codes)]; ?></td>
                                        </tr>
                                    </tbody>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="pure-button" data-dismiss="modal"><?php echo $lang['delete_alert2']; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col alert alert-info margin-5x text-align-center">
                <a data-toggle="modal" data-target="#lotteryTable" class="fs4"><?php echo $lang['lottery_msg_5'];?>
                    <span class="fa fa-arrow-right fs4"></span>
                </a>
            </div>
            <div class="col alert alert-info margin-5x text-align-center">
                <a data-toggle="modal" data-target="#lotteryInformation" class="fs4"><?php echo $lang['lottery_msg_1'];?>
                    <strong class="text-decoration-underline clr-blue"><?php echo $lang['lottery_msg_2'];?></strong>
                </a>
            </div>
            <div class="col alert alert-info margin-5x text-align-center">
                <a class="fs4" href="getSpecialPrefCandidates.php"><?php echo $lang['lottery_msg_8']; ?></a> 
                </a>
            </div>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="token" value="<?php echo $easyCSRF->generate('my_token'); ?>">
            <div class="container no-margin">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="seedNumber" class="required"><?php echo $lang['seed_number']; ?></label>
                            <input type="text" autocomplete="off" name="seedNumber" maxlength="4" class="seed-number form-control <?php echo(!empty($seed_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $seedNumber; ?>" pattern="\d{4}" required/>
                            <span class="invalid-feedback text-align-center"><?php echo $seed_number_err; ?></span>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                            <label for="category" class="required"><?php echo $lang['category']; ?></label>
                            <select class="form-control category" name="category" required>
                                <option value=""><?php echo $lang['select_option']; ?></option>
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
                            <span class="invalid-feedback text-align-center"><?php echo $category_err; ?></span>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                            <label class="required"><?php echo $lang['gender']; ?></label>
                            <select class="form-control gender" name="gender" required>
                                <option value=""><?php echo $lang['select_option']; ?></option>
                                <option value="f"><?php echo $lang['female']; ?></option>
                                <option value="m"><?php echo $lang['male']; ?></option>
                            </select>
                            <span class="invalid-feedback text-align-center"><?php echo $gender_err; ?></span>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="maritialStatus" class="required"><?php echo $lang['maritial_status']; ?></label>
                            <select class="form-control maritial_status" name="maritialStatus" required>
                                <option value=""><?php echo $lang['select_option']; ?></option>
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
                <input type="submit" class="btn btn-primary" value="<?php echo $lang['select_candidates']; ?>">
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
            $limit = Common::getCandidateSelectionLimit($criteria);
            $data = Common::getDataFromDbByCodeAndSeed($code, $seedNumber);
            $template = $mustache->loadTemplate('print_button');
            echo $template->render();
            $template = $mustache->loadTemplate('print_header');
            echo $template->render(array('lang'=>$lang));
            $template = $mustache->loadTemplate('table_body_1');
            echo $template->render(array(
                'data'=>$data, 
                'lang'=>$lang,
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
        } else {
            if(Common::existsInDB($code, 'code')) {
                Common::showAlert($lang['candidate_already_selected']);
            } else if(Common::existsInDB($seedNumber, 'seedNumber')) {
                Common::showAlert($lang['seed_already_used']);
            } else {
                $limit = Common::getCandidateSelectionLimit($criteria);
                $data = Common::selectCandidatesForOthersCategory($criteria, $limit, $code, $seedNumber);
                if(!in_array($criteria, Common::discardSeatsCriteria)) {
                    $carriedForwardSeats = $limit - sizeof($data);
                    if($carriedForwardSeats > 0) {
                        Common::carryForwardSeats($carriedForwardSeats, $criteria);
                    }
                }
                $template = $mustache->loadTemplate('print_button');
                echo $template->render();
                $template = $mustache->loadTemplate('print_header');
                echo $template->render(array('lang'=>$lang));
                $template = $mustache->loadTemplate('table_body_1');
                echo $template->render(array(
                    'data'=>$data, 
                    'lang'=>$lang,
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
        }
        mysqli_close($link);
    }
}
?>

<script type="text/javascript">
    $(document).ready(function() {

        $(".maritial_status").val('<?php echo $maritialStatus; ?>');
        $(".category").val('<?php echo $category; ?>');
        $(".gender").val('<?php echo $gender; ?>');

        if($('.gender').val() === 'm') {
            $('.maritial_status').attr('disabled', true);
        }

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

    function printpage() {
        var printButton = document.getElementById("printbtn"); 
        var content = document.getElementById("get-all-candidates");
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