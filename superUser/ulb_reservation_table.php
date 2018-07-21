<?php

$totalSeatsInSeletedUlb = Common::getTotalSeatsForUlbByName($_SESSION['ulb_region']);

$totalSeatsForExOfficer = Common::getTotalSeatsForExofficer($totalSeatsInSeletedUlb);
$totalSeatsForDisabled = Common::getTotalSeatsForDisabled($totalSeatsInSeletedUlb);
$totalSeatsForSportsperson = Common::getTotalSeatsForSportsperson($totalSeatsInSeletedUlb);

$totalSeatsForSC = Common::getTotalSeatsByCategoryName('SC', $totalSeatsInSeletedUlb);
$totalSeatsForSCFemale = Common::getTotalSeatsByGender('F', $totalSeatsForSC);
$totalSeatsWidowSC = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForSC);
$totalSeatsDivorceeSC = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForSC);
$totalSeatsCommonSC = $totalSeatsForSCFemale - ($totalSeatsWidowSC+$totalSeatsDivorceeSC);

$totalSeatsForST = Common::getTotalSeatsByCategoryName('ST', $totalSeatsInSeletedUlb);
$totalSeatsForSTFemale = Common::getTotalSeatsByGender('F', $totalSeatsForST);
$totalSeatsWidowST = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForST);
$totalSeatsDivorceeST = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForST);
$totalSeatsCommonST = $totalSeatsForSTFemale - ($totalSeatsWidowST + $totalSeatsDivorceeST);

$totalSeatsForOBC = Common::getTotalSeatsByCategoryName('OBC', $totalSeatsInSeletedUlb);
$totalSeatsForOBCFemale = Common::getTotalSeatsByGender('F', $totalSeatsForOBC);
$totalSeatsWidowOBC = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForOBC);
$totalSeatsDivorceeOBC = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForOBC);
$totalSeatsCommonOBC = $totalSeatsForOBCFemale - ($totalSeatsWidowOBC + $totalSeatsDivorceeOBC);

$totalSeatsForSPECIALOBC = Common::getTotalSeatsByCategoryName('SPECIALOBC', $totalSeatsInSeletedUlb);
$totalSeatsForSPECIALOBCFemale = Common::getTotalSeatsByGender('F', $totalSeatsForSPECIALOBC);
$totalSeatsWidowSPECIALOBC = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForSPECIALOBC);
$totalSeatsDivorceeSPECIALOBC = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForSPECIALOBC);
$totalSeatsCommonSPECIALOBC = $totalSeatsForSPECIALOBCFemale - ($totalSeatsWidowSPECIALOBC + $totalSeatsDivorceeSPECIALOBC);

$totalSeatsForGENERAL = $totalSeatsInSeletedUlb - ($totalSeatsForSC + $totalSeatsForST + $totalSeatsForOBC + $totalSeatsForSPECIALOBC);
$totalSeatsForGENERALFemale = Common::getTotalSeatsByGender('F', $totalSeatsForGENERAL);
$totalSeatsWidowGENERAL = Common::getTotalSeatsByMaritialStatus('WIDOW', $totalSeatsForGENERAL);
$totalSeatsDivorceeGENERAL = Common::getTotalSeatsByMaritialStatus('DIVORCEE', $totalSeatsForGENERAL);
$totalSeatsCommonGENERAL = $totalSeatsForGENERALFemale - ($totalSeatsWidowGENERAL + $totalSeatsDivorceeGENERAL);

$totalMaleSCSeats = $totalSeatsForSC - ($totalSeatsForSCFemale);
$totalMaleSTSeats = $totalSeatsForST - ($totalSeatsForSTFemale);
$totalMaleOBCSeats = $totalSeatsForOBC - ($totalSeatsForOBCFemale);
$totalMaleSPECIALOBCSeats = $totalSeatsForSPECIALOBC - ($totalSeatsForSPECIALOBCFemale);
$totalMaleGENERALSeats = $totalSeatsForGENERAL - ($totalSeatsForGENERALFemale);
?>

<div class="table-container fleft full-width margin-bottom-4x">
    <table class="ulb-table margin-top-2x">
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

    <table class="ulb-table margin-top-2x">
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