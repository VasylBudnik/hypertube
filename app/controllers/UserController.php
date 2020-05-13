<?php

namespace App\Controllers;

use App\Models\Dating;
use App\Models\User;
use App\Models\Auth;


class UserController{

	public $errors;

	public function __construct()
	{
		$this->errors = [];
	}
	/*
	 * Logout user from app
	 * @return view index
	 */
	public function logout()
	{
		User::logout();

		return view("/");
	}

	public function deleteAccaunt()
    {
		if (!$_SESSION['userId']) {
			return redirect('personalArea');
		}
		$userName = $_SESSION['userName'];
		$user = User::userNameExists($userName);
		if ($user->admin != 1) {
			if (User::userDelete($user))

			redirect('');
		} else {
			echo "<script>alert(\"Админа удалить нельзя!\");</script>";
		}
		return view('personalArea');
	}

	public function actionInde()
	{
		$id = User::checkLogged();
		$user = User::getUserById($id);
	}
}
