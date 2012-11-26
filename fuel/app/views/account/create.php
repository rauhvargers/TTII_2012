<?php
echo Form::open();
echo Form::fieldset_open(null, "Enter your data");
?>

<label for="usermail">E-mail (works as username)</label>
<input type="text" name="usermail" id="usermail" />

<label for="password">Password</label>
<input type="password" name="password" id="password" />

<label for="password_rep">Password (once again!)</label>
<input type="password" name="password_rep" id="password_rep" />

<input type="Submit" value="Register" class="btn btn-primary" />
<?php
echo Form::fieldset_close();
echo Form::close();

