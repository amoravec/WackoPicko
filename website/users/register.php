<?php

require_once("../include/users.php");
require_once("../include/html_functions.php");
require_once("../include/functions.php");

session_start();

$error = False;
if (isset($_POST['firstname']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['againpass']) && isset($_POST['lastname'])
    && $_POST['username'] && $_POST['password'] && $_POST['againpass'] && $_POST['firstname'] && $_POST['lastname'])
{
   if ($_POST['password'] != $_POST['againpass'])
   {
      $flash['error'] = "The passwords do not match. Try again";
      $error = True;
   }
   else if ($new_id = Users::create_user($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], False))
   {
      Users::login_user($new_id);
      http_redirect(Users::$HOME_URL);
   }
   else
   {
      if (mysql_errno() == 1062)
      {
	 $flash['error'] = "Username '{$_POST['username']}' is already in use.";
      }
      $error = True;
   }
}
else
{
   $flash['error'] = "All fields are required";
   $error = True;
}

if ($error)
{
   our_header();
   ?>

<div class="container" >
  <div class="col-md-11">
<h2> Register for an account!</h2>
<p>
Protect yourself from hackers and <a href="/passcheck.php">check your password strength</a>
</p>
<?php error_message() ?>

<form action="<?=h( $_SERVER['PHP_SELF'] )?>" method="POST">
<div class="form-group">
  <label for="username">Username:</label>
  <input type="text" id="username" class="form-control" name="username" placeholder="username" />
</div>
<div class="form-group">
  <label for="firstname">First Name :</label>
  <input type="text" id="firstname" class="form-control"name="firstname" placeholder="First" />
</div>
<div class="form-group">
  <label for="lastname">Last Name :</label>
  <input type="text" id="lastname" class="form-control"name="lastname" placeholder="Last"/>
</div>
<div class="form-group">
  <label for"password">Password :</label>
  <input type="password" id="password" class="form-control" name="password" />
</div>
<div class="form-group">
  <label for="againpass">Password again :</label>
  <input type="password" id="againpass" class="form-control" name="againpass" />
</div>
<div class="form-group">
  <button type="submit" class="btn btn-default">Create Account!</button>
</div>
</form>

  </div>
</div>

<?php
     our_footer();
}

?>
