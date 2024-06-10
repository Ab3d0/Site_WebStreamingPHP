
<?=validation_errors(); ?>
<main id="pageInscription">
<?=form_open('playlist/createPlaylist', ["class"=>"formInscription"])?>
	<h1>Créer une playlist</h1>

<div>
	<!-- Markup example 1: input is inside label -->
	<label for="name">
	Nom
	<input type="text" id="name" name="name" placeholder="Nom" value="<?=set_value('name')?>" required>
	</label>
  </div>
  <button type="submit">Submit</button>
</form>
</main>