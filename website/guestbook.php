<?php

require_once("include/html_functions.php");
require_once("include/guestbook.php");

if (isset($_POST["name"]) && isset($_POST["comment"]))
{
   if ($_POST['name'] == "" || $_POST['comment'] == "")
   {
      $flash['error'] = "Must include both the name and comment field!";
   }
   else
   {
      $res = Guestbook::add_guestbook($_POST["name"], $_POST["comment"], False);
      if (!$res)
      {
	 die(mysql_error());
      }      
   }
}

$guestbook = Guestbook::get_all_guestbooks();
?>

<?php our_header("guestbook"); ?>

<div class="container-fluid">
<div class="col-md-11 col-md-offset-1">

<h2>Guestbook</h2>
<?php error_message(); ?>
<h4>See what people are saying about us!</h4>

<?php
   if ($guestbook)
   { 
     foreach ($guestbook as $guest)
     {
	?>
        <blockquote>
	<p class="comment"><?= $guest["comment"] ?></p>
	<footer> by <?=h( $guest["name"] ) ?> </footer>
        </blockquote>
	<?php
     } ?>
<?php
   }
?>

<form action="<?=h( Guestbook::$GUESTBOOK_URL )?>" method="POST">
  <div class="form-group">
    <label for="name">Username</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Username">
  </div>
  <div class="form-group">
    <label for="comment">Comment</label>
    <textarea id="comment-box" style="resize:vertical; width:100%" name="comment" class="form-control" placeholder="Comment">
    </textarea>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

</div>
</div>
<?php
   our_footer();
?>
