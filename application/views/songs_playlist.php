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
        <li><?=anchor("playlist", "Ajouter une musique")?></li>
        <li><?=anchor("playlist", "Supprimer la playlist")?></li>
  	</ul>
</nav>

<section>
<?php
	foreach($songs as $song){
		echo "<li>";
            echo "$song->name <br/>";
            ?>
            <?=anchor("playlist", "Supprimer le son")?>
            <?php
		echo "</li>";
	}

?>
</section>


</article>