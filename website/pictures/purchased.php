<?php
require_once("../include/users.php");
require_once("../include/pictures.php");
require_once("../include/html_functions.php");
require_once("../include/functions.php");

session_start();

require_login();

$user = Users::current_user();
$pictures = Pictures::get_purchased_pictures($user['id']);

?>

<?php our_header(); ?>
<div class="container">
<div class="col-md-11">
<h3>You have purchased the following pictures: </h3>
   <?php thumbnail_pic_list($pictures, "/pictures/highquality.php?key=highquality&"); ?>
</div>
</div>

<?php our_footer(); ?>
