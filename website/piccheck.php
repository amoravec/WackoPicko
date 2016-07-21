<?php
require_once("include/html_functions.php");
require_once("include/functions.php");

if (!isset($_FILES['userfile']) && !isset($_POST['name']))
{
   http_redirect("/");
}


$type = $_FILES['userfile']['type'];
$name = $_POST['name'];

?>

<?php our_header("home"); ?>


<div class="container">
  <div class="col-md-11">

  <h3>Checking your file <em><?= $name ?></em></h3>
  <p>
    File is O.K. to upload!
  </p>
  </div>
</div>


<?php our_footer(); ?>
