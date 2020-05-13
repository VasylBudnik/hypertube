<?php

if (isset($_SESSION['userId'])) {
	$name = "avatar";
	$file = $name.$_SESSION['userId'].'.png';
	if (file_exists('public/img/avatar/' . $file)) {
		$avatar = $file;
	}
	else {
		$avatar = 'avatar.png';
	}
}
else {
	$avatar = 'avatar.png';
}
