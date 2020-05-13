<?php

namespace App\Controllers;

use App\Models\Chat;

class MassegeController {

	public $errors;

	public function __construct()
	{
		$this->errors = [];
	}

	public static function sendMassage()
    {
        try {
            $inputJSON = file_get_contents("php://input");
            try {
                $data = json_decode($inputJSON);
                $data = (array)$data;
                $text = $data['message'];
                $id = $data['id'];
                $text = htmlspecialchars($text);
                $id = intval(htmlentities($id));
            } catch (\Error $error) {
                reportLog($error);
            }
           	$chatID= 1;
            if (!Chat::insertMassegeDatabase($chatID, $id, $text, $_SESSION['userId'])) {
                echo "False";
            } else {
                echo "True";
            }
        } catch (\Exception $e) {
            reportLog($e->getMessage());
        }
	}

	public static function reloadMassage()
    {
        try {
            $id = json_decode($_POST['id']);
            $id = intval(htmlentities($id));
            if (intval($_SESSION['userId']) < $id) {
                $chatID = $_SESSION['userId'] . $id;
            } else {
                $chatID = $id . $_SESSION['userId'];
            }
            $chatID = 1;
            $massegeList = array();
            $massegeList = Chat::arrayMassege($chatID);
            $massegeList = array_reverse($massegeList);
            Chat::statusMassage($massegeList, $chatID, $id);
            $mass = array();
            foreach ($massegeList as $massege) {
                array_push($mass, $massege);
            }
            print json_encode($mass);
        } catch (\Exception $e) {
            reportLog($e->getMessage());
        }
	}

	public static function checkNewMassege()
    {
        try {
            $id = json_decode($_POST['id']);
            $id = intval(htmlentities($id));
            $arrChat = Chat::arrayChat($id);
            $arr = array();
            foreach($arrChat as $value) {
                array_push($arr, $value);
            }

            echo  json_encode($arr);
            return true;

        } catch (\Exception $e) {
            reportLog($e->getMessage());
        }
	}

	public function newMassegeChat()
    {
        try {
            $id = json_decode($_POST['chatid']);
            $chatID = intval(htmlentities($id));
            $massegeList = array();
            $massegeList = Chat::arrayMassege($chatID);
            $massegeList = array_reverse($massegeList);
            Chat::statusMassage($massegeList, $chatID, $id);
            $mass = array();
            foreach($massegeList as $massege) {
                array_push($mass, $massege);
            }
            print json_encode($mass);
        } catch (\Exception $e) {
            reportLog($e->getMessage());
        }
	}
}