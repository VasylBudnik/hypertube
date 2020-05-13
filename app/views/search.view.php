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
	<?php if (!empty($searchMovie)): ?>
	<?php foreach ($searchMovie as $searchMovie): ?>
    <div class="flex-elem" style="margin-bottom: 16px">
        <img class="foto-form"  src="<?php echo $searchMovie['poster'] ?>">
        <div class="name-form"><a><?php echo $searchMovie['original_title'].', '.$searchMovie['film_year']?></a></div>
        <div class="city-form"><a><?php echo $searchMovie['country']?></a></div>
        <div class="form-help">
            <center>
                <a id="id-user" user_id="<?php echo $searchMovie['entity_id'] ?>" href="/pageMovie?id=<?php echo $searchMovie['entity_id'] ?>" class="button"/>К фильму</a>
            </center>
        </div>
    </div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>