<?php

class Common {

	//Total Seats

	const totalSeats = [
		'KOTA' => 1821,
		'JAIPUR' => 4961,
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