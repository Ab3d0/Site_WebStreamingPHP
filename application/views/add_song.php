<article>
<header>

<?=validation_errors(); ?>
<main id="pageInscription">
<?=form_open("playlist/addSong/$idSong?album=$idAlbum", ["class"=>"formInscription"])?>

<h1>Ajouter une chanson</h1>

<div>
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
		echo "<button type='submit'>Submit</button>";
	?>
  
</form>
</article>
		</main>