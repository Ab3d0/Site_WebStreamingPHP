<?=validation_errors(); ?>
<?=form_open('playlist/auth')?>
  <!-- Grid -->
  <div class="grid">

	<!-- Markup example 1: input is inside label -->
	<label for="email">
	Email
	<input type="email" id="email" name="email" placeholder="Email" value="<?=set_value('email')?>" required>
	</label>

	<label for="password">
	 Password 
	 <input type="password" id="password" name="password" placeholder="Password" value="<?=set_value('password')?>" required>
	</label>
  </div>
  <button type="submit">Submit</button>
</form>
<?=anchor("playlist/create_users","S'inscrire")?>