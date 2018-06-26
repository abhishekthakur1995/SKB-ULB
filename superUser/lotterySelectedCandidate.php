<?php

session_start();
 
if($_SESSION['user_role'] == 'SUPERADMIN') {
	require('../config.php');
    require('../common/common.php');

	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	    header("location: ../index.php");
	    exit;
	} else {
	    if (time()-$_SESSION['timestamp'] > IDLE_TIME) {
	        header("location: ../logout.php");
	    }   else{
	        $_SESSION['timestamp']=time();
	    }
	}
} else {
	header("location: ../error.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enteries by ULB</title>
    <style type="text/css">
        table tr td:last-child a{
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <?php include '../header.php';?>

    <div class="modal fade" id="detailedLotteryTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered max-width-1200" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Detailed List</h2>      
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="pure-button" data-dismiss="modal"><?php echo $lang['delete_alert2']; ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
    	<div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix margin-bottom-4x">
                        <h2 class="pull-left padding-top-4x">Lottery Selection</h2>
                    </div>
                    <?php
                        $data = Common::getSelectedCandidateByGenderAndMaritialStatus();
                        $template = $mustache->loadTemplate('lottery_selected');
                        echo $template->render(array('data'=>$data));
                    ?>
                </div>
            </div>       
        </div>
	</div>
</body>
</html>

<script>
$(document).ready(function() {
    $('.city-link').click(function() {
        $.ajax({
            type: 'POST',
            url: 'detailedLottery.php',
            data: {city: $(this).data('city')},
            success: function(data) {
                $('.modal-body').html(data);
                $('#detailedLotteryTable').modal()
            }
        });
    });
});
</script>