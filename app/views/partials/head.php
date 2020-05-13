<?php if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HYPERTUBE</title>
		<link href='https://fonts.googleapis.com/css?family=Averia+Sans+Libre' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo BASE_URL?>public/css/style.css">
        <link rel="stylesheet" href="<?php echo BASE_URL?>public/translate/css/style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>public/translate/js/google-translate.js"></script>
        <script src="//translate.google.com/translate_a/element.js?cb=TranslateInit"></script>


		<script type="text/javascript" src="<?php echo BASE_URL?>public/js/my.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>public/js/checkNewMassege.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>public/js/chat.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>public/js/accaunt.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>public/js/comment.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>public/js/movie.js"></script>


	</head>
	<body>
    <div class="language">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__ru.png" alt="ru" data-google-lang="ru" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__en.png" alt="en" data-google-lang="en" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__de.png" alt="de" data-google-lang="de" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__fr.png" alt="fr" data-google-lang="fr" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__pt.png" alt="pt" data-google-lang="pt" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__es.png" alt="es" data-google-lang="es" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__it.png" alt="it" data-google-lang="it" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__zh.png" alt="zh" data-google-lang="zh-CN" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__ar.png" alt="ar" data-google-lang="ar" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__nl.png" alt="nl" data-google-lang="nl" class="language__img">
        <img src="<?php echo BASE_URL?>public/translate/images/lang/lang__sv.png" alt="sv" data-google-lang="sv" class="language__img">
    </div>
		<?php require('avatar.php'); ?>
        <header>
            <select name="" id="input0" required="required" style="color: white; background:#1b1a17; width:75px; height: 25px; border-radius: 8px">
                <option  style="background: blue; border-radius: 25px" value="eng" <?php if($_SESSION['lang'] == 'en') echo "selected"; ?>>eng</option>
                <option  style="background: red" value="rus" <?php if($_SESSION['lang'] == 'rus') echo "selected"; ?>>rus</option>
            </select>
            <script>
                $('#input0').on("change", function(event) {
                    if($("select#input0 :selected").val() == "rus") {
                        $("select#input0").attr('style', 'background: red; width:75px; height: 25px; border-radius: 8px');
                    }
                    if($("select#input0 :selected").val() == "eng") {
                        $("select#input0").attr('style', 'background: blue; width:75px; height: 25px; border-radius: 8px');
                    }
                    var lang = $("select#input0 :selected").val();
                    if (lang !== "<?php echo $_SESSION['lang'] ?>") {
                        $.ajax({
                            url: 'lang',
                            data: {"lang" : lang},
                            type: "POST",
                            success: function (data) {
                                window.location.reload();
                            },
                            error: function (request, status, error) {
                                console.log("ERROR");
                            }
                        });
                    }
                });
            </script>
            <div class="flex-top">
                <div class="avatar">
                    <?php if ($avatar == "avatar.png"): ?>
                        <img class="avat" userId="<?php echo $_SESSION['userId'] ?>" src="https://source.unsplash.com/user/erondu" alt="">
					<?php else: ?>
                        <img class="avat" userId="<?php echo $_SESSION['userId'] ?>" src="<?php echo BASE_URL?>public/img/avatar/<?php echo $avatar ?>" alt="">
                    <?php endif; ?>
                </div>
            <?php if ($_SESSION['lang'] == "rus"):  ?>
                <?php if (isset($_SESSION['userId'])): ?>
                    <div>
                        <span style="padding-left: 5%;" class="com"> Приветствуем вас,</span> <span class="user"> <?php echo ' '.$_SESSION['userName'];?></span>
                    </div>
                <?php else: ?>
                    <div>
                        <span class="com">Приветствуем вас,</span> <span class="user">Гость!</span>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                 <?php if (isset($_SESSION['userId'])): ?>
                    <div>
                        <span style="padding-left: 5%;" class="com"> We greet you,</span> <span class="user"> <?php echo ' '.$_SESSION['userName'];?></span>
                    </div>
                <?php else: ?>
                    <div>
                        <span class="com">We greet you,</span> <span class="user">Rogue!</span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            </div>
            <br>
            <br>
<?php if ($_SESSION['lang'] == "rus"):  ?>
     <nav class="menu">
                <div class="openMenu" id="openMenu">MENU</div>
                <ul id="menu">
                    <li><a class="cntr" href="/">Главная</a></li>
                    <?php if ($_SESSION['userId']): ?>
                        <li><a class="cntr" href="/datingMovie">Поиск фильмов</a></li>
                        <li><a class="cntr" href="/logout">Выход</a></li>
                        <li><a class="cntr" href="/personalArea">Кабинет</a> </li>
                    <?php else: ?>
                        <li><a class="cntr" href="/login">Вход</a></li>
                        <li><a class="cntr" href="/register">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
    <?php else: ?>
       <nav class="menu">
                <div class="openMenu" id="openMenu">MENU</div>
                <ul id="menu">
                    <li><a class="cntr" href="/">Home</a></li>
                    <?php if ($_SESSION['userId']): ?>
                        <li><a class="cntr" href="/datingMovie">Search movie</a></li>
                        <li><a class="cntr" href="/logout">Exit</a></li>
                        <li><a class="cntr" href="/personalArea">Personal space</a> </li>
                    <?php else: ?>
                        <li><a class="cntr" href="/login">Entrance</a></li>
                        <li><a class="cntr" href="/register">Registration</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
     <?php endif; ?>
            <div class="test555">
                <?php if ($_SESSION['userId']): ?>
                    <?php require ROOT."/app/views/partials/global_chat.php" ?>
                <?php endif; ?>
                <a id="open-popUp" href="javascript:void(0);" style="z-index: 0"><img id="newMassege" class="open" title="Открыть чат" src="<?php echo BASE_URL?>public/img/Chat.png" /></a>
            </div>
            <nav class="not">
                <ul class="not">

                </ul>
            </nav>
        </header>