<?php

namespace App\Models;

use App\Core\App;

class User {

	protected $db;

	/**
	 * User constructor.
	 * @throws \Exception
	 */
	public function __construct()
	{
		$this->db = App::get('database');
	}

	public  function register($name, $email, $password)
    {
        $admin = 0;
		$act_email = 0;
		$notification = 0;
		$hash_email = hash('whirlpool', $name);
		$password = hash('whirlpool', $password);

		$user = new self();
		$user->db->insert('users', [
			'user_name' => $name,
			'password' => $password,
			'admin' => $admin,
			'act_email' => $act_email,
			'email' => $email,
			'hash_email' => $hash_email,
			'notification' => $notification,
		]);

		mail($email, "Активация email на сайте Hypertube", 'Для активации вашей учетной записи '.$name.' 
				перейдите по этой ссылке '.BASE_URL.'register/verification?hash='.$hash_email);


	}

	public static function addFoto($name, $userId, $img)
    {
		$sql = new self();
		$sql->db->insert('photo', [
			'name' => $name,
			'user_id' => $userId,
			'img' => $img,
		]);
	}

	/*
	 * Get user by credentials
	 * @param string $email
	 * @param string $password
	 * @return User | null
	 */
	public static function getUserByEmail(string $email)
	{
		$user = new self();
		$response = $user->db->selectOne('users', 'email', $email);
		if (!$response) {
			return null;
		}
		foreach ($response as $key => $value) {
			$user->$key = $value;
		}
		return $user;
	}

	/*
	 *  Сheck name in the table
	 *  @param string $name
	 *  @return User | null
	 */
	public static function userNameExists(string $name)
	{
		$user = new self();
		$response = $user->db->selectOne('users', 'user_name', $name);
		if (!$response) {
			return null;
		}
		foreach ($response as $key => $value) {
			$user->$key = $value;
		}
		return $user;
	}

	public static function userFoto(string $id)
	{
	    $user = new self();
	    $response = $user->db->selectAll('photo');
	    if (!$response) {
	        return null;
	    }
	    $userFoto = array();
		$i = 0;
		while($response[$i]) {
		    if (intval($id) == intval($response[$i]->user_id)) {
		        $userFoto[$i]['id'] = $response[$i]->id;
		        $userFoto[$i]['user_id'] = $response[$i]->user_id;
		        $userFoto[$i]['img'] = $response[$i]->img;
		    }
		    $i++;
		}
		return($userFoto);
	}

	public static function nameUser($id)
    {
		$user = new self();
		$avtor = $user->db->selectOne('users', 'id', $id);

		return $avtor->user_name;
	}

	public static function auth($userId)
	{
		session_start();
		$_SESSION['userId'] = $userId;
	}

	public static function logout()
	{
		unset($_SESSION['userId']);
		unset($_SESSION['userName']);
	}

	public static function editPassword(string $id, string $name, string $password)
	{
		$sql = new self();
		$sql->db->updatePassword($id, $name, $password);
	}


	public static function checkLogged()
	{
		if (isset($_SESSION['userId'])) {
			return $_SESSION['userId'];
		} else {
            redirect('/');
        }
	}

	public static function isGuest()
    {
		if (isset($_SESSION['userId'])) {
			return (false);
		}
		return (true);
	}

	public static function userDelete($user) : bool
	{
		$id = $user->id;
		$sql = new self();

		Auth::logout();
		$sql->db->delete('users', $id);
		return true;
	}

	public static function userDeleteFoto($foto)
	{
		$id = intval($foto);
		$sql = new self();
		unlink('public/img/'.$_SESSION['userId'].'/'.$foto);
		$sql->db->delete_foto('photo', $foto);

		return true;
	}

	public static function idFotoUser($foto)
    {
		$foto_id = intval($foto);
		$sql = new self();
		$response = $sql->db->selectOne('foto', 'id', $foto);
		if (!$response) {
		   return null;
		 }
		return($response->user_id);
	}

    /*
     * Изменения статуса отправки
     * уведомления с сайта
     * Возвращаем true | false
     */
	public static function offNotifications(string $userId) : bool
    {
		$userId = intval($userId);
		$table = "users";
		$data = "notification";
		$status = User::notificationStatus($userId);
		$sql = new self();
		$response = $sql->db->update($table, $userId, [
			'notification' => $status,
			]);
		if (!$response) {
			return false;
		}
		return true;
	}

	public static function editEmail(string $userId, string $email2)
	{
		$userId = intval($userId);
		$table = "users";
		$data = "email";
		$sql = new self();
		$response = $sql->db->update($table, $userId, [
			'email' => $email2,
		]);
		if (!$response) {
			return false;
		}
		return true;
	}

	public static function notificationStatus(string $userId)
    {
		$userId = intval($userId);
		$sql = new self();
		$response = $sql->db->selectOne('users', 'id', $userId);
		$notification = $response->notification;
		if ($notification == 0) {
			return 1;
		}
		return 0;
	}
}
