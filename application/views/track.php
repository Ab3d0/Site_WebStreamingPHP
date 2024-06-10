<article>
<header>


<section id="artisteAlbum">
	<?php
		echo "<h1>";
		echo anchor("artiste/view/$idArtiste", "$nomArtiste"); 
		echo " - $nomAlbum</h1>";
	?>
</section>



<section id="trackAlbum">
<?php
	foreach($albums as $album){
		echo "<article class='song'>";
			echo "<p class='trackNumber'>$album->number</p>";
			echo "<p class='trackName'>$album->songName</p>";
			echo "<p class='trackDuration'>";
			echo gmdate("H:i:s", $album->duration); 
			echo "</p>";
			echo anchor("playlist/addSong/$album->songId?album=$idAlbum",'Ajouter le son', ["class"=>'trackAction']);
		echo "</article>";
	}

?>
</section>