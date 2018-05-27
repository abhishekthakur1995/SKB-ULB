<?php
session_start();

require('config.php');
require('languages/hi/lang.hi.php');

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
    <title><?php echo $lang['candidates_details_heading']; ?></title>
    <style type="text/css">
        table tr td:last-child a{
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <?php include 'header.php';?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix margin-bottom-4x">
                        <h2 class="pull-left padding-top-4x"><?php echo $lang['candidates_details_heading']; ?></h2>
                        <a href="candidate_details.php" class="btn btn-success pull-right fs4">
                            <span class="fa fa-plus-square fs4"></span>
                            <?php echo $lang['add_new_candidate_btn']; ?>
                        </a>
                    </div>
                    <?php
                    // Attempt select query execution
                    $sql = "SELECT * FROM candidate_list WHERE ulbRegion = '".trim($_SESSION['ulb_region'])."' ORDER BY created_at DESC";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>".$lang['name']."</th>";
                                        echo "<th>".$lang['guardian']."</th>";
                                        echo "<th>".$lang['dob']."</th>";
                                        echo "<th>".$lang['permanentAddress']."</th>";
                                        echo "<th>".$lang['district']."</th>";
                                        echo "<th>".$lang['birth_place']."</th>";
                                        echo "<th>".$lang['phone_number']."</th>";
                                        echo "<th>".$lang['gender']."</th>";
                                        echo "<th>".$lang['maritial_status']."</th>";
                                        echo "<th>".$lang['category']."</th>";
                                        echo "<th>".$lang['ulb_region']."</th>";
                                        echo "<th>".$lang['receipt_number']."</th>";
                                        echo "<th>".$lang['action']."</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                $i=0;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . ++$i . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['guardian'] . "</td>";
                                        echo "<td>" . $row['dob'] . "</td>";
                                        echo "<td>" . $row['permanentAddress'] . "</td>";
                                        echo "<td>" . $row['district'] . "</td>";
                                        echo "<td>" . $row['birthPlace'] . "</td>";
                                        echo "<td>" . $row['phoneNumber'] . "</td>";
                                        $fullGender = $row['gender'] == 'm' ? 'male' : 'female';
                                        echo "<td>" . $lang[$fullGender] . "</td>";
                                        echo "<td>" . $lang[ucwords(strtolower($row['maritialStatus']))] . "</td>";
                                        echo "<td>" . $lang[$row['category']] . "</td>";
                                        echo "<td>" . $row['ulbRegion'] . "</td>";
                                        echo "<td>" . explode('_', $row['receiptNumber'])[1] . "</td>";
                                        echo "<td>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='".$lang['update_record']."' data-toggle='tooltip'><span class='fa fa-pencil-square-o clr-green'></span></a>";
                                            echo "<a data-id=". $row['id'] ." title='".$lang['delete_record']."' data-toggle='tooltip'><span data-id=". $row['id'] ." class='fa fa-trash clr-red'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>

    <button type="button" class="btn btn-info btn-lg display-none first-modal" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close margin-left-none" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo $lang['delete_alert']; ?></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default delete-data" data-dismiss="modal"><?php echo $lang['yes']?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['no']?></button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-info btn-lg display-none second-modal" data-toggle="modal" data-target="#myModalSmall">Open Small Modal</button>
    <div class="modal fade" id="myModalSmall" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close margin-left-none" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body fs20">
                    <p><?php echo $lang['delete_alert1']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="window.location.reload()"><?php echo $lang['delete_alert2']; ?></button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<script type="text/javascript">
$(document).ready(function(){
    var id = '';
    $('[data-toggle="tooltip"]').tooltip();
    $('.fa-trash').on('click', function() {
        id = $('.fa-trash').data('id');
        $('.first-modal').trigger('click');
    });

    $('.delete-data').on('click', function() {
        $.ajax({
            type: 'POST',
            url: 'delete.php',
            data: {id : id},
            success: function(data) {
                data = JSON.parse(data);
                if(data.response == 'SUCCESS') {
                    $('.second-modal').trigger('click');
                }
                if(data.response == 'FAILURE') {
                    $('.second-modal').trigger('click');
                } 
            }
        });
    });
});
</script>