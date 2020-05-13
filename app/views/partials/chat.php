
<div class="container">
    <img id="open" class="open" src="<?php echo BASE_URL?>public/img/Chat.png" title="Открыть чат">
</div>
<div class="backpopup"></div>
<div class="popup-window">
    <p class="close">x</p>
    <div class="shoutbox">
        <h1>Matcha chat</h1>
        <ul id="ma" class="shoutbox-content">
        </ul>
        <div class="shoutbox-form">
            <li><textarea class="none" id="userId" name="id"><?php echo $userId?></textarea></li>
            <li><textarea class="none" id="sesionId" name="sesionId"><?php echo $_SESSION['userId']?></textarea></li>
            </br>
            <li><textarea type="text" placeholder="Сообщение" id="shoutbox-comment" name="comment" maxlength='240' required="required"></textarea></li>
            <li id="error-message" style="width: 300px"></li>
            <li> <input id="submit-massage" type="submit" value="Отправить!"></li>
        </div>
        <div class="smiles" style="width: 350px">
            <?php $i = 0; $smile = 128512;  while($i <= 79){
                echo '<a class="sm">&#'.$smile.'</a>';
                $smile++;
                $i++;

            };?>
        </div>
        <div class="ramdom_massage">
            <a class="ramdom_female" id="link">Случайное сообщени для знакомства с девушкой</a>
            <BR>
            <a class="ramdom_male" id="link2">Случайное сообщени для знакомства с парнем</a>
        </div>
    </div>
</div>