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

$ulb = $searchFrom = $ulb_err = $search_from_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$trimUlb = trim($_POST['ulb']);
	if(empty($trimUlb)) {
		$ulb_err = 'Please select a ulb to proceed further';
	} else {
		$ulb = htmlspecialchars($trimUlb);
	}

	$trimSearchFrom = trim($_POST['searchFrom']);
	if(empty($trimSearchFrom)) {
		$ulb_err = 'Please select a criteria';
	} else {
		$searchFrom = htmlspecialchars($trimSearchFrom);
	}
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
        <div class="wrapper">
	        <form class="form-inline" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	            <div class="form-group full-width">
	            	<div class="full-width text-align-center margin-top-4x">

                        <select class="form-control searchFrom <?php echo (!empty($search_from_err)) ? 'is-invalid' : ''; ?>" name="searchFrom" required>
                            <option value="">Search From</option>
                            <option value="selected">Selected Candidates</option>
                            <option value="all">All Candidates</option>
                        </select>
		                <select class="form-control ulb margin-horiz-2x <?php echo (!empty($ulb_err)) ? 'is-invalid' : ''; ?>" name="ulb" required>
		                	<option value="">Select ULB</option>
		                    <?php 
		                        $ulbListJson = file_get_contents(__DIR__ . '/../data/ulb_list.json');
		                        $ulbListArr = json_decode($ulbListJson, true);
		                        asort($ulbListArr);
		                        foreach($ulbListArr as $key => $value) {
		                            echo "<option value=".$value['CODE'].">".$value['NAME']."</option>"; 
		                        }
		                    ?>
		                </select>
		                <input type="submit" class="btn btn-primary no-margin-top" value="Get Candidates">
		            </div>
	            </div>
	        </form>
	    </div> 
    </body>
</html>

<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($ulb_err) && empty($search_from_err)) {
			$data = Common::getCandidatesByUlb($searchFrom, $ulb);
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
       }
	}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $(".ulb").val('<?php echo $ulb; ?>');
        $(".searchFrom").val('<?php echo $searchFrom; ?>');
    });
</script>