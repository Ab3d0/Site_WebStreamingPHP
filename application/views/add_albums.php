<article>
<header>


<?=validation_errors(); ?>
<?=form_open("playlist/addAlbum/$idAlbum")?>
  <!-- Grid -->
  	<div class="grid">

  	<label for="playlist-select">Choisissez la playlist</label>

	<select name="playlist" id="playlist-select">
		<?php
			foreach($playlists as $playlist){
				echo "<option value='$playlist->id'>$playlist->name</option>";
			}
		?>
	</select>
  	</div>
	<?php
		echo "<button type='submit' href='{playlist/addAlbum/$idAlbum}'>Submit</button>";
	?>
  
</form>






</article>