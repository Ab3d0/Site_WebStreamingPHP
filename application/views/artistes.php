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
<nav>
  	<ul>
	  	<li><?=anchor("artiste/index/all",'All',['role'=>($filter=='all'?'button':'')])?></li>
		<li><?=anchor("artiste/index/tri","Trier",['role'=>($filter=="tri"?'button':'')])?></li>
  	</ul>
</nav>



<section>
<?php
	foreach($artistes as $artiste){
		echo "<article>";
			echo "<p>nombres d'albums</p>";
			echo "<p>$artiste->nombre_albums</p>";
		?>
			
			<?=anchor("artiste/view/$artiste->id","{$artiste->name}")?>
			<?php



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