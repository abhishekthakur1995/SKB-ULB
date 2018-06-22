<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/languages/hi/lang.hi.php');

class Common {

	const TSP_AREA = ['BANSWARA', 'DUNGARPUR', 'PRATAPGARH', 'SAGWARA'];
	const TSP_AREA_EXCLUDE_CATEGORY = ['OBC', 'SPECIALOBC'];

	const totalSeats = [
		'AAMET' => 24,
		'AASIND'=>9,
		'BEAWAR'=>161,
		'KOTA'=>1821,
		'JAIPUR'=>4961,
		'KISHANGARH'=>161,
		'KEKRI'=>113,
		'PUSHKAR'=>97,
		'VIJAYNAGAR'=>68,
		'SARWAR'=>40,
		'BHILWARA'=>320,
		'GULABPURA'=>14,
		'GANGAPUR'=>8,
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
		'NOKHA'=>38,
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
		'BILARA'=>155,
		'PIPARCITY'=>110,
		'FALAUDI'=>50,
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
		'RANI'=>30,
		'BALI'=>14,
		'SADRI'=>13,
		'KAITHOON'=>22,
		'RAMGANJMANDI'=>25,
		'SANGOD'=>74,
		'JHALAWAR'=>125,
		'JHALARAPATAN'=>100,
		'BHAWANIMANDI'=>73,
		'AKLERA'=>50,
		'PIDAVA'=>50,
		'BUNDI'=>59,
		'KAPREN'=>98,
		'LAKHERI'=>67,
		'INDRAGARH'=>18,
		'BARAN'=>103,
		'MANGROL'=>39,
		'SAWAIMADHOPUR'=>55,
		'AJMER'=>1115,
		'JAHAZPUR'=>33,
		'DIDWANA'=>34,
		'SHRIDUNGARGARH'=>20,
		'DESHNOK'=>20,
		'SHRIGANGANAGAR'=>114,
		'RAISINGHNAGAR'=>32,
		'ANOOPGARH'=>43,
		'PADAMPURA'=>14,
		'SHRIKARANPUR'=>28,
		'SADULSAHAR'=>19,
		'SHREEVIJAYNAGAR'=>28,
		'GAJSINGHPURA'=>8,
		'SURATGARH'=>64,
		'HANUMANGARH'=>134,
		'BHADRA'=>30,
		'NOHAR'=>38,
		'RAWATSAR'=>55,
		'SANGARIYA'=>79,
		'PILIBANGA'=>36,
		'CHURU'=>59,
		'TARANAGAR'=>19,
		'RATANNAGAR'=>24,
		'RATANGARH'=>58,
		'RAJGARH'=>131,
		'CHHAPAR'=>17,
		'RAJALDESAR'=>26,
		'BIDASAR'=>21,
		'SUJANGARH'=>88,
		'SARDARSAHAR'=>45,
		'PHULERA'=>9,
		'SAMBHARLAKE'=>19,
		'KHUDALAFALNA'=>14,
		'KPATAN'=>51,
		'NAINWA'=>68,
		'ANTA'=>10,
		'KOTPUTLI'=>24,
		'DHAULPUR'=>99,
		'RAMGARH'=>6,
		'FATEHPURSHEKHAWATI'=>64,
		'CHHABRA'=>41,
		'GANGAPURCITY'=>41,
		'HINDON'=>25,
		'UDAIPUR'=>1174,
		'FATEHNAGAR'=>24,
		'BHINDAR'=>26,
		'KANOD'=>39,
		'SALUMBAR'=>14,
		'BANSWARA'=>219,
		'KUSHALGARH'=>23,
		'DUNGARPUR'=>33,
		'SAGWARA'=>26,
		'CHITTAURGARH'=>97,
		'NIMBAHERA'=>45,
		'KAPASAN'=>26,
		'BADISADRI'=>18,
		'BEGU'=>15,
		'RAWATBHATA'=>128,
		'PRATAPGARH'=>53,
		'CHOTISADRI'=>14,
		'RAJSAMAND'=>79,
		'NATHDWARA'=>56,
		'DEVGARH'=>23,
		'AMET'=>24,
		'KARAULI'=>27,
		'TODABHIMA'=>16,
		'BHARATPUR'=>352,
		'WEIR'=>7,
		'BHUSAWAL'=>21,
		'BAYANA'=>47,
		'DEEG'=>56,
		'KUMHER'=>7,
		'NAGAR'=>9,
		'KAMA'=>15,
		'NADBAI'=>20,
		'KESARISINGHPUR'=>9,
	];

	const categoryResPercentage = [
		'EXOFFICER' => 12.5,
		'DISABLED' => 3,
		'SPORTSPERSON' => 2,
		'SC' => 16,
		'ST' => 12,
		'OBC' => 21,
		'SPECIALOBC' => 1,
		'GENERAL' => 50
	];

	const tspCategoryResPercentage = [
		'EXOFFICER' => 12.5,
		'DISABLED' => 3,
		'SPORTSPERSON' => 2,
		'SC' => 45,
		'ST' => 5,
		'OBC' => 0,
		'SPECIALOBC' => 0,
		'GENERAL' => 50
	];

	const genderResPercentage = [
		'M' => 70,
		'F' => 30
	];

	const maritialStatusResPercentage = [
		'WIDOW' => 8,
		'DIVORCEE' => 2,
		'MARRIED' => 20,
		'UNMARRIED' => 20,
	];

	const codes = [
		'EXOFFICER' => 0,
		'DISABLED' => 1,
		'SPORTSPERSON' => 2,
		'SC_FEMALE_WIDOW' => 3,
		'SC_FEMALE_DIVORCEE' =>4,
		'SC_FEMALE_COMMON'=> 5,
		'SC_MALE' =>6,
		'ST_FEMALE_WIDOW' => 7,
		'ST_FEMALE_DIVORCEE' =>8,
		'ST_FEMALE_COMMON'=> 9,
		'ST_MALE' =>10,
		'OBC_FEMALE_WIDOW' => 11,
		'OBC_FEMALE_DIVORCEE' =>12,
		'OBC_FEMALE_COMMON'=> 13,
		'OBC_MALE' =>14,
		'SPECIALOBC_FEMALE_WIDOW' => 15,
		'SPECIALOBC_FEMALE_DIVORCEE' =>16,
		'SPECIALOBC_FEMALE_COMMON'=> 17,
		'SPECIALOBC_MALE' =>18,
		'GENERAL_FEMALE_WIDOW' => 19,
		'GENERAL_FEMALE_DIVORCEE' =>20,
		'GENERAL_FEMALE_COMMON'=> 21,
		'GENERAL_MALE' =>22,
	];

	const complementaryPairArr = [
		'SC_FEMALE_WIDOW' => 'SC_FEMALE_DIVORCEE',
		'SC_FEMALE_DIVORCEE' => 'SC_FEMALE_WIDOW',
	];

	//These are the categories which seats will be nullified when no candidates are found
	const noTransferCriteria = [
		'SC_FEMALE_DIVORCEE', 'ST_FEMALE_DIVORCEE'
	];

	public static function getTotalSeatsForExofficer($totalUlbSeats) {
		return self::getPercentage(self::categoryResPercentage['EXOFFICER'], $totalUlbSeats);
	}

	public static function getTotalSeatsForDisabled($totalUlbSeats) {
		return self::getPercentage(self::categoryResPercentage['DISABLED'], $totalUlbSeats);
	}

	public static function getTotalSeatsForSportsperson($totalUlbSeats) {
		return self::getPercentage(self::categoryResPercentage['SPORTSPERSON'], $totalUlbSeats);
	}

	public static function getCodeForSelectionCriteria($criteria) {
		return self::codes[strtoupper($criteria)];
	}

	public static function getTotalSeatsForUlbByName($ulbRegion) {
		return self::totalSeats[strtoupper($ulbRegion)];
	}

	public static function getCandidateSelectionLimitForSpecialPreferences($criteria) {
		if(in_array($_SESSION['ulb_region'], Common::TSP_AREA)) {
			return self::getPercentage(self::tspCategoryResPercentage[$criteria], self::getTotalSeatsForUlbByName($_SESSION['ulb_region']));		
		} else {
			return self::getPercentage(self::categoryResPercentage[$criteria], self::getTotalSeatsForUlbByName($_SESSION['ulb_region']));
		}
	}

	public static function getTotalSeatsByCategoryName($categoryName, $totalUlbSeats) {
		if(in_array($_SESSION['ulb_region'], Common::TSP_AREA)) {
			return self::getPercentage(self::tspCategoryResPercentage[strtoupper($categoryName)], $totalUlbSeats);
		} else {
			return self::getPercentage(self::categoryResPercentage[strtoupper($categoryName)], $totalUlbSeats);
		}
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

	public static function getCountOfTotalEnteries() {
		$sql= "SELECT COUNT(*) as total from candidate_list where status = 0";
		$result=mysqli_query($GLOBALS['link'], $sql);
		$data=mysqli_fetch_assoc($result);
		return $data['total'];
	}

	public static function getTotalEnteries() {
		$sql = "SELECT COUNT(*) as total FROM candidate_list WHERE status = 0 AND ulbRegion = '".$_SESSION['ulb_region']."'";
		$result=mysqli_query($GLOBALS['link'], $sql);
		$data=mysqli_fetch_assoc($result);
		return $data['total'];
	}

	public static function getTotalEnteriesByCategory($category) {
		$sql = "SELECT * FROM candidate_list WHERE status = 0 AND category = '".$category."' AND ulbRegion = '".$_SESSION['ulb_region']."'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesByStatus($maritialStatus) {
		$sql = "SELECT * FROM candidate_list WHERE status = 0 AND maritialStatus = '".$maritialStatus."' AND ulbRegion = '".$_SESSION['ulb_region']."' AND gender = 'f' ";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesByGender($gender) {
		$sql = "SELECT * FROM candidate_list WHERE status = 0 AND gender = '".$gender."' AND ulbRegion = '".$_SESSION['ulb_region']."'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesByCatAndGender($category, $gender) {
		$sql = "SELECT * FROM candidate_list WHERE status = 0 AND gender = '".$gender."' AND category = '".$category."'AND ulbRegion = '".$_SESSION['ulb_region']."'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesByCatAndStatus($category, $maritialStatus) {
		$sql = "SELECT * FROM candidate_list WHERE status = 0 AND category = '".$category."' AND maritialStatus = '".$maritialStatus."' AND ulbRegion = '".$_SESSION['ulb_region']."' AND gender = 'f'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesBySpecialPreferences($specialPreference) {
		$sql = "SELECT * FROM candidate_list WHERE status = 0 AND specialPreference = '".$specialPreference."' AND ulbRegion = '".$_SESSION['ulb_region']."'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function getTotalEnteriesBySpecialPreferencesCategory($specialPreference, $category) {
		$sql = "SELECT * FROM candidate_list WHERE status = 0 AND category = '".$category."' AND specialPreference = '".$specialPreference."' AND ulbRegion = '".$_SESSION['ulb_region']."'";
		$res = mysqli_query($GLOBALS['link'], $sql);
		$count = mysqli_num_rows($res);
		return $count;
	}

	public static function createUlbEntryInReservationChartTable() {
		$sql = "INSERT INTO reservation_chart (ULB_REGION) VALUES (?)";
		if($stmt = mysqli_prepare($GLOBALS['link'], $sql)){
			mysqli_stmt_bind_param($stmt, "s", $param_ulbRegion);
			$param_ulbRegion = $_SESSION['ulb_region'];
			if(mysqli_stmt_execute($stmt)){
                echo "Entry created into reservation chart table";
            } else {
            	echo "ERROR: Could not able to execute $sql. " . mysqli_error($GLOBALS['link']);
            }
		}
		mysqli_stmt_close($stmt);
	}

	public static function populateReservationChartTable($fieldName, $value) {
		$sql = "UPDATE reservation_chart SET ".$fieldName." = ".$value." WHERE ULB_REGION ='".$_SESSION['ulb_region']."'";
		if(mysqli_query($GLOBALS['link'], $sql)){
    	} else {
        	echo "ERROR: Could not able to execute $sql. " . mysqli_error($GLOBALS['link']);
    	}
	}

	public static function getUpdatedSeats() {
		$sql = "SELECT TOTAL_GENERAL FROM reservation_chart WHERE ULB_REGION = '".$_SESSION['ulb_region']."'";
		$result = mysqli_query($GLOBALS['link'], $sql);
		$row = mysqli_fetch_array($result);
		$totalGeneralSeats = $row['TOTAL_GENERAL'];

		$val = array();
		$val['TOTAL_FEMALE'] = self::getTotalSeatsByGender('F', $totalGeneralSeats);
		$val['GENERAL_FEMALE_WIDOW'] = self::getTotalSeatsByMaritialStatus('WIDOW', $totalGeneralSeats);
		$val['GENERAL_FEMALE_DIVORCEE'] = self::getTotalSeatsByMaritialStatus('DIVORCEE', $totalGeneralSeats);
		$val['GENERAL_FEMALE_COMMON'] = $val['TOTAL_FEMALE'] - ($val['GENERAL_FEMALE_WIDOW'] + $val['GENERAL_FEMALE_DIVORCEE']);
		$val['GENERAL_MALE'] = $totalGeneralSeats - $val['TOTAL_FEMALE'];
		return $val;
	}

	// public static function updateGeneralCandidatesSeat($count) {
	// 	$sql = "UPDATE reservation_chart SET TOTAL_GENERAL = TOTAL_GENERAL + ".$count." WHERE ULB_REGION = '".$_SESSION['ulb_region']."'";

	// 	if(mysqli_query($GLOBALS['link'], $sql)){
	// 		$updatedSeats = Common::getUpdatedSeats();
	// 		$sql = "UPDATE reservation_chart SET GENERAL_FEMALE_WIDOW = ".$updatedSeats['GENERAL_FEMALE_WIDOW'].", GENERAL_FEMALE_DIVORCEE = ".$updatedSeats['GENERAL_FEMALE_DIVORCEE'].", GENERAL_FEMALE_COMMON = ".$updatedSeats['GENERAL_FEMALE_COMMON'].", GENERAL_MALE = ".$updatedSeats['GENERAL_MALE']." WHERE ULB_REGION = '".$_SESSION['ulb_region']."'";
	// 		if(mysqli_query($GLOBALS['link'], $sql)){
	// 			// data updated
	// 		} else {
	// 			echo "ERROR: Could not able to execute $sql. " . mysqli_error($GLOBALS['link']);
	// 		}
 //    	} else {
 //        	echo "ERROR: Could not able to execute $sql. " . mysqli_error($GLOBALS['link']);
 //    	}

	// }

	public static function existsInDb($value, $field) {
		$sql = "SELECT id FROM lock_code_seed WHERE ulbRegion = ? AND ".$field." = ?";
		if($stmt = mysqli_prepare($GLOBALS['link'], $sql)){
			mysqli_stmt_bind_param($stmt, "ss", $param_ulbRegion, $param_fieldValue);
			$param_fieldValue = $value;
			$param_ulbRegion = $_SESSION['ulb_region'];
			if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) > 0){
                    return true;
                } else{
                    return false;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
	}

	public static function codeAndSeedExistsInDB($code, $seed) {
		$sql = "SELECT id FROM lock_code_seed WHERE ulbRegion = ? AND seedNumber = ? AND code = ?";
        if($stmt = mysqli_prepare($GLOBALS['link'], $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_ulbRegion, $param_seedNumber, $param_code);
            $param_ulbRegion = $_SESSION['ulb_region'];
            $param_code = $code;
            $param_seedNumber = $seed;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    return true;
                } else{
                    return false;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
	}

	public static function getDuplicateRecordsData() {
		$sql = "SET @a:=0";
		mysqli_query($GLOBALS['link'], $sql);

		$sql = "SELECT t1.*, @a:=@a+1 AS serialNumber FROM candidate_list t1 JOIN(
            		SELECT name, guardian, dob FROM candidate_list GROUP BY name, guardian, dob HAVING COUNT(*) >= 2
                ) t2 ON t1.name = t2.name AND t1.guardian = t2.guardian AND t1.dob = t2.dob WHERE status = 0 ORDER BY name, guardian";

        $result = mysqli_query($GLOBALS['link'], $sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        mysqli_close($GLOBALS['link']);
        return $data;
	}

	public static function getDataFromDbByCodeAndSeed($code, $seedNumber) {
		$sql = "SET @a:=0";
		mysqli_query($GLOBALS['link'], $sql);

		$sql = "SELECT *, @a:=@a+1 AS serialNumber FROM selected_candidates INNER JOIN candidate_list ON selected_candidates.receiptNumber = candidate_list.receiptNumber WHERE selected_candidates.code = ".$code." AND selected_candidates.seedNumber = ".$seedNumber." AND selected_candidates.ulbRegion = '".$_SESSION['ulb_region']."'";

        $res = mysqli_query($GLOBALS['link'], $sql);
        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $data;
	}

	public static function getCandidateSelectionLimit($criteria) {
		$sql = "SELECT ".$criteria." FROM reservation_chart WHERE ULB_REGION = ?";
		if($stmt = mysqli_prepare($GLOBALS['link'], $sql)){ 
		 	mysqli_stmt_bind_param($stmt, "s", $param_ulbName);
		 	$param_ulbName = $_SESSION['ulb_region'];
		 	if(mysqli_stmt_execute($stmt)){
		 		mysqli_stmt_store_result($stmt);
		 		if(mysqli_stmt_num_rows($stmt) == 1){
		 			mysqli_stmt_bind_result($stmt, $limit);
		 			if(mysqli_stmt_fetch($stmt)){
		 				return $limit;
		 			}
		 		} else {
		 			echo "No Record Found";
		 		}
		 	}
		}
		mysqli_stmt_close($stmt);
	}

	public static function selectCandidatesForSpecialPrefCategory($prefName, $limit, $code, $seedNumber) {
		$sql = "SET @a:=0";
		mysqli_query($GLOBALS['link'], $sql);

		$sql = "SELECT *, @a:=@a+1 AS serialNumber from candidate_list WHERE status = 0 AND selected = 0 AND specialPreference = '".$prefName."' AND ulbRegion = '".$_SESSION['ulb_region']."' ORDER BY RAND() LIMIT ".$limit;

		$data = array();
		if ($res = mysqli_query($GLOBALS['link'], $sql)) {
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					array_push($data, $row);
					$statusUpdated = self::updateStatusOfSelectedCandidates($row['id']);
					if($statusUpdated) {
						self::removeSpecialPreferencesSeatsFromCategories($row['category'], $row['gender']);
						self::copySelectedCandidateData($row, $code, $seedNumber);
					}
				}
				self::lockSeedAndCode($code, $seedNumber);
				return $data;
			} else {
				echo "No candidate found";
			}
		}
	}

	public static function removeSpecialPreferencesSeatsFromCategories($category, $gender) {
		$deleteFrom = ($gender == 'f') ? strtoupper($category.'_FEMALE_COMMON') : strtoupper($category.'_MALE');
		$sql = "UPDATE reservation_chart SET ".$deleteFrom." = ".$deleteFrom." - 1 WHERE ULB_REGION = '".$_SESSION['ulb_region']."'";

		if(mysqli_query($GLOBALS['link'], $sql)) {
			//echo "Data descreased";
		} else {
			echo "Error updating record: " . mysqli_error($GLOBALS['link']);
		}
	}

	public static function selectCandidatesForOthersCategory($criteria, $limit, $code, $seedNumber) {
		$fieldsArr = explode("_", $criteria);
		$criteriaArr['category'] = $fieldsArr[0];
		$criteriaArr['gender'] = $fieldsArr[1] == 'MALE' ? 'm' : 'f';
		$criteriaArr['maritialStatus'] = (isset($fieldsArr[2]) && !empty($fieldsArr[2])) ? $fieldsArr[2] : '';

		switch($criteriaArr['category']) {
			case 'GENERAL':
				$sql = self::getQueriesForGeneralCandidates($criteriaArr, $limit);
			break;

			default:
				$sql = self::getQueriesForRestCandidates($criteriaArr, $limit);
			break;
		}

		$data = self::getDataFromQuery($sql, $code, $seedNumber);
		return $data;
	}

	public static function getQueriesForRestCandidates($criteriaArr, $limit) {
		if($criteriaArr['maritialStatus'] == '') {
			$sql = "SELECT * FROM candidate_list WHERE status = 0 AND selected = 0 AND ulbRegion = '".$_SESSION['ulb_region']."' AND category = '".$criteriaArr['category']."' ORDER BY RAND() LIMIT ".$limit;	
		} else {
			if($criteriaArr['maritialStatus'] == 'COMMON') {
				$sql = "SELECT * FROM candidate_list WHERE status = 0 AND selected = 0 AND ulbRegion = '".$_SESSION['ulb_region']."' AND gender = '".$criteriaArr['gender']."' AND category = '".$criteriaArr['category']."' ORDER BY RAND() LIMIT ".$limit;
			} else {
				$sql = "SELECT * FROM candidate_list WHERE status = 0 AND selected = 0 AND ulbRegion = '".$_SESSION['ulb_region']."' AND gender = '".$criteriaArr['gender']."' AND category = '".$criteriaArr['category']."' AND maritialStatus = '".$criteriaArr['maritialStatus']."' ORDER BY RAND() LIMIT ".$limit;
			}
		}
		return $sql;
	}

	public static function getQueriesForGeneralCandidates($criteriaArr, $limit) {
		if($criteriaArr['maritialStatus'] == '') {
			$sql = "SELECT * FROM candidate_list WHERE status = 0 AND selected = 0 AND ulbRegion = '".$_SESSION['ulb_region']."' ORDER BY RAND() LIMIT ".$limit;	
		} else {
			if($criteriaArr['maritialStatus'] == 'COMMON') {
				$sql = "SELECT * FROM candidate_list WHERE status = 0 AND selected = 0 AND ulbRegion = '".$_SESSION['ulb_region']."' AND gender = '".$criteriaArr['gender']."' ORDER BY RAND() LIMIT ".$limit;
			} else {
				$sql = "SELECT * FROM candidate_list WHERE status = 0 AND selected = 0 AND ulbRegion = '".$_SESSION['ulb_region']."' AND gender = '".$criteriaArr['gender']."' AND maritialStatus = '".$criteriaArr['maritialStatus']."' ORDER BY RAND() LIMIT ".$limit;
			}
		}
		return $sql;
	}

	public static function getDataFromQuery($sql, $code, $seedNumber) {
		$data = array();
		if($res = mysqli_query($GLOBALS['link'], $sql)) {
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					array_push($data, $row);
					$statusUpdated = self::updateStatusOfSelectedCandidates($row['id']);
					if($statusUpdated) {
						self::copySelectedCandidateData($row, $code, $seedNumber);
					}
				}
				self::lockSeedAndCode($code, $seedNumber);
			}
		}
		return $data;
	}

	public static function updateStatusOfSelectedCandidates($id) {
		$sql = "UPDATE candidate_list SET selected = 1 WHERE id= ".$id."";
		if(mysqli_query($GLOBALS['link'], $sql)) {
			return true;
		} else {
			echo "Error updating record: " . mysqli_error($GLOBALS['link']);
			return false;
		}
	}

	public static function copySelectedCandidateData($row, $code, $seedNumber) {
		$sql = "INSERT INTO selected_candidates (ulbRegion, name, receiptNumber, code, seedNumber) VALUES (?,?,?,?,?)";
		if($stmt = mysqli_prepare($GLOBALS['link'], $sql)){
			mysqli_stmt_bind_param($stmt, "sssss", $param_ulbRegion, $param_name, $param_receiptNumber, $param_code, $param_seedNumber);

			$param_ulbRegion = $row['ulbRegion'];
			$param_name = $row['name'];
			$param_receiptNumber = $row['receiptNumber'];
			$param_code = $code;
			$param_seedNumber = $seedNumber;

			if(mysqli_stmt_execute($stmt)){
				//
            } else {
            	echo "ERROR: Could not able to execute $sql. " . mysqli_error($GLOBALS['link']);
            }
		}
	}

	public static function lockSeedAndCode($code, $seedNumber) {
		$sql = "INSERT INTO lock_code_seed (ulbRegion, code, seedNumber) VALUES (?,?,?)";
		if($stmt = mysqli_prepare($GLOBALS['link'], $sql)) {
			mysqli_stmt_bind_param($stmt, "sss", $param_ulbRegion, $param_code, $param_seedNumber);
			$param_code = $code;
			$param_seedNumber = $seedNumber;
			$param_ulbRegion = $_SESSION['ulb_region'];
			if(mysqli_stmt_execute($stmt)) {
			} else {
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($GLOBALS['link']);
			}
		}
	}

	public static function confirmIPAddress($value) {
		$sql = "SELECT attempts, (CASE when lastlogin is not NULL and DATE_ADD(LastLogin, INTERVAL ".TIME_PERIOD." MINUTE)>NOW() then 1 else 0 end) as Denied FROM ".TBL_ATTEMPTS." WHERE ip = '$value'"; 

		$result = mysqli_query($GLOBALS['link'], $sql); 
	  	$data = mysqli_fetch_array($result); 

		//Verify that at least one login attempt is in database 
	  	if (!$data) { 
	    	return 0; 
	  	} 
	  	if ($data["attempts"] >= ATTEMPTS_NUMBER) { 
	    	if($data["Denied"] == 1) { 
	  			return 1; 
	    	} else { 
	  			self::clearLoginAttempts($value); 
	      		return 0; 
	    	} 
	  	} 
	  	return 0; 
	}

	public static function clearLoginAttempts($value) {
		$sql = "UPDATE ".TBL_ATTEMPTS." SET attempts = 0 WHERE ip = '$value'"; 
  		return mysqli_query($GLOBALS['link'], $sql);
	}

	public static function addLoginAttempt($value) {
		//Increase number of attempts. Set last login attempt if required.
		$sql = "SELECT * FROM ".TBL_ATTEMPTS." WHERE ip = '$value'"; 
   		$result = mysqli_query($GLOBALS['link'], $sql);
   		$data = mysqli_fetch_array($result);
   		if($data) {
 			$attempts = $data["attempts"]+1;         
     		if($attempts==3) {
   				$sql = "UPDATE ".TBL_ATTEMPTS." SET attempts=".$attempts.", lastlogin=NOW() WHERE ip = '$value'";
       			$result = mysqli_query($GLOBALS['link'], $sql);
     		} else {
   				$sql = "UPDATE ".TBL_ATTEMPTS." SET attempts=".$attempts." WHERE ip = '$value'";
       			$result = mysqli_query($GLOBALS['link'], $sql);
     		}
   		} else {
 			$sql = "INSERT INTO ".TBL_ATTEMPTS." (attempts,IP,lastlogin) values (1, '$value', NOW())";
     		$result = mysqli_query($GLOBALS['link'], $sql);
   		}
	}

	public static function getIPAddress() {
		$ip = $_SERVER['REMOTE_ADDR'] ? : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? : $_SERVER['HTTP_CLIENT_IP']);
		return $ip;
	}

	public static function getTextInHindi($text) {
		return $GLOBALS['lang'][$text];
	}

	public static function showalert($msg) {
	    echo '<script language="javascript">';
	    echo "alert('$msg')";
	    echo '</script>';
	}
}

?>
