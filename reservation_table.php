<?php

//sc
$totalSeatsInSeletedUlb = Common::getTotalSeatsForUlbByName($_SESSION['ulb_region']);

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
$totalMaleGENERALSeats = $totalSeatsForGENERAL - ($totalSeatsForGENERALFemale);
$totalMaleOBCSeats = $totalSeatsForOBC - ($totalSeatsForOBCFemale);
$totalMaleSPECIALOBCSeats = $totalSeatsForSPECIALOBC - ($totalSeatsForSPECIALOBCFemale);

?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="table-container fleft full-width">
        <?php /*
        <table class="ulb-table">
            <thead>
                <tr class="text-align-center"><td colspan="6" class="fs6"><?php echo $lang['tbl1_heading']; ?></td></tr>
                <tr>
                    <th>Total Seats: <?php echo common::getTotalSeatsForUlbByName($_SESSION['ulb_region']); ?></th>
                    <th>Female-Widow</th>
                    <th>Female-Divorcee</th>
                    <th>Female-Common</th>
                    <th>Male</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>SC</td>
                    <td><?php echo $totalSeatsWidowSC; ?></td>
                    <td><?php echo $totalSeatsDivorceeSC; ?></td>
                    <td><?php echo $totalSeatsCommonSC; ?></td>
                    <td><?php echo $totalMaleSCSeats; ?></td>
                    <td><?php echo $totalSeatsForSC; ?></td>
                </tr>
                <tr>
                    <td>ST</td>
                    <td><?php echo $totalSeatsWidowST; ?></td>
                    <td><?php echo $totalSeatsDivorceeST; ?></td>
                    <td><?php echo $totalSeatsCommonST; ?></td>
                    <td><?php echo $totalMaleSTSeats; ?></td>
                    <td><?php echo $totalSeatsForST; ?></td>
                </tr>
                <tr>
                    <td>OBC</td>
                    <td><?php echo $totalSeatsWidowOBC; ?></td>
                    <td><?php echo $totalSeatsDivorceeOBC; ?></td>
                    <td><?php echo $totalSeatsCommonOBC; ?></td>
                    <td><?php echo $totalMaleOBCSeats; ?></td>
                    <td><?php echo $totalSeatsForOBC; ?></td>
                </tr>
                <tr>
                    <td>Special OBC</td>
                    <td><?php echo $totalSeatsWidowSPECIALOBC; ?></td>
                    <td><?php echo $totalSeatsDivorceeSPECIALOBC; ?></td>
                    <td><?php echo $totalSeatsCommonSPECIALOBC; ?></td>
                    <td><?php echo $totalMaleSPECIALOBCSeats; ?></td>
                    <td><?php echo $totalSeatsForSPECIALOBC; ?></td>
                </tr>
                <tr>
                    <td>General</td>
                    <td><?php echo $totalSeatsWidowGENERAL; ?></td>
                    <td><?php echo $totalSeatsDivorceeGENERAL; ?></td>
                    <td><?php echo $totalSeatsCommonGENERAL; ?></td>
                    <td><?php echo $totalMaleGENERALSeats; ?></td>
                    <td><?php echo $totalSeatsForGENERAL; ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><?php echo $totalSeatsWidowSC+$totalSeatsWidowST+$totalSeatsWidowOBC+$totalSeatsWidowGENERAL+$totalSeatsWidowSPECIALOBC; ?> </td>
                    <td><?php echo $totalSeatsDivorceeSC+$totalSeatsDivorceeST+$totalSeatsDivorceeOBC+$totalSeatsDivorceeGENERAL+$totalSeatsDivorceeSPECIALOBC; ?></td>
                    <td><?php echo $totalSeatsCommonSC+$totalSeatsCommonST+$totalSeatsCommonOBC+$totalSeatsCommonGENERAL+$totalSeatsCommonSPECIALOBC; ?></td>
                    <td><?php echo $totalMaleSCSeats+$totalMaleSTSeats+$totalMaleOBCSeats+$totalMaleGENERALSeats+$totalMaleSPECIALOBCSeats; ?></td>
                    <td><?php echo $totalSeatsInSeletedUlb; ?>/<?php echo $totalSeatsInSeletedUlb ?></td>
                </tr>
            </tbody>
        </table>
        */ ?>

        <table class="ulb-table">
        <thead>
            <tr class="text-align-center"><td colspan="6" class="fs6"><?php echo $lang['tbl2_heading']; ?></td></tr>
            <tr>
                <th>Total Candidates: <?php echo Common::getTotalEnteries(); ?></th>
                <th>Female-Widow</th>
                <th>Female-Divorcee</th>
                <th>Female-Common</th>
                <th>Male</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SC</td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('SC', 'WIDOW'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('SC', 'DIVORCEE'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('SC', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('SC', 'UNMARRIED') ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndGender('SC', 'm'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCategory('SC'); ?></td>
            </tr>
            <tr>
                <td>ST</td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('ST', 'WIDOW'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('ST', 'DIVORCEE'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('ST', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('ST', 'UNMARRIED') ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndGender('ST', 'm'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCategory('ST'); ?></td>
            </tr>
            <tr>
                <td>OBC</td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('OBC', 'WIDOW'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('OBC', 'DIVORCEE'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('OBC', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('OBC', 'UNMARRIED') ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndGender('OBC', 'm'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCategory('OBC'); ?></td>
            </tr>
            <tr>
                <td>SPECIAL OBC</td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('SPECIALOBC', 'WIDOW'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('SPECIALOBC', 'DIVORCEE'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('SPECIALOBC', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('SPECIALOBC', 'UNMARRIED') ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndGender('SPECIALOBC', 'm'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCategory('SPECIALOBC'); ?></td>
            </tr>
            <tr>
                <td>GENERAL</td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('GENERAL', 'WIDOW'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('GENERAL', 'DIVORCEE'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndStatus('GENERAL', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('GENERAL', 'UNMARRIED') ?></td>
                <td><?php echo Common::getTotalEnteriesByCatAndGender('GENERAL', 'm'); ?></td>
                <td><?php echo Common::getTotalEnteriesByCategory('GENERAL'); ?></td>
            </tr>
            <tr>
                <td>Total</td>
                <td><?php echo Common::getTotalEnteriesByStatus('WIDOW'); ?></td>
                <td><?php echo Common::getTotalEnteriesByStatus('DIVORCEE'); ?></td>
                <td><?php echo Common::getTotalEnteriesByStatus('MARRIED') + Common::getTotalEnteriesByStatus('UNMARRIED') ?></td>
                <td><?php echo Common::getTotalEnteriesByGender('m'); ?></td>
                <?php $totalEnteries = Common::getTotalEnteries(); ?>
                <td><?php echo $totalEnteries.'/'.$totalEnteries ?></td>
            </tr>
        </tbody>
        </table>
    </div>
</body>
</html>