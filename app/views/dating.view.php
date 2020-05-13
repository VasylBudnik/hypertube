<?php require('partials/head.php'); ?>
<div id="error">
	<?php if (isset($errors) && !empty($errors)): ?>
        <ul>
			<?php foreach ($errors as $error): ?>
				<?php echo "<script>alert(\"$error\");</script>"; ?>
			<?php endforeach; ?>
        </ul>
	<?php endif; ?>
</div>
<br>
<div class="flex-container">
    <div class="flex-form">
       <center><div class="form_container">
        <?php if ($_SESSION['lang'] == "rus"):  ?>
            <form action="search" method="GET">
                <div><h2 style="color: #ececec">Поиск фильма</h2></div>
                <fieldset style="height: 180px">
                    <div class="search_row">
                        <div>
                            <label for="name">Имя фильма</label>
                            <input  name="name" type="text" value=""/>
                        </div>

                        <div>
                            <label class="seeking">От</label>
                            <select  class="gender" name="sort">
                                <option>A - Z</option>
                                <option>Z - A</option>
                            </select>
                        </div>
                        <div>
                            <label class="seeking">Год</label>
                            <select class="gender" name="year">
                                <?php foreach ($movieYears as $k => $year): ?>
                                <option value="<?php echo $year['film_year'] ?>"><?php echo $year['film_year'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div>
                            <label>Рейтинг</label>
                            <select class="imdb" name="imdb">
                                <?php foreach ($movieIMDB as $k => $imdb): ?>
                                    <option value="<?php echo $imdb['imdbRating'] ?>"><?php echo $imdb['imdbRating'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="top">
                            <input class="button2" type="submit" value="Найти" >
                    </div>
                </fieldset>
            </form>
<?php else: ?>
       <form action="search" method="GET">
                <div><h2 style="color: #ececec">Movie search</h2></div>
                <fieldset style="height: 180px">
                    <div class="search_row">

                        <div>
                            <label for="name">Film Name</label>
                            <input  name="name" type="text" value=""/>
                        </div>

                        <div>
                            <label class="seeking">Name</label>
                            <select  class="gender" name="sort">
                                <option>A - Z</option>
                                <option>Z - A</option>
                            </select>
                        </div>
                        <div>
                            <label class="seeking">Year</label>
                            <select class="gender" name="year">
                                <option value="">--</option>
                                <?php foreach ($movieYears as $k => $year): ?>
                                <option value="<?php echo $year['film_year'] ?>"><?php echo $year['film_year'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div>
                            <label>Rating</label>
                            <select class="imdb" name="imdb">
                                <option value="">--</option>
                                <?php foreach ($movieIMDB as $k => $imdb): ?>
                                    <option value="<?php echo $imdb['imdbRating'] ?>"><?php echo $imdb['imdbRating'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="top">
                            <input class="button2" type="submit" value="Search" >
                    </div>
                </fieldset>
            </form>

 <?php endif; ?>
           </div></center>
    </div>

	<?php if (!empty($acaunt)): ?>
	<?php foreach ($acaunt as $acaunt_list): ?>
        <?php if ($acaunt_list['statusViewed'] == 1):?>
            <div class="flex-elem2" style="margin-bottom: 16px;">
		<?php else: ?>
            <div class="flex-elem" style="margin-bottom: 16px; ">
		<?php endif; ?>
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
	<?php endif; ?>
</div>

<div class="pagination_centr">
    <?php echo $pag; ?>
</div>

