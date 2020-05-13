<?php require('partials/head.php'); ?>
<?php require('partials/downloadFoto.php'); ?>
    <script type="text/javascript" src="<?php echo BASE_URL ?>public/js/navigation.js"></script>
    <div id="error">
		<?php if (isset($errors) && !empty($errors)): ?>
            <ul>
				<?php foreach ($errors as $error): ?>
					<?php echo "<script>alert(\"$error\");</script>"; ?>
				<?php endforeach; ?>
            </ul>
		<?php endif; ?>
    </div>

    <center>    <div>
        <div id="tictactoe"></div>
        <div align="left">
            <span id='turn'>Player X</span>
        </div>
    </div>
    </center>
<div class="flex-cab">
<?php if ($_SESSION['lang'] == "rus"):  ?>
        <div class="change">
            <div class="passw">
                <form action="<?php echo BASE_URL?>personalArea/edit/" method="post">
                    <input class="edit_password" type="submit" value="Изменить пароль" />
                </form>
            </div>
            <div class="email">
                <form action="<?php echo BASE_URL?>personalArea/edit/email" method="post">
                    <input class="edit_password" type="submit" value="Изменить email" />
                </form>
            </div>
            <div class="notif">
                <form action="<?php echo BASE_URL?>personalArea/notifications" method="post">
                    <input class="<?php if(checkStatus($_SESSION['userId']) == 1) {echo "sendEmailActiv";} ?>" type="submit" value="Уведомления на email" />
                </form>
            </div>
            <div class="dell">
                <form action="<?php echo BASE_URL?>personalArea/delete/" method="post">
                    <input class="dell_acc" type="submit" value="Удалить аккаунт!" />
                </form>
            </div>
        </div>
    <div class="down_im">
        <form method="post" enctype="multipart/form-data">
            <input class="down_avatar" type="file" name="file" multiple accept="image/*">
            <input class="down_avatar2" id="down_av" type="submit" value="Загрузить фото!">
        </form>
<?php else: ?>
            <div class="change">
            <div class="passw">
                <form action="<?php echo BASE_URL?>personalArea/edit/" method="post">
                    <input class="edit_password" type="submit" value="Edit password" />
                </form>
            </div>
            <div class="email">
                <form action="<?php echo BASE_URL?>personalArea/edit/email" method="post">
                    <input class="edit_password" type="submit" value="Edit email" />
                </form>
            </div>
            <div class="notif">
                <form action="<?php echo BASE_URL?>personalArea/notifications" method="post">
                    <input class="<?php if(checkStatus($_SESSION['userId']) == 1) {echo "sendEmailActiv";} ?>" type="submit" value="Notifications on email" />
                </form>
            </div>
            <div class="dell">
                <form action="<?php echo BASE_URL?>personalArea/delete/" method="post">
                    <input class="dell_acc" type="submit" value="Delete accaunt!" />
                </form>
            </div>
        </div>
    <div class="down_im">
        <form method="post" enctype="multipart/form-data">
            <input class="down_avatar" type="file" name="file" multiple accept="image/*">
            <input class="down_avatar2" id="down_av" type="submit" value="Download foto!">
        </form>
            <?php endif; ?>
		<?php
		if(isset($_FILES['file'])) {
			$check = can_upload($_FILES['file']);
			if($check === true){
				$res =  make_upload($_FILES['file'], $_SESSION['userId'] );
				echo "<script>alert(\"$res!\");</script>";
			}
			else{
				echo "<script>alert(\"$check!\");</script>";
			}
		}
		?>
    </div>
</div>
    <center><h2 style="color: #ffa018">liked movie</h2></center>
    <div class="flex-container">
		<?php if (!empty($acaunt)): ?>
			<?php foreach ($acaunt as $acaunt_list): ?>
                <div class="flex-elem" style="margin-bottom: 16px; ">
                    <img class="foto-form"  src="<?php echo $acaunt_list['poster'] ?>">
                    <div class="name-form"><a><?php echo $acaunt_list['original_title'].', '.$acaunt_list['film_year']?></a></div>
                    <div class="city-form"><a><?php echo $acaunt_list['country']."\n"?></a></div>
                    <div class="rating-form"><a>&#9733 <?php echo $acaunt_list['imdbRating']?></a></div>
                    <div class="form-help">
                        <center>
                            <a id="id-user" user_id="<?php echo $acaunt_list['entity_id'] ?>" href="/pageMovie?id=<?php echo $acaunt_list['entity_id'] ?>" class="button"/>Go</a>
                        </center>
                    </div>
                </div>
			<?php endforeach; ?>
		<?php else: ?>
            <center><h3 style="color: #ffd77d; margin-top: 50px; margin-bottom: 20px">You haven’t liked anything yet!</h3></center>
		<?php endif; ?>
    </div>

<script type="text/javascript">
    /*
 * Tic Tac Toe
 *
 * A Tic Tac Toe game in HTML/JavaScript/CSS.
 *
 * @author: Vasanth Krishnamoorthy
 */
    var N_SIZE = 3,
        EMPTY = "&nbsp;",
        boxes = [],
        turn = "X",
        score,
        moves;

    /*
     * Initializes the Tic Tac Toe board and starts the game.
     */
    function init() {
        var board = document.createElement('table');
    board.setAttribute("border", 1);
    board.setAttribute("cellspacing", 0);
    
        var identifier = 1;
        for (var i = 0; i < N_SIZE; i++) {
            var row = document.createElement('tr');
            board.appendChild(row);
            for (var j = 0; j < N_SIZE; j++) {
        var cell = document.createElement('td');
        cell.setAttribute('height', 120);
        cell.setAttribute('width', 120);
        cell.setAttribute('align', 'center');
        cell.setAttribute('valign', 'center');
                cell.classList.add('col' + j,'row' + i);
                if (i == j) {
                    cell.classList.add('diagonal0');
                }
                if (j == N_SIZE - i - 1) {
                    cell.classList.add('diagonal1');
                }
                cell.identifier = identifier;
                cell.addEventListener("click", set);
                row.appendChild(cell);
                boxes.push(cell);
                identifier += identifier;
            }
        }

        document.getElementById("tictactoe").appendChild(board);
        startNewGame();
    }

    /*
     * New game
     */
    function startNewGame() {
        score = {
            "X": 0,
            "O": 0
        };
        moves = 0;
        turn = "X";
        boxes.forEach(function (square) {
            square.innerHTML = EMPTY;
        });
    }

    /*
     * Check if a win or not
     */
    function win(clicked) {
        // Get all cell classes
        var memberOf = clicked.className.split(/\s+/);
        for (var i = 0; i < memberOf.length; i++) {
            var testClass = '.' + memberOf[i];
      var items = contains('#tictactoe ' + testClass, turn);
            // winning condition: turn == N_SIZE
            if (items.length == N_SIZE) {
                return true;
            }
        }
        return false;
    }

function contains(selector, text) {
  var elements = document.querySelectorAll(selector);
  return [].filter.call(elements, function(element){
    return RegExp(text).test(element.textContent);
  });
}

    /*
     * Sets clicked square and also updates the turn.
     */
    function set() {
        if (this.innerHTML !== EMPTY) {
            return;
        }
        this.innerHTML = turn;
        moves += 1;
        score[turn] += this.identifier;
        if (win(this)) {
            alert('Winner: Player ' + turn);
            startNewGame();
        } else if (moves === N_SIZE * N_SIZE) {
            alert("Draw");
            startNewGame();
        } else {
            turn = turn === "X" ? "O" : "X";
            document.getElementById('turn').textContent = 'Player ' + turn;
        }
    }

    init();

</script>

