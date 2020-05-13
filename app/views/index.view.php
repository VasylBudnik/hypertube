<?php require('partials/head.php'); ?>
<div class="flex-conteiner">

    <center><h2 style="color: #ffa018">Last viewed movie</h2></center>
</div>

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
    <?php endif; ?>
</div>
<?php require('partials/footer.php'); ?>
