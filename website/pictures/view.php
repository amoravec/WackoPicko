<?php

require_once("../include/pictures.php");
require_once("../include/comments.php");
require_once("../include/cart.php");
require_once("../include/html_functions.php");
require_once("../include/functions.php");

session_start();
require_login();

// load all the variables I'll need
$no_pic = False;
if (isset($_GET["picid"]))
{
   $pic = Pictures::get_picture($_GET["picid"]);
   if (!$pic)
   {
      $no_pic = True;
   }
   else
   {
      $comments = Comments::get_all_comments_picture($pic['id']);
      $related = Pictures::get_some_pictures_by_tag($pic['tag'], $pic['id'], 2);
      $same = Pictures::get_some_pictures_by_user($pic['user_id'], $pic['id'], 2);
   }
}
else
{
   $no_pic = True;
}

if ($no_pic)
{
   error_404();
}

?>

<?php our_header(); ?>

<div class="container" >
<div class="col-md-12">

<div class="container">
  <div class="row">
    <h2 id="image-title"><?=h( $pic['title'] )?></h2>
  </div>  
  <div class="row">
  <div class="col-md-6">
    <div class="row">
      <img id="image" src="../upload/<?=h( $pic['filename'] )?>.550.jpg" width="550" />
    </div> 
    <div class="row">
      <blockquote class="blockquote" style="border-left: 0px;">
       Uploaded on <?=h( date("F j, Y", $pic['created_on_unix']) )?>
       <footer>
       by <a href="<?= Users::$VIEW_URL ?>?userid=<?=h( $pic['user_id'] ) ?>"><?=h($pic['login']) ?></a>
       </footer>
       </blockquote>
   </div>
  </div>
  <div class="col-md-5">
   <div class="row">
      <h2>Buy</h2>
      <?=h( $pic['price'] )?> Tradebux
      <?php $usr = Users::current_user(); if ($usr['id'] != $pic['user_id']) { ?>
        <a href="<?=h( Cart::$ACTION_URL . '?action=add&picid=' . $pic['id'] );?>" class="btn btn-default">Add to Cart</a>
      <?php } ?>
   </div>

    <div class="row">
        <?php if ($related) { ?>                                          
        <div class="">
          <h2>Related</h2>
          <?php foreach ($related as $p) { ?>
            <div class="">
              <a href="<?=h( Pictures::$VIEW_PIC_URL . "?picid=" . $p['id'] ) ?>"><img src="/upload/<?=h($p['filename']) ?>.128.jpg" width="128" class="thumbnail"/></a>
              <p>by <a href="<?= Users::$VIEW_URL ?>?userid=<?=h( $p['user_id'] )?>"><?=h( $p['login'] )?></a></p>
            </div>
          <?php }?>
        <?php } ?>
        <?php if ($same) { ?>
           <div class="">
           <h2>Others by <a href="<?= Users::$VIEW_URL ?>?userid=<?=h( $pic['user_id'] )?>"><?=h($pic['login']) ?></a></h2>
           <?php foreach ($same as $pic) { ?>
             <div class="">
               <a href="<?=h( Pictures::$VIEW_PIC_URL . "?picid=" . $pic['id'] ) ?>"><img src="/upload/<?=h($pic['filename']) ?>" width="128" class="thumbnail"/></a>
             </div>
           <?php }?>
           </div>
        <?php } ?>
    </div>
  </div>
  </div>
 
  <div class="row">
    <div class="col-md-11 col-offset-1">
      <div class="page-header">
      <h2>Comments</h2>
      </div>
      <?php if ($comments) {
         foreach ($comments as $comment) {  ?>
          <blockquote style="border-left: 0px">
	  <p class=""><?= $comment['text'] ?></p>
	  <footer>
	  by <a href="<?= Users::$VIEW_URL ?>?userid=<?=h( $comment['user_id'] )?>"><?=h( $comment['login'] ) ?></a>
	  </footer>
          </blockquote>
      <?php }  
      } else  { 
      ?>	  
      <div class="row">
        <h4>No comments yet...</h4>
      </div>
      <?php } ?>
      <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Add your comment</h3>
        </div>
      <div class="panel-body">
        <form action="<?= Comments::$PREVIEW_COMMENT_URL ?>" method="POST">
          <textarea class="form-control" rows="5" style="width: 100%; resize: vertical;" id="comment-box" name="text"></textarea>
          <input type="hidden" name="picid" value="<?=h( $pic['id'] )?>"/>
          <br/>
          <button type="submit" class="btn btn-default">Preview</button>
          </form>       
      </div>
      </div>
      </div>
    </div>
  </div>
</div>
</div>	
</div>



<?php our_footer(); ?>
