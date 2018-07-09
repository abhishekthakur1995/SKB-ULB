<?php
session_start();

require('config.php');
require('languages/hi/lang.hi.php');
require('common/common.php');

if(!in_array($_SESSION['ulb_region'], Common::TEMP_ALLOWED)) {
    header("location: error.php");
    die();
}

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

if (isset($_SESSION['message'])) {
    $msg = $_SESSION['message'];
    echo '<script language="javascript">';
    echo "alert('$msg')";
    echo '</script>';
    unset($_SESSION['message']);
}


if($_GET && isset($_GET['page'])) {
    $page = htmlspecialchars($_GET['page'], ENT_QUOTES);
} else {
    $page = 1;
}

if($_GET && isset($_GET['userFormValid']) && is_numeric($_GET['userFormValid'])) {
    $formValid = htmlspecialchars($_GET['userFormValid']);
} else {
    $formValid = '';
}

$items = 500;
$offset = ($page * $items) - $items;
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

                        <div class="fright">
                            <div id="search-box" class="search-box">
                                <div class="lds-ellipsis loading hide"><div></div><div></div><div></div><div></div></div>
                                <input type="text" style="padding-left: 40px;" autocomplete="off" placeholder="<?php echo $lang['search_candidates']; ?>" />
                                <i class="fa fa-search input-search-icon" aria-hidden="true"></i>
                                <div class="result"></div>
                            </div>

                            <button class="pure-button download-btn">
                                <i class="fa fa-download fs4"></i>
                                <span><?php echo $lang['download']; ?></span>
                            </button>

                            <button class="pure-button settings-btn">
                                <i class="fa fa-cog fs4"></i>
                                <span><?php echo $lang['settings']; ?></span>
                            </button>
                        </div>

                    </div>
                    <?php
                    if($formValid != '') {
                        $query = "AND userFormValid = ".$formValid."";
                    } else {
                        $query = '';
                    }

                    $sql = "SELECT * FROM candidate_list WHERE status = 0 AND ulbRegion = '".trim($_SESSION['ulb_region'])."' ".$query." ORDER BY created_at DESC LIMIT ".$items." OFFSET ".$offset."";

                    if($result = mysqli_query($link, $sql)){
                        $count = mysqli_num_rows($result);
                        if($count > 0){
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
                                        echo "<th>".$lang['all_documents_provided']."</th>";
                                        echo "<th>".$lang['action']."</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    $fullGender = $row['gender'] == 'm' ? 'male' : 'female';
                                    echo "<tr>";
                                        echo "<td>" . ++$offset . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['guardian'] . "</td>";
                                        echo "<td>" . $row['dob'] . "</td>";
                                        echo "<td>" . $row['permanentAddress'] . "</td>";
                                        echo "<td>" . $row['district'] . "</td>";
                                        echo "<td>" . $row['birthPlace'] . "</td>";
                                        echo "<td>" . $row['phoneNumber'] . "</td>";
                                        echo "<td>" . $lang[$fullGender] . "</td>";
                                        echo "<td>" . $lang[ucwords(strtolower($row['maritialStatus']))] . "</td>";
                                        echo "<td>" . $lang[$row['category']] . "</td>";
                                        echo "<td>" . $row['ulbRegion'] . "</td>";
                                        echo "<td>" . substr($row['receiptNumber'], strpos($row['receiptNumber'], "_") + 1) . "</td>";
                                        echo "<td>" . $lang['form_status_'.$row['userFormValid']] . "</td>";
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
            <ul class="pagination pagination-lg fright">
                <?php
                    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    $parts = parse_url($url);
                    $param = '';
                    if($parts && isset($parts['query'])) {
                        parse_str($parts['query'], $query);
                        if($query && isset($query['userFormValid'])) {
                            $param = 'userFormValid='.$query['userFormValid'].'&';
                        }
                    }
                ?>

                <?php if ($page != 1) { ?>        
                    <li class="page-item">
                        <a class="page-link" href="candidates_details.php?<?php echo $param; ?>page=<?php echo $page - 1; ?>">&laquo;</a>
                    </li>

                    <li class="page-item"><a class="page-link" href="candidates_details.php?<?php echo $param; ?>page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?></a></li>
                <?php } ?>

                <li class="page-item active"><a class="page-link" href="candidates_details.php?<?php echo $param; ?>page=<?php echo $page; ?>"><?php echo $page; ?></a></li>

                <?php if ($count == $items) { ?>
                    <li class="page-item"><a class="page-link" href="candidates_details.php?<?php echo $param; ?>page=<?php echo $page + 1 ; ?>"><?php echo $page + 1; ?></a></li>

                    <li class="page-item"><a class="page-link" href="candidates_details.php?<?php echo $param; ?>page=<?php echo $page + 1; ?>">&raquo;</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <button type="button" class="btn btn-info btn-lg display-none first-modal" data-toggle="modal" data-target="#myModal"></button>
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

    <button type="button" class="btn btn-info btn-lg display-none second-modal" data-toggle="modal" data-target="#myModalSmall"></button>
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

    <button type="button" class="btn btn-primary display-none filter-modal" data-toggle="modal" data-target="#filterModal"></button>
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $lang['apply_filter']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo $lang['all_documents_provided']; ?></label>                  
                        <label>                  
                            <input type="radio" class="margin-horiz-2x" name="userFormValid" value="1" checked><?php echo $lang['yes']; ?>
                        </label>
                        <label> 
                            <input type="radio" class="margin-horiz-2x" name="userFormValid" value="0"><?php echo $lang['no']; ?>
                        </label>
                        <label> 
                            <input type="radio" class="margin-horiz-2x" name="userFormValid" value="2"><?php echo $lang['under_scrutiny']; ?>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $lang['close']; ?></button>
                    <button type="button" class="btn btn-primary apply-filter-btn"><?php echo $lang['apply_filter_submit']; ?></button>
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
        id = $(this).data('id');
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

    $('.search-box input[type="text"]').on("keyup", function(){
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $('.loading').removeClass('hide');
            $.get("backend_search.php", {term: inputVal}).done(function(data){
                resultDropdown.html(data);
                $('.loading').addClass('hide');
            });
        } else {
            resultDropdown.empty();
        }
    });
    
    $("body").click(function(e) {
        if (e.target.id != "search-box" || !($(e.target).parents("#search-box").length)) {
            $('.result').empty();
        }
    });

    $('.settings-btn').click(function(e) {
        $('.filter-modal').trigger('click');
    });

    $('.apply-filter-btn').on('click', function() {
        var param = $('input:radio[name="userFormValid"]:checked').val();
        var url = window.location.href.split('?')[0];
        url += '?userFormValid='+param+'&page=1';
        window.location.href = url;
    });

    $('.download-btn').on('click', function() {
        var conf = confirm('<?php echo $lang['export_csv']; ?>');
        if(conf == true) {
            window.open("exportUlbData.php", '_blank');
        }
    });

});
</script>
