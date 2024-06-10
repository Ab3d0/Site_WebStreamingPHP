<article>
<header>

<div>
	<nav class="navigationFilter">
		<ul id="filterOptions">
			<li class="buttonMain"><?=anchor("album/index/all",'All',['role'=>($filter=='all'?'button':'')])?></li>
			<li class="buttonMain"><?=anchor("album/index/tri","Trier",['role'=>($filter=="tri"?'button':'')])?></li>
		</ul>
		<ul id="searchOptions">
			<form action="">
				<input type="text" id="name-album" name="name" placeholder="Rechercher un album" autocomplete="given-name" value="<?=set_value('name')?>" required>
			</form>
			<form action="">
				<select name="genre" id="genre-select">
				<?php
					foreach($genres as $genre){
						echo "<option value='$genre->id'>$genre->name</option>";
					}
					echo "</select>";
					echo "<button type='submit' class='filterButton'>Rechercher un genre</button>";
				?>
			</form>
		<ul>
	</nav>
</div>

<section class="listAlbums">
<?php
	foreach($albums as $album){
		echo "<article class='album'>";
			echo anchor("album/view/$album->albumId", "{$album->albumName}", ["class"=>'titreAlbum']);
			echo '<img src="data:image/jpeg;base64,'.base64_encode($album->coverJpeg).'" />';
            echo "<p class='titre_nameArtiste'>$album->year - $album->artistName</p>";
			echo anchor("playlist/addAlbum/$album->albumId","Ajouter l'album à une playlist", ["class"=>'addAlbum']);
        echo "</article>";
	}
?>
</section>