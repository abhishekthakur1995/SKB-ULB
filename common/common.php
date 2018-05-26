<?php

class Common {

	//Total Seats

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

	//

	// const categoryReservation = [
	// 	'GENERAL' => 50,
	// 	'OBC' => 21,`
	// 	'SC' => 16,
	// 	'ST' => 12,
	// 	'SPECIALOBC' => 1
	// ];

	// const genderReservation = [
	// 	'M' => 70,
	// 	'F' => 30
	// ];

	// const femaleCategoryReservation = [
	// 	'WIDOW' => 8,
	// 	'DIVORCEE' => 2,
	// 	'MARRIED' => 10,
	// 	'SINGLE' => 10,
	// ];


	// public static function reservationAllocation($category, $totalSeats) {
	// 	$arr = [];
	// 	$arr['general']['male'] = 
	// }

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

}

?>