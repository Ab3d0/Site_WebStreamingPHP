<?=validation_errors(); ?>
<main id="pageInscription">
<?=form_open('playlist/create_users', ["class"=>"formInscription"])?>

<h1 id="titreInscription">S'inscrire</h1>

<div>
<!-- Markup example 2: input is after label -->
<label for="mail">Adresse mail
<input type="email" id="mail" name="Email" placeholder="Email"  autocomplete="given-email" value="<?=set_value('mail')?>" required>
</label>

<label for="pwd">Password
<input type="password" id="pwd" name="Password" placeholder="Password"  autocomplete="given-pwd" value="<?=set_value('pwd')?>" required>
</label>


<label for="cpwd">Confirmation password
    <input type="password" id="cpwd" name="Cpwd" placeholder="Password"  autocomplete="given-cpwd" value="<?=set_value('cpwd')?>" required>
</label>

</div>

  <!-- Button -->
<button type="submit">Submit</button>

</form>

</main>