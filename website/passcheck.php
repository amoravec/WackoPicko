<?php

require_once("include/html_functions.php");
$checked = false;
$ret = 0;
if (isset($_POST['password']))
{
   // check the password strength
   $pass = $_POST['password'];
   $command = "grep ^$pass$ /etc/dictionaries-common/words";
   exec($command, $output, $ret);   
   $checked = true;
}

?>

<?php our_header("home"); ?>


<div class="container">
  <div class="col-md-11">

<h3>Check your password strength</h3>
<?php if ($checked) { ?>
<p>
The command "<?= h($command) ?>" was used to check if the password was in the dictionary.<br /> 
<?= h( $pass ) ?> is a 
<?php if ($ret == 1) { ?>
    Good							       
<?php }
else { ?>
    Bad
<?php } ?>
Password
</p>
<?php }
?>
<form action="<?=h( $_SERVER['PHP_SELF'] )?>" method="POST">
  <div class="form-group">
    <label for="password">Password to check:</label> 
    <input type="password" id="password" name="password" class="form-control" /><br>
    <button type="submit" class="btn btn-default">Check!</button>
  </div>
</form>


  </div>
</div>


<?php our_footer(); ?>
