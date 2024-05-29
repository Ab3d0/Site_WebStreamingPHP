<article>
<header>
<nav>
  <ul>
	<li><strong>Music App</strong></li>
  </ul>
	<ul>
		<li><?=anchor("album",'Albums',['role'=>($choice=='album'?'button':'')])?></li>
		<li><?=anchor("artiste",'Artistes',['role'=>($choice=='artiste'?'button':'')])?></li>
		<li><?=anchor("playlist",'Playlists',['role'=>($choice=='playlist'?'button':'')])?></li>
	</ul>
</nav>

<nav>
	<ul>
		<li><?=anchor("artiste/addAllSong/$idArtist",'Ajouter toutes les chansons à une playlist')?></li>
	</ul>
</nav>



<section>
<?php
	foreach($songs as $song){
		echo "<article>";
			?>
			
			<?=anchor("album/view/$song->albumId","{$song->albumName}")?>
			<?php
			echo '<img src="data:image/jpeg;base64,'.base64_encode($song->coverJpeg).'" />';
			echo "<p>{$song->year}</p>";
			echo "<p>{$song->artistName}</p>";
			?>
			<?=anchor("playlist/addAlbum/$song->albumId","Ajouter l'album à une playlist")?>
			<?php
		echo "</article>";
	}

?>
</section>











  </article>