<?php
$loginurl42 = "https://api.intra.42.fr/oauth/authorize?client_id=dc14841b6be7e3e97f1085ffd114a28bc95f486c4a64f61a534f050887ba3714&redirect_uri=http%3A%2F%2Fhypertube.loc%2Fcallback%26response_type%3Dcode&response_type=code";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="<?php echo BASE_URL?>public/css/style_reg.css">
</head>
<body>
<div class="reg_but"><p><a href="/" ><img style="width: 60px"  src="<?php echo BASE_URL?>public/img/logo.png" alt="На главную"></a></p></div>
<div class="login">
    <H1>Entrance</H1>
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
        <input type="email" name="email" placeholder="Email" required="required" value="<?php echo $email?>">
		<input type="password" name="password" placeholder="Password" required="required">
		<center><input type="submit" name="submit" class="btn1" value="Go" />
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
<div>
	<form action="login/restore" method="post">
<!--        <div style="width: 100%"><input style="width: 250px; margin-left: 80%;" type="submit" value="Востановить забытый пароль"></div>-->
        <div style="width: 100%"><input style="width: 250px; margin-left: 80%;" type="submit" value="Recover Forgotten Password"></div>
	</form>
</div>
</body>

</html>
