<?php
// Initialize the session
session_start();

require('config.php');
require('languages/hi/lang.hi.php');
//require('common/common.php');

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

// Define variables and initialize with empty values
$gender = $category = $maritialStatus = $seedNumber = "";
$gender_err = $category_err = $maritial_status_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate malecount
    $trimGender = trim($_POST["gender"]); 
    if(empty($trimGender)) {
        $gender_err = "Please select a gender.";
    } else {
        $gender = trim($_POST['gender']);
    }

    // Validate femalecount
    $trimCategory = trim($_POST["category"]); 
    if(empty($trimCategory)) {
        $category_err = "Please select a category.";
    } else {
        $category = trim($_POST['category']);
    }

    // Validate femalecount
    $trimMaritialStatus = $_POST["maritialStatus"];
    if(empty($trimMaritialStatus)){
        //$maritial_status_err = "Please select a maritial status.";
    } else {
        $maritialStatus = trim($_POST['maritialStatus']);
    }

    $seedNumber = $_POST['seedNumber'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Get Candidates</title>
    <style type="text/css">
        /*body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin: auto;}*/
    </style>
</head>
<body>
    <?php include 'header.php';?>
    <div class="get_candidates_wrapper">
        <div class="form-detail">
            <h2>Get Candidates</h2>
            <p>Select the criteria to select a candidate</p>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
             <div class="form-group-new">
                <label><?php echo $lang['seed_number']; ?></label>
                <input type="text" name="seedNumber" class="form-control" value="<?php echo $seedNumber; ?>" required>
            </div>
            <div class="form-group-new <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                <label for="category">Select Category</label>
                <select class="form-control" name="category">
                    <option value="">SELECT</option>
                    <?php 
                        $categoryListJson = file_get_contents(__DIR__ . '/data/category_list.json');
                        $categoryListArr = json_decode($categoryListJson, true);
                        foreach($categoryListArr as $key => $value) {
                            echo "<option value=".$value['CODE'].">".$value['NAME']."</option>"; 
                        }
                    ?>
                </select>
                <span class="help-block"><?php echo $category_err; ?></span>
            </div>    
            <div class="form-group-new <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                <label>Select Gender</label>
                <select class="form-control gender" name="gender">
                    <option value="">SELECT</option>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                </select>
                <span class="help-block"><?php echo $gender_err; ?></span>
            </div>
            <div class="form-group-new maritial_status_select hide">
                <label for="maritialStatus">Maritial Status</label>
                <select class="form-control" name="maritialStatus" class="maritialStatus">
                    <option value="">SELECT</option>
                    <?php 
                        $maritialStatusJson = file_get_contents(__DIR__ . '/data/maritial_status.json');
                        $maritialStatusArr = json_decode($maritialStatusJson, true);
                        foreach($maritialStatusArr as $key => $value) {
                            echo "<option class=".$value['NAME']." value=".$value['CODE'].">".$value['NAME']."</option>"; 
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Get Candidate List">
            </div>
        </form>
    </div>    
</body>
</html>


<?php
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate credentials
    if(empty($gender_err) && empty($category_err)){
        // Prepare a select statement

        //set criterias
        $totalSeatsInSeletedUlb = Common::getTotalSeatsForUlbByName($_SESSION['ulb_region']); //100

        $totalSeatsForSelectedCategory = Common::getTotalSeatsByCategoryName($_POST['category'], $totalSeatsInSeletedUlb); 

        $totalSeatsForSelectedGender = Common::getTotalSeatsByGender($_POST['gender'], $totalSeatsForSelectedCategory);
        $limit = $totalSeatsForSelectedGender;

        if($_POST['gender'] === 'f') {
            $totalSeatsWithMaritialStatus = Common::getTotalSeatsByMaritialStatus($_POST['maritialStatus'], $totalSeatsForSelectedCategory);
            $limit = $totalSeatsWithMaritialStatus;
        }

        $sql = "SELECT * FROM candidate_list WHERE gender = '".$_POST['gender']."' AND STATUS = 0 AND ulbRegion = '".$_SESSION['ulb_region']."' AND category = '".$_POST['category']."' ORDER BY RAND()  LIMIT ".$limit;
        
        if ($res = mysqli_query($link, $sql)) {
            echo "<h3>Candidates List</h3>";
            echo "<table class='table table-striped table-hover table-condensed'>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Guardian</th>";
            echo "<th>Address</th>";
            echo "<th>Gender</th>";
            echo "<th>DOB</th>";
            echo "<th>Category</th>";
            echo "</tr>";
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['guardian']."</td>";
                    echo "<td>".$row['address']."</td>";
                    $fullGender = $row['gender'] == 'm' ? 'Male' : 'Female';
                    echo "<td>".$fullGender."</td>";
                    echo "<td>".$row['dob']."</td>";
                    echo "<td>".$row['category']."</td>";
                    echo "</tr>";

                    $sql = "UPDATE candidate_list SET status= 1, seedNumber = '".$_POST['seedNumber']."' WHERE id= ".$row['id']."";

                    if (mysqli_query($link, $sql)) {
                        //echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . mysqli_error($link);
                    }  
                }
            } else {
                echo "<tr>";
                    echo "<td>No Record Found</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    } 

    // Close connection
    mysqli_close($link);
}

?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.maritial_status_select').hide();
        $('.gender').change(function() {
            if($('.gender').val() !== '') {
                $('.maritial_status_select').removeClass('hide');
                if($('.gender').val() === 'f') {
                    $('.maritial_status_select').show();
                } else {
                    $('.maritial_status_select').hide();
                } 
            } else {
                $('.maritial_status_select').addClass('hide');
            }
        });
    });  
</script>