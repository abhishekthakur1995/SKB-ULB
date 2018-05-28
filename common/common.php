<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config.php');

function __construct() {
	$this->myVar = $GLOBALS['link'];
}

class Common {

	const TSP_AREA = ['JAIPUR'];
	const TSP_AREA_EXCLUDE_CATEGORY = ['OBC', 'SPECIALOBC'];

	const totalSeats = [
		'KOTA' => 1821,
		'JAIPUR' => 4961,
		'BEAWAR'=>161,
		'KISHANGARH'=>161,
		'KEKRI'=>113,
		'BIKANER'=>395,
		'NOKHA'=>61,
		'CHOMU'=>71,
		'KISHANGARH'=>54,
		'SHAHPURAJAIPUR'=>19,
		'CHAKSU'=>20,
		'BAGRU'=>9,
		'JOBNER'=>31,
		'VIRATNAGAR'=>6,
		'DAUSA'=>76,
		'LALSOT'=>14,
		'BANDIKUI'=>16,
		'BARI'=>11,
		'RAJAKHEDA'=>113,
		'ALWAR'=>456,
		'KHERTHAL'=>14,
		'TIJARA'=>20,
		'KHERLI'=>16,
		'RAJAGARH'=>64,
		'BEHROR'=>31,
		'BHIWADI'=>202,
		'SIKAR'=>161,
		'NEEMKATHANA'=>19,
		'Shrimadhopur'=>57,
		'RINGUS'=>15,
		'LOSAL'=>11,
		'KHANDELA'=>27,
		'LAXMANGARH'=>24,
		'JHUNJHUNU'=>166,
		'PILANI'=>21,
		'VIDHYAVIHAR'=>24,
		'KHETRI'=>33,
		'MUKUNDGARH'=>25,
		'BISSAU'=>18,
		'NAVALGARH'=>49,
		'CHIRAWA'=>25,
		'UDAIPURVATI'=>28,
		'SURAJGARH'=>16,
		'BAGGAR'=>15,
		'MANDAWA'=>4,
		'JODHPUR'=>2075,
		'BILARA'=>215,
		'PIPARCITY'=>110,
		'FALAUDI'=>119,
		'BARMER'=>88,
		'BALOTRA'=>66,
		'JAISALMER'=>33,
		'POKARAN'=>44,
		'JALORE'=>54,
		'BHINMAL'=>31,
		'SANCHORE'=>39,
		'SIROHI'=>49,
		'SHIVGANJ'=>40,
		'PINDWARA'=>19,
		'ABUROAD'=>26,
		'MOUNTABU'=>51,
		'PALI'=>161,
		'SOJATCITY'=>23,
		'JAITARAN'=>125,
		'SUMERPUR'=>89,
		'TAKHATGARH'=>13,
		'RANI'=>51,
		'BALI'=>14,
		'SADRI'=>13,
		'KAITHOON'=>22,
		'RAMGANJMANDI'=>25,
		'SANGOD'=>74,
		'JHALAWAR'=>25,
		'JHALARAPATAN'=>26,
		'BHAWANIMANDI'=>23,
		'AKLERA'=>7,
		'PIDAVA'=>8,
		'BUNDI'=>59,
		'KAPREN'=>98,
		'LAKHERI'=>67,
		'INDRAGARH'=>18,
		'BARAN'=>103,
		'MANGROL'=>39,
		'SAWAIMADHOPUR'=>55,
	];

	const categoryResPercentage = [
		'GENERAL' => 50,
		'OBC' => 21,
		'SC' => 16,
		'ST' => 12,
		'SPECIALOBC' => 1
	];

	const genderResPercentage = [
		'M' => 70,
		'F' => 30
	];

	const maritialStatusResPercentage = [
		'WIDOW' => 8,
		'DIVORCEE' => 2,
		'MARRIED' => 20,
	];

	public static function getTotalSeatsForUlbByName($ulbRegion) {
		return self::totalSeats[strtoupper($ulbRegion)];
	}

	public static function getTotalSeatsByCategoryName($categoryName, $totalUlbSeats) {
		return self::getPercentage(self::categoryResPercentage[strtoupper($categoryName)], $totalUlbSeats);
	}

	public static function getTotalSeatsByGender($gender, $outOf) {
		return self::getPercentage(self::genderResPercentage[strtoupper($gender)], $outOf);
	}

	public static function getTotalSeatsByMaritialStatus($maritialStatus, $outOf) {
		return self::getPercentage(self::maritialStatusResPercentage[strtoupper($maritialStatus)], $outOf);
	}

	public static function getPercentage($percentage, $of) {
		return floor(($percentage / 100) * $of);
	}


	//get candidates
	public static function getTotalEnteries() {
		$sql = "SELECT * FROM candidate_list WHERE ulbRegion = '".$_SESSION['ulb_region']."'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesByCategory($category) {
		$sql = "SELECT * FROM candidate_list WHERE category = '".$category."' AND ulbRegion = '".$_SESSION['ulb_region']."'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesByStatus($maritialStatus) {
		$sql = "SELECT * FROM candidate_list WHERE maritialStatus = '".$maritialStatus."' AND ulbRegion = '".$_SESSION['ulb_region']."' AND gender = 'f' ";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesByGender($gender) {
		$sql = "SELECT * FROM candidate_list WHERE gender = '".$gender."' AND ulbRegion = '".$_SESSION['ulb_region']."'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesByCatAndGender($category, $gender) {
		$sql = "SELECT * FROM candidate_list WHERE gender = '".$gender."' AND category = '".$category."'AND ulbRegion = '".$_SESSION['ulb_region']."'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesByCatAndStatus($category, $maritialStatus) {
		$sql = "SELECT * FROM candidate_list WHERE category = '".$category."' AND maritialStatus = '".$maritialStatus."' AND ulbRegion = '".$_SESSION['ulb_region']."' AND gender = 'f'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}
}

?>