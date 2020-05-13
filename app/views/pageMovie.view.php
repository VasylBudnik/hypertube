<?php require('partials/head.php');?>

<center>
    <H2 style="color: #ffd77d;">
		<?php echo $movie['production'].' - '  ; echo "\"".$movie['original_title']."\""?>
    </H2>
    <div><H3 style="color: #ffa018">Reting</H3>
    <span style="color: #ffa018">Imdb  &#9733 <?php echo " ".$movie['imdbRating']?></span>
    </div>
    <div>
        <H3 style="color: #ffa018">Actors</H3>
        <span style="color: #ffa018"><strong>Actors:</strong> <?php echo " ".$movie['actors']?></span>
    </div>
    <br>
</center>
<center>
    <div class="topnav" id="myTopnav">
        <a class="navbar-brand" href="#">
            <img class="poster"  src="<?php echo $movie['poster']?>" alt="profile picture"">
        </a>
    </div>
    <?php if ($statusLike == 1):  ?>
        <div><img class="like" src="<?php echo BASE_URL?>public/img/like_activ.png" alt=""> </div>
	<?php else: ?>
        <div><img class="like" src="<?php echo BASE_URL?>public/img/like.png" alt=""> </div>
	<?php endif; ?>

<div class="plot"><span style="color: white; padding-top: 25px"><?php echo $movie['plot']?></span></br><span style="color: #495c80">.</span></div>
    <form action="#" method="post">
        <div class="bottonStream">
            <input style="width: 90px" type="submit" name="submit"  class="stream" value="Stream" />
            <input style="width: 90px" type="submit" name="submit" class="download" value="Download" />
        </div>
    </form>
</center>

<div id="movie_result" style="color: white;"></div>

<div id="target">
</div>

<div id="main_body">
</div>
<div id="movie_result"></div>
<center>
<div class="comment_movie" >
    <div id="addComment">
        <textarea type="text" cols="22" rows="3"   id="comment" placeholder="Комментарий" class="textbox"></textarea>
        <br>
        <input type="submit" id="submit" value="Send" class="addComment" required/>
    </div>
    </center>
    <div id="cont">
		<?php $i = 0; foreach ($comm as $comment): ?>
                <div class="commentin">
                    <span class="name"><?php echo $comment['userid']."  :  " ?></span>
                    <span class="com" ><?php  echo $comment['comment_text']; $i += 1; ?></span>
                </div>
		<?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">

    jQuery(".stream").on("click", function (event) {
        event.preventDefault();
        let movieName = "<?php  echo $movie['original_title']?>";
        let movieYear = "<?php echo $movie['film_year']?>";
       downloadQuery(movieName + ' ' + movieYear);
    });

    function downloadQuery(movie, status = true) {
        var movieName = movie;
        var xhr = new XMLHttpRequest();

        if (status == true) {
            var address = "http://localhost:3000/startDownload/" + movieName;
        }
        else {
            var address = "http://localhost:3000/checkStatus";
        }

        xhr.open('GET', address, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText != 'failed' && xhr.responseText != 'Pending') {
                    var target = document.getElementById('target');
                    target.innerHTML = '<button id="startStream_button" value="' + xhr.responseText + '" onclick="startStreamQuery(this)">Start Stream</button></a>';
                    ready = true;
                }
                else if (xhr.responseText == 'failed') {
                    var target = document.getElementById('movie_result');
                    target.innerHTML = "<h2>" + xhr.responseText + "</h2>";
                }
                else {
                    var target = document.getElementById('movie_result');
                    target.innerHTML = "<h2>" + xhr.responseText + "</h2>";
                    downloadQuery(movieName, false);
                }
            }
        }

        xhr.send();
    }
    function startStreamQuery(button)
    {
        var movieName = button.value;

        var divMain = document.getElementById('main_body');
        var divSec = document.getElementById('movie_result');

        var result = '<video id="videoPlayer" controls>';
        result += '<source src="http://localhost:3001?movie='+ movieName +'" type="video/mp4">';
        result += '</video>';

        divMain.innerHTML = result;
        divSec.innerHTML = '<button id="refre" onclick="refreshPage()">Refresh</button>';
    }
</script>

<?php require('partials/footer.php'); ?>
