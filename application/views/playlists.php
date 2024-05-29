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
		<li><?=anchor("playlist/createPlaylist",'Créer une playlist')?></li>
		<li><?=anchor("playlist/generatePlaylist",'Générer une playlist')?></li>
		<li><?=anchor("playlist/deconnect",'Se deconnecter')?></li>
	</ul>
</nav>


<?php
	foreach($playlists as $playlist){
		echo "<article>";
		?>
		<?=anchor("playlist/view/$playlist->id","$playlist->name")?>
		<?php
		echo "</article>";
	}
?>





<section>
</section>











  </article>