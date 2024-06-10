<article>
<header>
<div>
	<nav class="navigationFilter">
		<ul id="filterOptions">
			<li class="buttonMain"><?=anchor("artiste/index/all",'All',['role'=>($filter=='all'?'button':'')])?></li>
			<li class="buttonMain"><?=anchor("artiste/index/tri","Trier",['role'=>($filter=="tri"?'button':'')])?></li>
		</ul>
		<ul id="searchOptions">
			<form action="">
				<input type="text" id="name-artiste" name="name" placeholder="Rechercher un artiste" autocomplete="given-name" value="<?=set_value('name')?>" required>
			</form>
		<ul>
	</nav>
</div>



<section id="listArtistes">
<?php
	foreach($artistes as $artiste){
		echo "<article class='artiste'>";
			echo "<p class='nbAlbumText'>nombres d'albums</p>";
			echo "<p class='nbAlbum'>$artiste->nombre_albums</p>";
			echo anchor("artiste/view/$artiste->id", "{$artiste->name}", ["class"=>'nameArtiste']);
		echo "</article>";
	}

?>
</section>
