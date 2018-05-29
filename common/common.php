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
		'PUSHKAR'=>97,
		'VIJAYNAGAR'=>68,
		'SARWAR'=>40,
		'BHILWARA'=>320,
		'GULABPURA'=>14,
		'GANGAPUR'=>8,
		'AASIND'=>9,
		'MANDALGARH'=>8,
		'SHAHPURABHILWARA'=>20,
		'NAGAUR'=>50,
		'LADNU'=>127,
		'MERTACITY'=>50,
		'MAKRANA'=>39,
		'PARBATSAR'=>56,
		'NAWA'=>12,
		'KUCHERA'=>8,
		'MUNDWA'=>7,
		'KUCHAMANCITY'=>28,
		'TONK'=>391,
		'DEOLI'=>22,
		'NIWAI'=>29,
		'MALPURA'=>29,
		'TODARAISINGH'=>33,
		'UNIARA'=>19,
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
		'RAJAGARH'=>65,
		'BEHROR'=>31,
		'BHIWADI'=>202,
		'SIKAR'=>161,
		'NEEMKATHANA'=>19,
		'SHRIMADHOPUR'=>57,
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
		'AJMER' =>1115,
		'JAHAZPUR' =>53,
		'DIDWANA' =>34,
		'SHRIDUNGARGARH' =>20,
		'DESHNOK' =>20,
		'SHRIGANGANAGAR' =>114,
		'RAISINGHNAGAR' =>43,
		'ANUPGARH' =>9,
		'PADAMPURA' =>14,
		'KARANPUR' =>28,
		'SARDULSAHAR' =>19,
		'SHREEVIJAYNAGAR' =>28,
		'GAJSINGHPURA' =>8,
		'SURATGARH' =>64,
		'HANUMANGARH' =>134,
		'BHADRA' =>30,
		'NOHAR' =>38,
		'RAWATSAR' =>55,
		'SANGARIYA' =>79,
		'PILIBANGA' =>36,
		'CHURU' =>59,
		'TARANAGAR' =>19,
		'RATANNAGAR' =>24,
		'RATANGARH' =>58,
		'RAJGARH' =>131,
		'CHHAPAR' =>17,
		'RAJALDESAR' =>26,
		'BIDASAR' =>21,
		'SUJANGARH' =>88,
		'SARDARSAHAR' =>45,
		'PHULERA' =>9,
		'SAMBHARLAKE' =>19,
		'KHUDALAFALNA' =>14,
		'KPATAN' =>51,
		'NAINWA' =>68,
		'ANTA' =>58,
		'KOTPUTLI' =>24,
		'DHAULPUR' =>99,
		'RAMGARH' =>6,
		'FATEHPURSHEKHAWATI' =>64,
		'CHABRA' =>41,
		'GANGAPUR' =>41,
		'HINDON' =>25,
		'UDAIPUR' =>1174,
		'FATEHNAGARSANWAD' =>24,
		'BHINDAR' =>26,
		'KANOD' =>39,
		'SALUMBAR' =>14,
		'BANSWARA' =>219,
		'KUSHALGARH' =>23,
		'DUNGARPUR' =>33,
		'SANGWADA' =>26,
		'CHITTAURGARH' =>97,
		'NIMBAHERA' =>45,
		'KAPASAN' =>26,
		'BADISADRI' =>18,
		'BEGU' =>15,
		'RAWATBHATA' =>192,
		'PRATAPGARH' =>53,
		'CHOTISADRI' =>14,
		'RAJSAMAND' =>79,
		'NATHDWARA' =>56,
		'DEVGARH' =>23,
		'AMET' =>24,
		'KARAULI' =>27,
		'TODABHIM' =>16,
		'BHARATPUR' =>352,
		'WEIR' =>7,
		'BHUSAWAL' =>21,
		'BAYANA' =>47,
		'DEEG' =>56,
		'KUMHER' =>7,
		'NAGAR' =>9,
		'KAMA' =>15,
		'NADBAI' =>20,
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