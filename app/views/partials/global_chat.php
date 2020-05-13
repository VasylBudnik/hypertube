<div class="global-chat" id="global-chat" style="display: none">
    <div class="backpopup"></div>
    <div class="popup-window">
        <p class="close">x</p>
        <div class="shoutbox">
            <center><span style="font-size: 28px; color: #ececec">Global chat</span></center>
            <ul id="ma" class="shoutbox-content">
            </ul>
            <div class="shoutbox-form">
                <li><textarea class="none" id="userId" name="id"></textarea></li>
                <li><textarea class="none" id="sesionId" name="sesionId"></textarea></li>
                <li><textarea type="text" placeholder="Сообщение" id="shoutbox-comment" name="comment" maxlength='240' required="required"></textarea></li>
                <li id="error-message" style="width: 300px"></li>
                <li> <input id="submit-massage" type="submit" value="Отправить!"/></li>
            </div>
            <div class="smiles" style="width: 350px">
                <?php $i = 0; $smile = 128512;  while($i <= 79){
                    echo '<a class="sm">&#'.$smile.'</a>';
                    $smile++;
                    $i++;

                };?>
            </div>
        </div>
    </div>
</div>