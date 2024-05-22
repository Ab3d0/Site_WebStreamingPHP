<article>
<header>
<nav>
  <ul>
	<li><strong>Music App</strong></li>
  </ul>
	<ul>
		<li><?=anchor("album/",'Albums',['role'=>($choice=='album'?'button':'')])?></li>
		<li><?=anchor("artiste/",'Artistes',['role'=>($choice=='artiste'?'button':'')])?></li>
		<li><?=anchor("playlist",'Playlists',['role'=>($choice=='playlist'?'button':'')])?></li>
	</ul>
</nav>

<nav>
	<ul>
		<li><?=anchor("playlist/createPlaylist",'Créer une playlist')?></li>
	</ul>
</nav>


<?php
	foreach($playlists as $playlist){
		echo "<article>";
			echo "<p>{$playlist->name}</p>";
		echo "</article>";
	}
?>





<section>
</section>











  </article>