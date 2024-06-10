<article>
<header>

<div>
	<nav class="navigationFilter">
		<ul id="filterOptions">
			<li class="buttonMain"><?=anchor("artiste/addAllSong/$idArtist",'Ajouter toutes les chansons à une playlist')?></li>
		</ul>
	</nav>
</div>



<section class="listAlbums">
<?php
	foreach($songs as $song){
		echo "<article class='album'>";
			echo anchor("album/view/$song->albumId", "{$song->albumName}", ["class"=>'titreAlbum']);
			echo '<img src="data:image/jpeg;base64,'.base64_encode($song->coverJpeg).'" />';
			echo "<p class='titre_nameArtiste'>$song->year - $song->artistName</p>";
		echo "</article>";
	}

?>
</section>