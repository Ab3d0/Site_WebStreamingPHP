<article>
<header>
<nav>
  <ul>
	<li><strong>Music App</strong></li>
  </ul>
	<ul>
		<li><?=anchor("album/",'Albums',['role'=>($choice=='album'?'button':'')])?></li>
		<li><?=anchor("artiste/",'Artistes',['role'=>($choice=='artiste'?'button':'')])?></li>
		<li><?=anchor("playlist/",'Playlists',['role'=>($choice=='playlist'?'button':'')])?></li>
	</ul>
</nav>

<section>
<?php
    

	foreach($albums as $album){
		echo "<li>";
            echo "$album->songName";
		echo "</li>";
	}

?>
</section>


</article>