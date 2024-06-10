<article>
<header>


<div>
	<nav class="navigationFilter">
		<ul id="filterOptions">
			<li><?=anchor("playlist/createPlaylist",'Créer une playlist')?></li>
			<li><?=anchor("playlist/generatePlaylist",'Générer une playlist')?></li>
			<li><?=anchor("playlist/deconnect",'Se deconnecter')?></li>
		</ul>
	</nav>
</div>

<section id="listArtistes">
<?php
	foreach($playlists as $playlist){
		echo "<article class='artiste'>";
			echo "<p class='nbAlbumText'>nombres de musique</p>";
			echo "<p class='nbAlbum'>$playlist->songCount</p>";
			echo anchor("playlist/view/$playlist->playlistId", "{$playlist->playlistName}", ["class"=>'nameArtiste']);
		echo "</article>";
	}
?>
</section>