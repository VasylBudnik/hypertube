<?php

use App\Models\User;

function can_upload($file)
{
	if ($file['name'] == '') {
        return 'Вы не выбрали файл.';
    }
	if ($file['size'] > 900000) {
        return 'Файл слишком большой.';
    }
	$getMime = explode('.', $file['name']);
	$mime = strtolower(end($getMime));
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	if (!in_array($mime, $types)) {
        return 'Недопустимый тип файла.';
    }
	return true;
}

function make_upload($file, $userId)
{
	$n = "avatar";
	$foto = "foto";
	$name = $n.$_SESSION['userId'];
	$name2 = $foto.$_SESSION['userId']."_1";

	$structure = 'public/img/'."$userId";
	if (!is_dir($structure)) {
		if (!mkdir($structure, 0777, true)) {
			return 'Не удалось создать директории...';
		}
	}
	$fi = new FilesystemIterator($structure, FilesystemIterator::SKIP_DOTS);
	$fileCount = iterator_count($fi);

	if ($fileCount >= 1) {
		unlink($structure.$name);
		User::userDeleteFoto($name2.".png");
		return "DELL";
	} else {
		User::addFoto($name2, $userId, ($name2.'.png'));
		if (!copy($file['tmp_name'],  ROOT.'/public/img/'."$userId".'/'.$name2.'.png')) {
            return 'Не удалось сохранить фото!';
        }
		if (!copy($file['tmp_name'],  ROOT.'/public/img/avatar/'.$name.'.png')) {
            return 'Не удалось сохранить фото avatar!';
        }
	}
	return 'Файл успешно загружен';
}

$foto = User::userFoto($_SESSION['userId']);

function checkStatus($userid)
{
	if (User::notificationStatus($userid) == 1) {
		return 0;
	} else {
		return 1;
	}
}
