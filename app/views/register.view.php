<?php
    $loginurl42 = "https://api.intra.42.fr/oauth/authorize?client_id=dc14841b6be7e3e97f1085ffd114a28bc95f486c4a64f61a534f050887ba3714&redirect_uri=http%3A%2F%2Fhypertube.loc%2Fcallback%26response_type%3Dcode&response_type=code";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Regist</title>
	<link rel="stylesheet" href="<?php echo BASE_URL?>public/css/style_reg.css" media="all"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL?>public/js/navigation.js"></script>
</head>
<body>
	<div class="reg_but"><p><a href="/" ><img style="width: 60px; z-index: 1" src="<?php echo BASE_URL?>public/img/logo.png" alt="На главную"></a></p></div>
    <div id="reg_h1"><h1>Please register in the form</h1></div>
	<div class="regist">
		<div id="error">
			<?php if (isset($errors) && !empty($errors)): ?>
				<ul>
					<?php foreach ($errors as $error): ?>
                        <?php echo '<span class="errorMes">'.$error.'</span>';?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	<form method="post">
		<input type="text" title="Имя должно начинаться с большой буквы и быть не короче 6 символов" name="name" placeholder="First name" required="required" value="<?php echo $nameUser?>"/>
        <input type="text" title="Last name must be at least 5 characters" name="name_last" placeholder="Last name" required="required" value="<?php echo $nameLast?>"/>
		<input type="password" title="Пароль должен быть не короче 6 символов" name="password" placeholder="Password" required="required" value=""/>
		<input type="password" name="password2" placeholder="Re-enter Password" required="required" value=""/>
		<input type="email" name="email" placeholder="Enter email" required="required" value="<?php echo $email?>"/>
        <center><input style="width: 150px" type="submit" name="submit" class="btn1" value="Registration" />
            <div class="register42">
                <img  src="<?php echo BASE_URL?>public/img/logo42.png"?>
        <a href="<?php echo A42_LOGIN_URL ?>" class="twitter">
            <i class="fa fa-twitter fa-fw"></i>  Login in
        </a>
            </div>

            <div class="register42" style="background: rgb(255, 255, 255)">
                <img  src="<?php echo BASE_URL?>public/img/download.png" style="width: 50px;">
                <a href="<?php echo BASE_URL?>gitcallback?action=login" class="twitter" style="color: #1b1a17;">
                    <i class="fa fa-twitter fa-fw"></i>  Login in
                </a>
            </div>
        </center>
		</form>
</div>
</body>
</html>
