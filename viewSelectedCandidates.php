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
                            <h2 class="pull-left padding-top-4x">Duplicate Record</h2>
                            <button onclick="Export()" class="btn btn-success pull-right fs4">
                                <span class="fa fa-download fs4"></span>
                                    Export to CSV File
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
    function Export() {
        var conf = confirm("Export data to CSV?");
        if(conf == true) {
            window.open("export.php?view=duplicateRecord", '_blank');
        }
    }
</script>