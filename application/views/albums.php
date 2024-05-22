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
	  	<li><?=anchor("album/?filter=all",'All',['role'=>($filter=='all'?'button':'')])?></li>
		<?php
			if(  isset($_GET['filter']) ){
				if( $_GET['filter'] == 'triaz'){
					$f_proch = 'triza';
					$f_actuel = 'triaz';
				} else if( $_GET["filter"] == 'triza'){
					$f_proch = 'triaz';
					$f_actuel = 'triza';
				} else {
					$f_proch = 'triaz';
					$f_actuel = 'triaz';
				}
			} else {
				$f_proch = 'triaz';
				$f_actuel = 'triaz';
			}
		?>
		<li><?=anchor("album/?filter=$f_proch","$f_proch",['role'=>($filter=="$f_actuel"?'button':'')])?></li>
  	</ul>
</nav>



<section>
<?php
	foreach($albums as $album){
		echo "<article>";
			?>
			
			<?=anchor("album/view/?numAlbum=$album->albumId","{$album->albumName}")?>
			<?php
			echo '<img src="data:image/jpeg;base64,'.base64_encode($album->coverJpeg).'" />';
			echo "<p>{$album->year}</p>";
			echo "<p>{$album->artistName}</p>";
		echo "</article>";
	}

?>
</section>











  </article>