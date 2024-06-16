<article>
<header>



<?=validation_errors(); ?>
<main id="pageInscription">
<?=form_open("playlist/duplicate", ["class"=>"formInscription"])?>

<h1>Dupliquer une playlist</h1>

<div>
    <label for="name">
	Nom
	    <input type="text" id="name" name="name" placeholder="Nom" value="<?=set_value('name')?>" required>
	</label>
  	<label for="playlist-select">Choisissez la playlist</label>

	<select name="playlist" id="playlist-select">
		<?php
			foreach($playlists as $playlist){
				echo "<option value='$playlist->playlistId'>$playlist->playlistName</option>";
			}
		?>
	</select>
		</div>
	<?php
		echo "<button type='submit' href='{playlist/duplicate}'>Submit</button>";
	?>
  
</form>






</article>