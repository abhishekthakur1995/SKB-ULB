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

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $lang['selected_candidates']; ?></title>
    </head>
    <body>
        <?php include 'header.php';?>
        <div class="wrapper">
        	<div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix margin-bottom-4x">
                            <h2 class="pull-left padding-top-4x"><?php echo $lang['selected_candidates']; ?></h2>
                            <button onclick="download()" class="btn btn-success pull-right fs4">
                                <span class="fa fa-download fs4"></span>
                                    <?php echo $lang['print_letter']; ?>
                            </button>
                        </div>
                        <?php
                            $data = Common::getSelectedCandidates();
                            $template = $mustache->loadTemplate('selected_candidates');
                            echo $template->render(array(
                                'data'=>$data, 
                                'lang'=>$lang,
                                'getReceiptNumber' => function($text, Mustache_LambdaHelper $helper) {
                                    return substr($helper->render($text), strpos($helper->render($text), "_") + 1);
                                },
                                'getTextInHindi' => function($text, Mustache_LambdaHelper $helper) {
                                    return Common::getTextInHindi(trim($helper->render($text)));
                                },
                                'getFormStatus' => function($text, Mustache_LambdaHelper $helper) {
                                    return Common::getFormStatusInHindi(trim($helper->render($text)));
                                }
                            ));
                        ?>
                    </div>
                </div>        
            </div>
    	</div>
    </body>
</html>

<script>
    function download() {
        var conf = confirm('<?php echo $lang['print_letter']; ?>?');
        if(conf == true) {
            window.open("downloadAppointmentLetter.php", '_blank');
        }
    }
</script>
