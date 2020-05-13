<?php

namespace App\Models;

use App\Core\App;

class Dating
{

	protected $db;

	public function __construct()
	{
		$this->db = App::get('database');
	}

	public static function searchAge($a, $acaunt)
    {
		$age = explode("-", $a);
		$ageMin = ($age[0]);
		$ageMax = ($age[1]);
		foreach ($acaunt as $key => &$res) {
			if (($res['age']) >= $ageMin &&  $res['age'] <= $ageMax) {
				;
			} else {
				unset($acaunt[$key]);
			}
		}
		return $acaunt;
	}

	public  function searchBan($acaunt)
    {
        foreach($acaunt as $key => &$res) {
            if (strval($res['ban']) == 0) {
                ;
            } else {
                unset($acaunt[$key]);
            }
        }
        return $acaunt;
    }

	public static function searchGender($gender, $acaunt)
    {
		if ($gender == "Парня") {
			$gender = "male";
		} else {
			$gender = "female";
		}
		foreach($acaunt as $key => &$res) {
			if (strval($res['gender']) == strval($gender)) {
				;
			} else {
				unset($acaunt[$key]);
			}
		}
		return $acaunt;
	}

	public static function searchGlory($acaunt, $glory)
    {
		if ($glory == "★") {
			$glory = 1;
		} elseif (strval($glory) == "★ ★") {
			$glory = 2;
		} elseif (strval($glory) == "★ ★ ★") {
			$glory = 3;
		}
		foreach($acaunt as $key => &$acaunt_list) {
			if ((User::getGlory($acaunt_list['userId']) == $glory)) {
				;
			} else {
				unset($acaunt[$key]);
			}
		}
		return $acaunt;
	}

	public static function searchOrientation($orientation, $acaunt)
    {
		if ($orientation == "Гетеро") {
			$orientation = "heterosexual";
		} elseif($orientation == "Би") {
			$orientation = "bisexual";
		} else {
			$orientation = "LGBT";
		}
		foreach($acaunt as $key => &$acaunt_list) {
			if (strval($acaunt_list['orientation']) == strval($orientation)) {
				;
			} else {
				unset($acaunt[$key]);
			}
		}
		return $acaunt;
	}


	public static function searchIm($acaunt, $id)
    {
		foreach($acaunt as $key => &$acaunt_list) {
			if (strval($acaunt_list['userId']) != strval($id)) {
				;
			} else {
				unset($acaunt[$key]);
			}
		}
		return $acaunt;
	}

	public static function searchInterests($acaunt, $interests)
    {
		$i = 0;
		$j = 0;
		$sizeArray = count($acaunt);
		$interes = array_values($interests);
		$acaunt = array_values($acaunt);

		while ($i < $sizeArray) {
			$res = self::serchainteresting($acaunt[$i]['info'], $interes);
			if (($res == true)) {
				$j++;
			} else {
				unset($acaunt[$i]);
			}
			$i++;
		}
		return $acaunt;
	}

	private static function serchainteresting($arr1, $arr2)
	{
		$text = explode("#", $arr1);
		$new_array = array_diff($text, array(''));
		$text = array_values($new_array);
		$sizeArray1 = count($text);
		$sizeArray2 = count($arr2);
		$i = 0;
		while($i < $sizeArray1) {
			$j = 0;
			while($j < $sizeArray2) {
				$ar1 = trim($text[$i]);
				$ar2 = trim($arr2[$j]);
				if ($ar1 == $ar2) {
					return true;
				}
				$j++;
			}
			$i++;
		}
		return false;
	}

	public static function searchLocation($radius, $acaunt, $user_location)
    {
		if ($radius == "Без разницы") {
			return $acaunt;
		}

		$res = explode(" ", $radius);
		$radius = explode("-", $res[0]);
		$radiusMin = (float)($radius[0]);
		$radiusMax = (float)($radius[1]);
		$lon1 = (float)($user_location[0]);
		$lat1 = (float)($user_location[1]);
		$lat1 *= M_PI / 180;
		$lon1 *= M_PI / 180;

		foreach($acaunt as $key => &$acaunt_list) {
			$loc = explode(" ", $acaunt_list['location']);
			$lon2 = (float)($loc[0]);
			$lat2 = (float)($loc[1]);

			$lat2 *= M_PI / 180;
			$lon2 *= M_PI / 180;

			$d_lon = $lon1 - $lon2;
			$slat1 = sin($lat1);
			$slat2 = sin($lat2);
			$clat1 = cos($lat1);
			$clat2 = cos($lat2);
			$sdelt = sin($d_lon);
			$cdelt = cos($d_lon);

			$y = pow($clat2 * $sdelt, 2) + pow($clat1 * $slat2 - $slat1 * $clat2 * $cdelt, 2);

			$x = $slat1 * $slat2 + $clat1 * $clat2 * $cdelt;

			$metr = atan2(sqrt($y), $x) * 6372795;
			$km = round(($metr / 1000), 4);
		}
			if ($km >= $radiusMin &&  $km <= $radiusMax) {
				;
			} else {
				unset($acaunt[$key]);
			}

		return $acaunt;
	}

	public static function searchLiked($userId, $userLikeId)
    {
		$result = array();
		foreach($userLikeId as $key => &$list) {
			$id = User::LikedUserInfo($list);

			if (Dating::helpSearch($id, $userId) == 1) {
				array_push($result, $userLikeId[$key]);
			}
		}
		return $result;
	}

	private function helpSearch($id, $userId)
    {
		foreach($id as $key => &$user) {
		    if (strval($user) == strval($userId)) {
		        return 1;
		    }
		}
		return 0;
	}

	public static function viewLikedUser($id)
    {
		$sql = new self();
		$acaunt = $sql->db->selectAll('questionary');
		if (!$acaunt) {
			return null;
		}
		$i = 0;
		$j = 0;
		$sizeArray = count($acaunt);
		while ($i < $sizeArray) {
			if ($acaunt[$i]->id_user == $id[$j]) {
				$j++;
			} else {
				unset($acaunt[$i]);
			}
			$i++;
		}
		return $acaunt;
	}

	public static function userBanAdd($whoWasBanned)
    {
	    $sql = new self();
	    $table = "userban";
        $whoBanned = $_SESSION['userId'];
        $test = ("who_banned = ".$whoBanned." and who_was_banned = ".$whoWasBanned);
	    $response = $sql->db->selectAllParam($table, "*", "who_banned = ".$whoBanned." and who_was_banned = ".$whoWasBanned);
	    if (empty($response)) {
            $sql->db->insert('userban', [
                'who_banned' => $whoBanned,
                'who_was_banned' => $whoWasBanned,
            ]);
        }
    }

    public static function userBanDellete($whoWasBanned)
    {
        $sql = new self();
        $table = "userban";
        $whoBanned = $_SESSION['userId'];
        $response = $sql->db->selectAllParam($table, "*", "who_banned = ".$whoBanned." and who_was_banned = ".$whoWasBanned);
        if ($response){
        $param = "who_banned = ".$whoBanned." and who_was_banned = ".$whoWasBanned;
            $sql->db->deleteUniversal($table, $param);
        }
    }
}