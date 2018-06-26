<?php

session_start();
 
if($_SESSION['user_role'] == 'SUPERADMIN') {
	require('../config.php');
    require('../common/common.php');
}
	
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$city = htmlspecialchars($_POST['city']);

	$sql = "SELECT ulbRegion, COUNT(*) AS total,
		COUNT(CASE WHEN gender='m' THEN 1 END) AS male,
		COUNT(CASE WHEN gender='f' THEN 1 END) AS female, 

		
		COUNT(CASE WHEN gender='f' AND maritialStatus='WIDOW' THEN 1 END ) AS 'Female Widow',
		COUNT(CASE WHEN gender='f' AND maritialStatus='DIVORCEE' THEN 1 END ) AS 'Female Divorcee',
		COUNT(CASE WHEN gender='f' AND maritialStatus='MARRIED' THEN 1 END ) AS 'Female Married',
		COUNT(CASE WHEN gender='f' AND maritialStatus='UNMARRIED' THEN 1 END ) AS 'Female Unmarried',

		COUNT(CASE WHEN category = 'SC' AND gender='f' AND maritialStatus='DIVORCEE' THEN 1 END ) AS 'SC Female Divorcee',
		COUNT(CASE WHEN category = 'SC' AND gender='f' AND maritialStatus='WIDOW' THEN 1 END ) AS 'SC Female Widow',
		COUNT(CASE WHEN category = 'SC' AND gender='f' AND maritialStatus='MARRIED' THEN 1 END ) AS 'SC Female Married',
		COUNT(CASE WHEN category = 'SC' AND gender='f' AND maritialStatus='UNMARRIED' THEN 1 END ) AS 'SC Female Unmarried',
		COUNT(CASE WHEN category = 'SC' AND gender='m' THEN 1 END ) AS 'SC Male',

		COUNT(CASE WHEN category = 'ST' AND gender='f' AND maritialStatus='DIVORCEE' THEN 1 END ) AS 'ST Female Divorcee',
		COUNT(CASE WHEN category = 'ST' AND gender='f' AND maritialStatus='WIDOW' THEN 1 END ) AS 'ST Female Widow',
		COUNT(CASE WHEN category = 'ST' AND gender='f' AND maritialStatus='MARRIED' THEN 1 END ) AS 'ST Female Married',
		COUNT(CASE WHEN category = 'ST' AND gender='f' AND maritialStatus='UNMARRIED' THEN 1 END ) AS 'ST Female Unmarried',
		COUNT(CASE WHEN category = 'ST' AND gender='m' THEN 1 END ) AS 'ST Male',

		COUNT(CASE WHEN category = 'OBC' AND gender='f' AND maritialStatus='DIVORCEE' THEN 1 END ) AS 'OBC Female Divorcee',
		COUNT(CASE WHEN category = 'OBC' AND gender='f' AND maritialStatus='WIDOW' THEN 1 END ) AS 'OBC Female Widow',
		COUNT(CASE WHEN category = 'OBC' AND gender='f' AND maritialStatus='MARRIED' THEN 1 END ) AS 'OBC Female Married',
		COUNT(CASE WHEN category = 'OBC' AND gender='f' AND maritialStatus='UNMARRIED' THEN 1 END ) AS 'OBC Female Unmarried',
		COUNT(CASE WHEN category = 'OBC' AND gender='m' THEN 1 END ) AS 'OBC Male',

		COUNT(CASE WHEN category = 'SPECIALOBC' AND gender='f' AND maritialStatus='DIVORCEE' THEN 1 END ) AS 'SPECIALOBC Female Divorcee',
		COUNT(CASE WHEN category = 'SPECIALOBC' AND gender='f' AND maritialStatus='WIDOW' THEN 1 END ) AS 'SPECIALOBC Female Widow',
		COUNT(CASE WHEN category = 'SPECIALOBC' AND gender='f' AND maritialStatus='MARRIED' THEN 1 END ) AS 'SPECIALOBC Female Married',
		COUNT(CASE WHEN category = 'SPECIALOBC' AND gender='f' AND maritialStatus='UNMARRIED' THEN 1 END ) AS 'SPECIALOBC Female Unmarried',
		COUNT(CASE WHEN category = 'SPECIALOBC' AND gender='m' THEN 1 END ) AS 'SPECIALOBC Male',

		COUNT(CASE WHEN category = 'GENERAL' AND gender='f' AND maritialStatus='DIVORCEE' THEN 1 END ) AS 'GENERAL Female Divorcee',
		COUNT(CASE WHEN category = 'GENERAL' AND gender='f' AND maritialStatus='WIDOW' THEN 1 END ) AS 'GENERAL Female Widow',
		COUNT(CASE WHEN category = 'GENERAL' AND gender='f' AND maritialStatus='MARRIED' THEN 1 END ) AS 'GENERAL Female Married',
		COUNT(CASE WHEN category = 'GENERAL' AND gender='f' AND maritialStatus='UNMARRIED' THEN 1 END ) AS 'GENERAL Female Unmarried',
		COUNT(CASE WHEN category = 'GENERAL' AND gender='m' THEN 1 END ) AS 'GENERAL Male',

        COUNT(CASE WHEN specialPreference='EXOFFICER' THEN 1 END) AS exofficer,
        COUNT(CASE WHEN specialPreference='SPORTSOERSON' THEN 1 END) AS sportsperson,
        COUNT(CASE WHEN specialPreference='DISABLED' THEN 1 END) AS disabled

		FROM selected_candidates where ulbRegion = '".$city."' GROUP BY ulbRegion ORDER BY ulbRegion DESC";

		$result = mysqli_query($link, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $data = $data[0];
        mysqli_free_result($result);
        mysqli_close($GLOBALS['link']);
}
?>

<table class="table table-bordered">
	<tbody>
	  	<tr>
	    	<th class="text-align-center">Total Male</th>
	        <th class="text-align-center">Total Female</th>
	        <th class="text-align-center">Total Female Widow</th>
	        <th class="text-align-center">Total Female Divorcee</th>
	        <th class="text-align-center">Total Female Married</th>
	        <th class="text-align-center">Total Female Unmarried</th>
	  	</tr>
	  	<tr>
	    	<td class="text-align-center"><?php echo $data['male'];?></td>
	    	<td class="text-align-center"><?php echo $data['female'];?></td>
	    	<td class="text-align-center"><?php echo $data['Female Widow'];?></td>
	    	<td class="text-align-center"><?php echo $data['Female Divorcee'];?></td>
	    	<td class="text-align-center"><?php echo $data['Female Married'];?></td>
	    	<td class="text-align-center"><?php echo $data['Female Unmarried'];?></td>
	  	</tr>
	</tbody>
</table>

<table class="table table-bordered">
	<tbody>
	  	<tr class="margin-top-3x">
	    	<th class="text-align-center">SC Female Divorcee</th>
	        <th class="text-align-center">SC Female Widow</th>
	        <th class="text-align-center">SC Female Married</th>
	        <th class="text-align-center">SC Female Unmarried</th>
	        <th class="text-align-center">SC Male</th>
	  	</tr>
	  	<tr>
	    	<td class="text-align-center"><?php echo $data['SC Female Divorcee'];?></td>
	    	<td class="text-align-center"><?php echo $data['SC Female Widow'];?></td>
	    	<td class="text-align-center"><?php echo $data['SC Female Married'];?></td>
	    	<td class="text-align-center"><?php echo $data['SC Female Unmarried'];?></td>
	    	<td class="text-align-center"><?php echo $data['SC Male'];?></td>
	  	</tr>
	</tbody>
</table>

<table class="table table-bordered">
	<tbody>
	  	<tr class="margin-top-3x">
	    	<th class="text-align-center">ST Female Divorcee</th>
	        <th class="text-align-center">ST Female Widow</th>
	        <th class="text-align-center">ST Female Married</th>
	        <th class="text-align-center">ST Female Unmarried</th>
	        <th class="text-align-center">ST Male</th>
	  	</tr>
	  	<tr>
	    	<td class="text-align-center"><?php echo $data['ST Female Divorcee'];?></td>
	    	<td class="text-align-center"><?php echo $data['ST Female Widow'];?></td>
	    	<td class="text-align-center"><?php echo $data['ST Female Married'];?></td>
	    	<td class="text-align-center"><?php echo $data['ST Female Unmarried'];?></td>
	    	<td class="text-align-center"><?php echo $data['ST Male'];?></td>
	  	</tr>
	</tbody>
</table>

<table class="table table-bordered">
	<tbody>
	  	<tr class="margin-top-3x">
	    	<th class="text-align-center">OBC Female Divorcee</th>
	        <th class="text-align-center">OBC Female Widow</th>
	        <th class="text-align-center">OBC Female Married</th>
	        <th class="text-align-center">OBC Female Unmarried</th>
	        <th class="text-align-center">OBC Male</th>
	  	</tr>
	  	<tr>
	    	<td class="text-align-center"><?php echo $data['OBC Female Divorcee'];?></td>
	    	<td class="text-align-center"><?php echo $data['OBC Female Widow'];?></td>
	    	<td class="text-align-center"><?php echo $data['OBC Female Married'];?></td>
	    	<td class="text-align-center"><?php echo $data['OBC Female Unmarried'];?></td>
	    	<td class="text-align-center"><?php echo $data['OBC Male'];?></td>
	  	</tr>
	</tbody>
</table>

<table class="table table-bordered">
	<tbody>
	  	<tr class="margin-top-3x">
	    	<th class="text-align-center">SPECIALOBC Female Divorcee</th>
	        <th class="text-align-center">SPECIALOBC Female Widow</th>
	        <th class="text-align-center">SPECIALOBC Female Married</th>
	        <th class="text-align-center">SPECIALOBC Female Unmarried</th>
	        <th class="text-align-center">SPECIALOBC Male</th>
	  	</tr>
	  	<tr>
	    	<td class="text-align-center"><?php echo $data['SPECIALOBC Female Divorcee'];?></td>
	    	<td class="text-align-center"><?php echo $data['SPECIALOBC Female Widow'];?></td>
	    	<td class="text-align-center"><?php echo $data['SPECIALOBC Female Married'];?></td>
	    	<td class="text-align-center"><?php echo $data['SPECIALOBC Female Unmarried'];?></td>
	    	<td class="text-align-center"><?php echo $data['SPECIALOBC Male'];?></td>
	  	</tr>
	</tbody>
</table>

<table class="table table-bordered">
	<tbody>
	  	<tr class="margin-top-3x">
	    	<th class="text-align-center">GENERAL Female Divorcee</th>
	        <th class="text-align-center">GENERAL Female Widow</th>
	        <th class="text-align-center">GENERAL Female Married</th>
	        <th class="text-align-center">GENERAL Female Unmarried</th>
	        <th class="text-align-center">GENERAL Male</th>
	  	</tr>
	  	<tr>
	    	<td class="text-align-center"><?php echo $data['GENERAL Female Divorcee'];?></td>
	    	<td class="text-align-center"><?php echo $data['GENERAL Female Widow'];?></td>
	    	<td class="text-align-center"><?php echo $data['GENERAL Female Married'];?></td>
	    	<td class="text-align-center"><?php echo $data['GENERAL Female Unmarried'];?></td>
	    	<td class="text-align-center"><?php echo $data['GENERAL Male'];?></td>
	  	</tr>
	</tbody>
</table>

<table class="table table-bordered">
	<tbody>
	  	<tr class="margin-top-3x">
	    	<th class="text-align-center">Ex-Servicemen</th>
	        <th class="text-align-center">Sportsperson</th>
	        <th class="text-align-center">Disabled</th>
	  	</tr>
	  	<tr>
	    	<td class="text-align-center"><?php echo $data['exofficer'];?></td>
	    	<td class="text-align-center"><?php echo $data['sportsperson'];?></td>
	    	<td class="text-align-center"><?php echo $data['disabled'];?></td>
	  	</tr>
	</tbody>
</table>