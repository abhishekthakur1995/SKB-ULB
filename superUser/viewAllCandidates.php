<?php

session_start();
 
if($_SESSION['user_role'] == 'SUPERADMIN') {
	require_once('../config.php');
    require_once('../common/common.php');

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

$ulb = $gender = $category = $maritial_status = $ulb_err = '';
$candidate_type = 'all';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$trimUlb = trim($_POST['ulb']);
	if(empty($trimUlb)) {
		$ulb_err = 'Please select a ulb to proceed further';
	} else {
		$ulb = htmlspecialchars($trimUlb);
	}

	$trimGender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
	$gender = htmlspecialchars($trimGender);

	$trimCategory = isset($_POST['category']) ? trim($_POST['category']) : '';
	$category = htmlspecialchars($trimCategory);

	$trimMaritialStatus = isset($_POST['maritialStatus']) ? trim($_POST['maritialStatus']) : '';
	$maritial_status = htmlspecialchars($trimMaritialStatus);

	$trimCandidateType = isset($_POST['candidateType']) ? trim($_POST['candidateType']) : 'all';
	$candidate_type = htmlspecialchars($trimCandidateType);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Selected Candidates</title>
    </head>
    <body>
        <?php include '../header.php';?>
        <div class="wrapper margin-bottom-4x">
	        <form class="form-inline view-all-cand" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	            <div class="form-group full-width">
	            	<div class="full-width text-align-center margin-top-4x">
		                <select class="form-control ulb <?php echo (!empty($ulb_err)) ? 'is-invalid' : ''; ?>" name="ulb" required>
		                	<option value=""><?php echo $lang['ulb_region']; ?></option>
		                    <?php 
		                        $ulbListJson = file_get_contents(__DIR__ . '/../data/ulb_list.json');
		                        $ulbListArr = json_decode($ulbListJson, true);
		                        asort($ulbListArr);
		                        foreach($ulbListArr as $key => $value) {
		                            echo "<option value=".$value['CODE'].">".$value['NAME']."</option>"; 
		                        }
		                    ?>
		                </select>
		                <select class="form-control category" name="category">
		                	<option value=""><?php echo $lang['category']; ?></option>
		                    <?php 
		                        $categoryListJson = file_get_contents(__DIR__ . '/../data/category_list.json');
		                        $categoryListArr = json_decode($categoryListJson, true);
		                        foreach($categoryListArr as $key => $value) {
		                            echo "<option value=".$value['CODE'].">".$lang[$value['NAME']]."</option>";
		                        }
		                    ?>
		                </select>
		                <select class="form-control gender" name="gender">
		                	<option value=""><?php echo $lang['gender']; ?></option>
	                    	<option value="m"><?php echo $lang['male']; ?></option>
	                    	<option value="f"><?php echo $lang['female']; ?></option>
	                	</select>
	                	<select class="form-control maritial_status" name="maritialStatus">
	                		<option value=""><?php echo $lang['maritial_status']; ?></option>
                    		<?php 
		                        $maritialStatusJson = file_get_contents(__DIR__ . '/../data/maritial_status.json');
		                        $maritialStatusArr = json_decode($maritialStatusJson, true);
		                        foreach($maritialStatusArr as $key => $value) {
		                            echo "<option value=".$value['CODE'].">".$lang[$value['NAME']]."</option>"; 
		                        }
                    		?>
                		</select>
                		<select class="form-control candidate_type" name="candidateType">
	                		<option value="all"><?php echo $lang['candidate_type_all']; ?></option>
	                		<option value="selected"><?php echo $lang['candidate_type_selected']; ?></option>
	                		<option value="notSelected"><?php echo $lang['candidate_type_not_selected']; ?></option>
	                		<option value="rejected"><?php echo $lang['candidate_type_rejected']; ?></option>
	                		<option value="deleted"><?php echo $lang['candidate_type_deleted']; ?></option>
                		</select>
		                <input type="submit" class="btn btn-primary no-margin-top" value="<?php echo $lang['dashboard_btn_13'];?>">
		            </div>
	            </div>
	        </form>
	    </div> 
    </body>
</html>

<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($ulb_err)) {
			$data = Common::getCandidatesBasedOnSelectedCriteria($ulb, $gender, $category, $maritial_status, $candidate_type);
	        $template = $mustache->loadTemplate('all_candidates_list');
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
       }
	}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $(".ulb").val('<?php echo $ulb; ?>');
        $(".category").val('<?php echo $category; ?>');
        $(".gender").val('<?php echo $gender; ?>');
        $(".maritial_status").val('<?php echo $maritial_status; ?>');
        $(".candidate_type").val('<?php echo $candidate_type; ?>');
    });

    $('.download-btn').on('click', function() {
        var conf = confirm('<?php echo $lang['export_csv']; ?>');
        if(conf == true) {
            window.open("downloadData.php", '_blank');
        }
    });
</script>