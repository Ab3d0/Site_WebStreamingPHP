
<?=validation_errors(); ?>
<main id="pageInscription">
<?=form_open('playlist/generatePlaylist', ["class"=>"formInscription"])?>

<h1>Générer une playlist</h1>

  <div>
	<!-- Markup example 1: input is inside label -->
	<label for="nombre">
	Nombre de musique
	<input type="number" id="nombre" name="nombre" min="0" max="1000" placeholder="musique" value="<?=set_value('nombre')?>" required>
	</label>
    <label for="name">
	Nom
	<input type="text" id="name" name="name" placeholder="Nom" value="<?=set_value('name')?>" required>
	</label>
  </div>
  <button type="submit">Submit</button>
</form>

</main>