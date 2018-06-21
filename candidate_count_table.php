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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="table-container fleft full-width">
        <table class="ulb-table no-margin">
            <thead>
                <tr class="text-align-center"><td colspan="6" class="fs6"><?php echo $lang['tbl2_heading']; ?></td></tr>
                <tr>
                      <th><?php echo  $lang['totalentries']; ?>: <?php echo Common::getTotalEnteries(); ?></th>
                    <th><?php echo  $lang['tbl2_heading_1']; ?></th>
                    <th><?php echo  $lang['tbl2_heading_2']; ?></th>
                    <th><?php echo  $lang['tbl2_heading_3']; ?></th>
                    <th><?php echo  $lang['tbl2_heading_4']; ?></th>
                    <th><?php echo  $lang['totalentries'];  ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $lang['SC']?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('SC', 'WIDOW'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('SC', 'DIVORCEE'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('SC', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('SC', 'UNMARRIED') ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndGender('SC', 'm'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCategory('SC'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $lang['ST']?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('ST', 'WIDOW'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('ST', 'DIVORCEE'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('ST', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('ST', 'UNMARRIED') ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndGender('ST', 'm'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCategory('ST'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $lang['OBC']?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('OBC', 'WIDOW'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('OBC', 'DIVORCEE'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('OBC', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('OBC', 'UNMARRIED') ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndGender('OBC', 'm'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCategory('OBC'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $lang['Special OBC']?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('SPECIALOBC', 'WIDOW'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('SPECIALOBC', 'DIVORCEE'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('SPECIALOBC', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('SPECIALOBC', 'UNMARRIED') ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndGender('SPECIALOBC', 'm'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCategory('SPECIALOBC'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $lang['General']?></td></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('GENERAL', 'WIDOW'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('GENERAL', 'DIVORCEE'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndStatus('GENERAL', 'MARRIED') + Common::getTotalEnteriesByCatAndStatus('GENERAL', 'UNMARRIED') ?></td>
                    <td><?php echo Common::getTotalEnteriesByCatAndGender('GENERAL', 'm'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByCategory('GENERAL'); ?></td>
                </tr>
                <tr>
                    <td><?php echo  $lang['total'];  ?></td>
                    <td><?php echo Common::getTotalEnteriesByStatus('WIDOW'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByStatus('DIVORCEE'); ?></td>
                    <td><?php echo Common::getTotalEnteriesByStatus('MARRIED') + Common::getTotalEnteriesByStatus('UNMARRIED') ?></td>
                    <td><?php echo Common::getTotalEnteriesByGender('m'); ?></td>
                    <?php $totalEnteries = Common::getTotalEnteries(); ?>
                    <td><?php echo $totalEnteries.'/'.$totalEnteries ?></td>
                </tr>
            </tbody>
        </table>

        <?php 
            $totalEnteriesEXOFFICER = Common::getTotalEnteriesBySpecialPreferences('EXOFFICER');
            $totalEnteriesDISABLED =  Common::getTotalEnteriesBySpecialPreferences('DISABLED');
            $totalEnteriesSPORTSPERSON = Common::getTotalEnteriesBySpecialPreferences('SPORTSPERSON');
            $totalSpecialPreference = $totalEnteriesEXOFFICER + $totalEnteriesDISABLED + $totalEnteriesSPORTSPERSON;
        ?>

        <table class="ulb-table margin-top-3x">
            <thead>
                <tr>
                    <th><?php echo  $lang['totalentries'];  ?> <?php echo $totalSpecialPreference; ?></th>
                    <th><?php echo $lang['EXOFFICER'];?></th>
                    <th><?php echo $lang['DISABLED'];?></th>
                    <th><?php echo $lang['SPORTSPERSON'];?></th>
                    <th><?php echo  $lang['totalentries'];  ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $lang['SC']?></td>
                    <td class="text-align-center">
                        <?php 
                            $count1 =  Common::getTotalEnteriesBySpecialPreferencesCategory('EXOFFICER', 'SC');
                            echo $count1;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count2 = Common::getTotalEnteriesBySpecialPreferencesCategory('DISABLED', 'SC'); 
                            echo $count2;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count3 =  Common::getTotalEnteriesBySpecialPreferencesCategory('SPORTSPERSON', 'SC');
                            echo $count3;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php echo $count1 + $count2 + $count3; ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $lang['ST']?></td>
                    <td class="text-align-center">
                        <?php 
                            $count1 =  Common::getTotalEnteriesBySpecialPreferencesCategory('EXOFFICER', 'ST');
                            echo $count1;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count2 = Common::getTotalEnteriesBySpecialPreferencesCategory('DISABLED', 'ST'); 
                            echo $count2;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count3 =  Common::getTotalEnteriesBySpecialPreferencesCategory('SPORTSPERSON', 'ST');
                            echo $count3;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php echo $count1 + $count2 + $count3; ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $lang['OBC']?></td>
                    <td class="text-align-center">
                        <?php 
                            $count1 =  Common::getTotalEnteriesBySpecialPreferencesCategory('EXOFFICER', 'OBC');
                            echo $count1;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count2 = Common::getTotalEnteriesBySpecialPreferencesCategory('DISABLED', 'OBC'); 
                            echo $count2;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count3 =  Common::getTotalEnteriesBySpecialPreferencesCategory('SPORTSPERSON', 'OBC');
                            echo $count3;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php echo $count1 + $count2 + $count3; ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $lang['Special OBC']?></td>
                    <td class="text-align-center">
                        <?php 
                            $count1 =  Common::getTotalEnteriesBySpecialPreferencesCategory('EXOFFICER', 'SPECIALOBC');
                            echo $count1;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count2 = Common::getTotalEnteriesBySpecialPreferencesCategory('DISABLED', 'SPECIALOBC'); 
                            echo $count2;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count3 =  Common::getTotalEnteriesBySpecialPreferencesCategory('SPORTSPERSON', 'SPECIALOBC');
                            echo $count3;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php echo $count1 + $count2 + $count3; ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $lang['General']?></td>
                    <td class="text-align-center">
                        <?php 
                            $count1 =  Common::getTotalEnteriesBySpecialPreferencesCategory('EXOFFICER', 'GENERAL');
                            echo $count1;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count2 = Common::getTotalEnteriesBySpecialPreferencesCategory('DISABLED', 'GENERAL'); 
                            echo $count2;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php 
                            $count3 =  Common::getTotalEnteriesBySpecialPreferencesCategory('SPORTSPERSON', 'GENERAL');
                            echo $count3;
                        ?>
                    </td>
                    <td class="text-align-center">
                        <?php echo $count1 + $count2 + $count3; ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $lang['total']?></td>
                    <td class="text-align-center"><?php echo $totalEnteriesEXOFFICER; ?></td>
                    <td class="text-align-center"><?php echo $totalEnteriesDISABLED ?></td>
                    <td class="text-align-center"><?php echo $totalEnteriesSPORTSPERSON ?></td>
                    <td class="text-align-center"><?php echo $totalSpecialPreference.'/'.$totalSpecialPreference; ?></td>
                </tr>
            </tbody>
        </table>

    </div>
</body>
</html>
