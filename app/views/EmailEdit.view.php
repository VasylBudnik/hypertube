<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>editEmail</title>
	<link rel="stylesheet" href="<?php echo BASE_URL?>public/css/style_reg.css">
</head>
<body>
<div class="reg_but"><p><a href="/" ><img style="width: 60px" src="<?php echo BASE_URL?>public/img/logo.png" alt="На главную"></a></p></div>
<div class="login">
	<h1>Изменение email</h1>
	<?php if (isset($errors) && !empty($errors)): ?>
		<ul>
			<?php foreach ($errors as $error): ?>
                <?php echo '<span class="errorMes">'.$error.'</span>';?>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<form method="post">
        <input type="email" name="email" placeholder="Введите старый email" required="required" value=""/>
		<input type="password" name="password" placeholder="Введите пароль" required="required" value=""/>
		<input type="email" name="email1" placeholder="Введите новый email" required="required" value=""/>
		<input type="email" name="email2" placeholder="Введите email ещё раз" required="required" value=""/>
        <center><input style="width: 150px" type="submit" name="submit" class="btn1" value="Сохранить" /></center>
	</form>
</div>
</body>
</html>