<article>
<header>


<div>
	<nav class="navigationFilter">
		<ul id="filterOptions">
			<li><?=anchor("album", "Ajouter une musique")?></li>
        	<li><?=anchor("playlist/deletePlaylist/$playlist", "Supprimer la playlist")?></li>
		</ul>
	</nav>
</div>

<section id="artisteAlbum">
	<?php
		echo "<h1 id='pl'>";
		echo "$user"; 
		echo " - $nameP</h1>";
	?>
</section>



<section id="trackAlbum">
<?php
	$i = 1;
	foreach($songs as $song){
		echo "<article class='song'>";
			echo "<p class='trackNumber'>$i</p>";
			echo "<p class='trackName'>$song->name</p>";
			echo "<p class='trackDuration'>";
			echo gmdate("H:i:s", $song->duration); 
			echo "</p>";
			echo anchor("playlist/deleteSongOfPlaylist/$song->id?album=$playlist", "Supprimer le son", ["class"=>'trackAction']);
		echo "</article>";
		$i++;
	}

?>
</section>


</article>