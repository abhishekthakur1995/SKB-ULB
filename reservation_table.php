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

$insertToDB = false;
if($_GET && $_GET['insertToDB'] && $_GET['insertToDB'] == true) {
    $insertToDB = true;
}

if($insertToDB == true) {
    Common::createUlbEntryInReservationChartTable();
}

$totalSeatsInSeletedUlb = Common::getTotalSeatsForUlbByName($_SESSION['ulb_region']);
if($insertToDB == true) {
    Common::populateReservationChartTable('TOTAL_SEATS', $totalSeatsInSeletedUlb);
}

$totalSeatsForExOfficer = Common::getTotalSeatsForExofficer($totalSeatsInSeletedUlb);
$totalSeatsForDisabled = Common::getTotalSeatsForDisabled($totalSeatsInSeletedUlb);
$totalSeatsForSportsperson = Common::getTotalSeatsForSportsperson($totalSeatsInSeletedUlb);

$totalSeatsForSC = Common::getTotalSeatsByCategoryName('SC', $totalSeatsInSeletedUlb);
$totalSeatsForSCFemale = Common::getTotalSeatsByGender('F', $totalSeatsForSC);
$totalSeatsWidowSC = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForSC);
$totalSeatsDivorceeSC = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForSC);
$totalSeatsCommonSC = $totalSeatsForSCFemale - ($totalSeatsWidowSC+$totalSeatsDivorceeSC);
if($insertToDB == true) {
    Common::populateReservationChartTable('SC_FEMALE_WIDOW', $totalSeatsWidowSC);
    Common::populateReservationChartTable('SC_FEMALE_DIVORCEE', $totalSeatsDivorceeSC);
    Common::populateReservationChartTable('SC_FEMALE_COMMON', $totalSeatsCommonSC);
}

$totalSeatsForST = Common::getTotalSeatsByCategoryName('ST', $totalSeatsInSeletedUlb);
$totalSeatsForSTFemale = Common::getTotalSeatsByGender('F', $totalSeatsForST);
$totalSeatsWidowST = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForST);
$totalSeatsDivorceeST = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForST);
$totalSeatsCommonST = $totalSeatsForSTFemale - ($totalSeatsWidowST + $totalSeatsDivorceeST);
if($insertToDB == true) {
    Common::populateReservationChartTable('ST_FEMALE_WIDOW', $totalSeatsWidowST);
    Common::populateReservationChartTable('ST_FEMALE_DIVORCEE', $totalSeatsDivorceeST);
    Common::populateReservationChartTable('ST_FEMALE_COMMON', $totalSeatsCommonST);
}

$totalSeatsForOBC = Common::getTotalSeatsByCategoryName('OBC', $totalSeatsInSeletedUlb);
$totalSeatsForOBCFemale = Common::getTotalSeatsByGender('F', $totalSeatsForOBC);
$totalSeatsWidowOBC = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForOBC);
$totalSeatsDivorceeOBC = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForOBC);
$totalSeatsCommonOBC = $totalSeatsForOBCFemale - ($totalSeatsWidowOBC + $totalSeatsDivorceeOBC);
if($insertToDB == true) {
    Common::populateReservationChartTable('OBC_FEMALE_WIDOW', $totalSeatsWidowOBC);
    Common::populateReservationChartTable('OBC_FEMALE_DIVORCEE', $totalSeatsDivorceeOBC);
    Common::populateReservationChartTable('OBC_FEMALE_COMMON', $totalSeatsCommonOBC);
}

$totalSeatsForSPECIALOBC = Common::getTotalSeatsByCategoryName('SPECIALOBC', $totalSeatsInSeletedUlb);
$totalSeatsForSPECIALOBCFemale = Common::getTotalSeatsByGender('F', $totalSeatsForSPECIALOBC);
$totalSeatsWidowSPECIALOBC = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForSPECIALOBC);
$totalSeatsDivorceeSPECIALOBC = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForSPECIALOBC);
$totalSeatsCommonSPECIALOBC = $totalSeatsForSPECIALOBCFemale - ($totalSeatsWidowSPECIALOBC + $totalSeatsDivorceeSPECIALOBC);
if($insertToDB == true) {
    Common::populateReservationChartTable('SPECIALOBC_FEMALE_WIDOW', $totalSeatsWidowSPECIALOBC);
    Common::populateReservationChartTable('SPECIALOBC_FEMALE_DIVORCEE', $totalSeatsDivorceeSPECIALOBC);
    Common::populateReservationChartTable('SPECIALOBC_FEMALE_COMMON', $totalSeatsCommonSPECIALOBC);
}

$totalSeatsForGENERAL = $totalSeatsInSeletedUlb - ($totalSeatsForSC + $totalSeatsForST + $totalSeatsForOBC + $totalSeatsForSPECIALOBC);
$totalSeatsForGENERALFemale = Common::getTotalSeatsByGender('F', $totalSeatsForGENERAL);
$totalSeatsWidowGENERAL = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForGENERAL);
$totalSeatsDivorceeGENERAL = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForGENERAL);
$totalSeatsCommonGENERAL = $totalSeatsForGENERALFemale - ($totalSeatsWidowGENERAL + $totalSeatsDivorceeGENERAL);
if($insertToDB == true) {
    Common::populateReservationChartTable('TOTAL_GENERAL', $totalSeatsForGENERAL);
    Common::populateReservationChartTable('GENERAL_FEMALE_WIDOW', $totalSeatsWidowGENERAL);
    Common::populateReservationChartTable('GENERAL_FEMALE_DIVORCEE', $totalSeatsDivorceeGENERAL);
    Common::populateReservationChartTable('GENERAL_FEMALE_COMMON', $totalSeatsCommonGENERAL);
}

$totalMaleSCSeats = $totalSeatsForSC - ($totalSeatsForSCFemale);
$totalMaleSTSeats = $totalSeatsForST - ($totalSeatsForSTFemale);
$totalMaleOBCSeats = $totalSeatsForOBC - ($totalSeatsForOBCFemale);
$totalMaleSPECIALOBCSeats = $totalSeatsForSPECIALOBC - ($totalSeatsForSPECIALOBCFemale);
$totalMaleGENERALSeats = $totalSeatsForGENERAL - ($totalSeatsForGENERALFemale);
if($insertToDB == true) {
    Common::populateReservationChartTable('SC_MALE', $totalMaleSCSeats);
    Common::populateReservationChartTable('ST_MALE', $totalMaleSTSeats);
    Common::populateReservationChartTable('OBC_MALE', $totalMaleOBCSeats);
    Common::populateReservationChartTable('SPECIALOBC_MALE', $totalMaleSPECIALOBCSeats);
    Common::populateReservationChartTable('GENERAL_MALE', $totalMaleGENERALSeats);
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="table-container fleft full-width">
        <table class="ulb-table">
            <thead>
                <tr class="text-align-center"><td colspan="6" class="fs6"><?php echo $lang['tbl1_heading']; ?></td></tr>
                <tr>
                    <th> <?php echo  $lang['totalseat']; ?>: <?php echo common::getTotalSeatsForUlbByName($_SESSION['ulb_region']); ?></th>
                    <th><?php echo  $lang['tbl2_heading_1']; ?></th>
                    <th><?php echo  $lang['tbl2_heading_2']; ?></th>
                    <th><?php echo  $lang['tbl2_heading_3']; ?></th>
                    <th><?php echo  $lang['tbl2_heading_4']; ?></th>
                    <th><?php echo  $lang['totalseat'];  ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $lang['SC']?></td>
                    <td><?php echo $totalSeatsWidowSC; ?></td>
                    <td><?php echo $totalSeatsDivorceeSC; ?></td>
                    <td><?php echo $totalSeatsCommonSC; ?></td>
                    <td><?php echo $totalMaleSCSeats; ?></td>
                    <td><?php echo $totalSeatsForSC; ?></td>
                </tr>
                <tr>
                    <td><?php echo $lang['ST']?></td>
                    <td><?php echo $totalSeatsWidowST; ?></td>
                    <td><?php echo $totalSeatsDivorceeST; ?></td>
                    <td><?php echo $totalSeatsCommonST; ?></td>
                    <td><?php echo $totalMaleSTSeats; ?></td>
                    <td><?php echo $totalSeatsForST; ?></td>
                </tr>
                <tr>
                    <td><?php echo $lang['OBC']?></td>
                    <td><?php echo $totalSeatsWidowOBC; ?></td>
                    <td><?php echo $totalSeatsDivorceeOBC; ?></td>
                    <td><?php echo $totalSeatsCommonOBC; ?></td>
                    <td><?php echo $totalMaleOBCSeats; ?></td>
                    <td><?php echo $totalSeatsForOBC; ?></td>
                </tr>
                <tr>
                    <td><?php echo $lang['Special OBC']?></td>
                    <td><?php echo $totalSeatsWidowSPECIALOBC; ?></td>
                    <td><?php echo $totalSeatsDivorceeSPECIALOBC; ?></td>
                    <td><?php echo $totalSeatsCommonSPECIALOBC; ?></td>
                    <td><?php echo $totalMaleSPECIALOBCSeats; ?></td>
                    <td><?php echo $totalSeatsForSPECIALOBC; ?></td>
                </tr>
                <tr>
                    <td><?php echo $lang['General']?></td>
                    <td><?php echo $totalSeatsWidowGENERAL; ?></td>
                    <td><?php echo $totalSeatsDivorceeGENERAL; ?></td>
                    <td><?php echo $totalSeatsCommonGENERAL; ?></td>
                    <td><?php echo $totalMaleGENERALSeats; ?></td>
                    <td><?php echo $totalSeatsForGENERAL; ?></td>
                </tr>
                <tr>
                    <td><?php echo $lang['totalseat']?></td>
                    <td><?php echo $totalSeatsWidowSC+$totalSeatsWidowST+$totalSeatsWidowOBC+$totalSeatsWidowGENERAL+$totalSeatsWidowSPECIALOBC; ?> </td>
                    <td><?php echo $totalSeatsDivorceeSC+$totalSeatsDivorceeST+$totalSeatsDivorceeOBC+$totalSeatsDivorceeGENERAL+$totalSeatsDivorceeSPECIALOBC; ?></td>
                    <td><?php echo $totalSeatsCommonSC+$totalSeatsCommonST+$totalSeatsCommonOBC+$totalSeatsCommonGENERAL+$totalSeatsCommonSPECIALOBC; ?></td>
                    <td><?php echo $totalMaleSCSeats+$totalMaleSTSeats+$totalMaleOBCSeats+$totalMaleGENERALSeats+$totalMaleSPECIALOBCSeats; ?></td>
                    <td><?php echo $totalSeatsInSeletedUlb; ?>/<?php echo $totalSeatsInSeletedUlb; ?></td>
                </tr>
            </tbody>
        </table>

        <table class="ulb-table">
    
            <thead>
                <tr>
                    <th><?php echo $lang['EXOFFICER'];?></th>
                    <th><?php echo $lang['DISABLED'];?></th>
                    <th><?php echo $lang['SPORTSPERSON'];?></th>
                    <th><?php echo  $lang['totalseat'];  ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-align-center"><?php echo $totalSeatsForExOfficer; ?></td>
                    <td class="text-align-center"><?php echo $totalSeatsForDisabled; ?></td>
                    <td class="text-align-center"><?php echo $totalSeatsForSportsperson; ?></td>
                    <td class="text-align-center"><?php echo $totalSeatsForExOfficer + $totalSeatsForDisabled + $totalSeatsForSportsperson; ?></td>
                </tr>
            </tbody>
        </table>

    </div>
</body>
</html>