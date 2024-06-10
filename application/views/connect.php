
<?=validation_errors(); ?>
<main id="pageInscription">
<?=form_open('playlist/auth', ["class"=>"formInscription"])?>

<h1 id="titreInscription">Se connecter</h1>


<div>
	<!-- Markup example 1: input is inside label -->
	<label for="mail">
	Email
	<input type="email" id="mail" name="Mail" placeholder="Email" autocomplete="given-email" value="<?=set_value('mail')?>" required>
	</label>

	<label for="pwd">
	 Password 
	 <input type="password" id="pwd" name="Pwd" placeholder="Password" autocomplete="given-pwd" value="<?=set_value('pwd')?>" required>
	</label>

</div>
  



  <button type="submit">Submit</button>
</form>

</main>