<?=validation_errors(); ?>
<?=form_open('playlist/createPlaylist')?>
  <!-- Grid -->
  <div class="grid">

	<!-- Markup example 1: input is inside label -->
	<label for="name">
	Nom
	<input type="text" id="name" name="name" placeholder="Nom" value="<?=set_value('name')?>" required>
	</label>
  </div>
  <button type="submit">Submit</button>
</form>