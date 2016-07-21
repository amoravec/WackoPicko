<?php
require_once("../include/pictures.php");
require_once("../include/comments.php");
require_once("../include/cart.php");
require_once("../include/html_functions.php");
require_once("../include/functions.php");

session_start();

if (!isset($_GET['query']))
{
   http_redirect("/error.php?msg=Error, need to provide a query to search");
}

$pictures = Pictures::get_all_pictures_by_tag($_GET['query']);

?>

<?php our_header("", $_GET['query']); ?>

<div class="container">
<div class="col-md-11">
  <h2>Pictures that are tagged as '<em><?= $_GET['query']  ?></em>'</h2>

   <?php thumbnail_pic_list($pictures); ?>

</div>
</div>


<?php our_footer(); ?>
