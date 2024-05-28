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
	  	<li><?=anchor("album/index/all",'All',['role'=>($filter=='all'?'button':'')])?></li>
		<li><?=anchor("album/index/tri","Trier",['role'=>($filter=="tri"?'button':'')])?></li>
  	</ul>
</nav>



<section>
<?php
	foreach($albums as $album){
		echo "<article>";
			?>
			
			<?=anchor("album/view/$album->albumId","{$album->albumName}")?>
			<?php
			echo '<div>';
			echo '<img src="data:image/jpeg;base64,'.base64_encode($album->coverJpeg).'" />';
			echo "</div>";
			echo "<p>{$album->year}</p>";
			echo "<p>{$album->artistName}</p>";
			?>
			<?=anchor("playlist/addAlbum/$album->albumId","Ajouter l'album à une playlist")?>
			<?php
			echo "</article>";
	}

?>
</section>











  </article>