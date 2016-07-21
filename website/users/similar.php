<?php

require_once("../include/users.php");
require_once("../include/html_functions.php");
require_once("../include/functions.php");

session_start();
require_login();

$user = Users::current_user();

$similar_usernames = Users::similar_login($user['firstname'], True);

?>

<?php our_header() ; ?>

<div class="container">
<div class="col-md-11">
<h2> Users with similar names to you, <em><?=h( $user['firstname'] )?></em></h2>
<ul>
   <?php if ( $similar_usernames ) { ?>
   <?php foreach( $similar_usernames as $u ) { ?>

					       <li><a href="<?=h( Users::$VIEW_URL . "?userid=" . $u['id'] )?>"><?=h( $u['login'] ) ;?></a></li>

   <?php } ?>
   <?php }
    else { ?>

   <p> No one with a similar username. Lucky you! </p>

   <?php } ?>
</ul>
</div>
</div>

<?php our_footer() ; ?>
