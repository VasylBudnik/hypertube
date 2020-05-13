<?php

use App\Models\User;

$userName = $_SESSION['userName'];

$userlike = User::userNameExists($userName);


