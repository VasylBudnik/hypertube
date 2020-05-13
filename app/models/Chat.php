<?php

namespace App\Models;


use App\Core\App;

class Chat {

	protected $db;

	public function __construct()
	{
		$this->db = App::get('database');
	}

	public static function insertMassegeDatabase($chatId, $userId, $text, $myId)
    {
		$status = 0;
		$chatId = intval($chatId);
		$userId = intval($userId);
		$myId = intval($myId);
		$sql = new self();
		$response = $sql->db->insertMassage($chatId, $myId, $text, $status);
		return true;
	}

	public static function arrayMassege($chatId)
    {
		$sql = new self();
		$response = $sql->db->selectAll('massege');
		$com_arr  = array();
		$i = 0;
		while($response[$i])
        {
			if ($response[$i]->chat_id == $chatId) {
				$com_arr[$i]['id'] = $response[$i]->id;
				$com_arr[$i]['chat_id'] = $response[$i]->chat_id;
				$com_arr[$i]['user_id'] = $response[$i]->user_id;
				$com_arr[$i]['text'] = htmlspecialchars_decode($response[$i]->text);
				$com_arr[$i]['time'] = substr($response[$i]->time, 0,5);
				$com_arr[$i]['date'] = $response[$i]->date;
				$com_arr[$i]['status'] = $response[$i]->status;
			}
			$i++;
		}
		return ($com_arr);
	}

	public static function statusMassage($massegeList, $chatId, $userId)
    {
		$id = $massegeList[0]['id'];
		$sql = new self();
		$response = $sql->db->updateStatus($id, $chatId, $userId);
	}

	public static function alertEmail($id, $massage)
    {
		$sql = new self();
		$response = $sql->db->selectOne('users', 'id', $id);
		$email = $response->email;
		if ($response->notification == 1) {
			mail($email, "Новое действие", $massage);
		}
	}

	public static function arrayChat($id)
    {
		$sql = new self();
		$param = "user_id = ".$id;
		$response = $sql->db->selectAllParam('massege', 'chat_id', $param);
		$response = json_decode(json_encode($response),TRUE);
		$res = array();
		$i = 0;
		$sizeArray = count($response);
		while($i < $sizeArray) {
			$res[$i] = $response[$i]['chat_id'];
			$i++;
		}
		$res = array_values(array_unique($res));
		$j = 0;
		$countMassege = array();
		$sizeArray2 = count($res);
		while($j < $sizeArray2) {
			$countMassege[$j]['chat_id'] = $res[$j];
			$countMassege[$j]['count'] = Chat::countMassege($res[$j]);
			$j++;
		}
		return $countMassege;
	}

	public static function countMassege($chatId)
    {
		$sql = new self();
		$param = "user_id != ".$_SESSION['userId']." AND chat_id = ".$chatId ;
		$return = "chat_id";
		$response = $sql->db->selectAllParam('massege', $return, $param);
		$response = json_decode(json_encode($response),TRUE);
		return  count($response);
	}
}