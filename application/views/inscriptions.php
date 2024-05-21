<?=validation_errors(); ?>
<?=form_open('playlist/create')?>
<!-- Markup example 2: input is after label -->
<label for="email">Adresse mail</label>
<input type="email" id="email" name="email" placeholder="Email" value="<?=set_value('email')?>" required>
<div class="grid">
	<label for="password">Password
	<input type="password" id="password" name="password" placeholder="Password" value="<?=set_value('password')?>" required>
</label>
<label for="password">Confirmation password
    <input type="password" id="cpassword" name="cpassword" placeholder="Password" value="<?=set_value('cpassword')?>" required>
</label>

</div>
  <!-- Button -->
  <button type="submit">Submit</button>

</form>