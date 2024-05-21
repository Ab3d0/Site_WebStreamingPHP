<article>
<header>
<nav>
  <ul>
	<li><strong>Music App</strong></li>
  </ul>
	<ul>
		<li><?=anchor("album/?choice=album",'Albums',['role'=>($choice=='album'?'button':'')])?></li>
		<li><?=anchor("artiste/?choice=artiste",'Artistes',['role'=>($choice=='artiste'?'button':'')])?></li>
		<li><?=anchor("playlist/?choice=playlist",'Playlists',['role'=>($choice=='playlist'?'button':'')])?></li>
	</ul>
</nav>
<nav>
  	<ul>
	  	<li><?=anchor("album/?choice=$choice&filter=all",'All',['role'=>($filter=='all'?'button':'')])?></li>
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
		<li><?=anchor("album/?choice=$choice&filter=$f_proch","$f_proch",['role'=>($filter=="$f_actuel"?'button':'')])?></li>
  	</ul>
</nav>



<section>
<?php
	foreach($albums as $album){
		echo "<article>";
			echo "<p>{$album->albumName}</p>";
			echo '<img src="data:image/jpeg;base64,'.base64_encode($album->coverJpeg).'" />';
			echo "<p>{$album->year}</p>";
			echo "<p>{$album->artistName}</p>";





		/* if ($todo->done){
			echo "<tr><td><s>{$todo->text}</s></td>";
			echo "<td class='action'>";
			echo anchor("todo/toggle/{$todo->id}", '<i class="fa fa-toggle-on"></i>');	
			echo anchor("todo/delete/{$todo->id}", '<i class="fa fa-trash-o"></i>');
			echo anchor("todo/edit/{$todo->id}", '<i class="fa fa-edit"></i>');
		} else {
			echo "<tr><td>{$todo->text}</td>";
			echo "<td class='action'>";
			echo anchor("todo/toggle/{$todo->id}", '<i class="fa fa-toggle-off"></i>');	
			echo anchor("todo/delete/{$todo->id}", '<i class="fa fa-trash-o"></i>');	
			echo anchor("todo/edit/{$todo->id}", '<i class="fa fa-edit"></i>');
		} */
		echo "</article>";
	}

?>
</section>











  </article>