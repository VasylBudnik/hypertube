<?php

namespace App\Models;

use App\Core\App;

class Auth {

	protected $db;

	public function __construct()
	{
		$this->db = App::get('database');
	}

	public static function checkLogged()
	{
		if (isset($_SESSION['userId'])) {
			return $_SESSION['userId'];
		} else {
            header("Location: /user/login");
        }
	}

	public static function activRegistration($hash_email)
	{
		$user = new self();
		$user->db->updateActiv($hash_email);
	}

    public static function activRegistration42($email)
    {
        $user = new self();
        $user->db->updateActiv42($email);
    }

	public static function login($user)
	{
		$_SESSION['userId'] = $user->id;
		$_SESSION['userName'] = $user->user_name;
	}


	public static function logout()
	{
		unset($_SESSION['userId']);
		unset($_SESSION['userName']);
	}

	public static function validatePassword($password)
    {
		if (strlen($password) >= 6 && strlen($password) <= 16) {
			if (preg_match("#^[a-zA-Z0-9_-]+$#", $password)) {
                return true;
            }
		}
		return false;
	}

	public static function checkName($name)
    {
		if (strlen($name) >= 5 && strlen($name) <= 18) {
			if (preg_match("#^[A-Z]{1,}[A-Za-z0-9_-]+$#", $name)) {
                return true;
            }
		}
		return false;
	}

	public static function checkEmail($email)
    {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			if (preg_match('/^([a-zA-Z0-9_-]+\.)*[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*\.[a-zA-Z]{2,6}$/', $email)) {
                return true;
            }
		}
		return false;
	}
	/*
	 * Check users input password
	 * @param User $user
	 * @param string $password
	 * @return bool
	 */
	public static function checkPassword(User $user, string $password) : bool
	{
		$password = hash('whirlpool', $password);

		if ($user->password !== $password) {
			return false;
		}
		return true;
	}

	public static function isEmailConfirm(User $user) : bool
	{
		if (intval($user->act_email) !== 1) {
			return false;
		}
		return true;
	}

	public static function restoreName(string $name)
    {
		$sql = new self();

		$response = $sql->db->selectOne('users', 'user_name', $name);
		if (!$response) {
			return false;
		}
		return true;
	}

	public static function restoreEmail(string $email)
    {
		$sql = new self();

		$response = $sql->db->selectOne('users', 'email', $email);
		if (!$response) {
			return false;
		}
		return true;
	}

	public static function restorePassword(string $password)
    {
		$sql = new self();
		$password = hash('whirlpool', $password);
		$response = $sql->db->selectOne('users', 'password', $password);
		if (!$response) {
			return false;
		}
		return true;
	}
}
