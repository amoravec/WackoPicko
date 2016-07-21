<?php
require_once("../include/html_functions.php");
require_once("../include/comments.php");
require_once("../include/users.php");
require_once("../include/functions.php");
require_once("../include/pictures.php");

session_start();

require_login();

$error = False;
$previewid = 0;
$pic = 0;
if (isset($_POST['text']) && isset($_POST['picid']))
{
   $cur = Users::current_user();
   if (!($previewid = Comments::add_preview($_POST['text'], $cur['id'], $_POST['picid'])))
   {      
      $error = True;
   }
   else
   {
      if (!($pic = Pictures::get_picture($_POST['picid'])))
      {
	 $error = True;
      }
      else
      {
	 $error = False;
      }
   }
}
else
{
   $error = True;
}


if ($error)
{
   if (isset($_POST['picid']))
   {
      http_redirect(".." . Pictures::$VIEW_PIC_URL . "?picid=" . $_POST['picid']);
   }
   else
   {
      error_404();
   }
}

?>

<?php our_header(); ?>

<div class="container">
<div class="col-md-12">

  <div class="row">
    <h3>A Preview of what your comment on <em><?=h( $pic['title'] )?></em> will look like </h3>
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


  <div class="row">
    <div class="col-md-11 col-offset-1">
      <div class="page-header">
        <h2>Comments</h2>
      </div>
      <div class="row">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4>Your Comment</h4>
          </div>
          <div class="panel-body">
            <blockquote class="blockquote" style="border-left: 0px;">
              <p><?=h( $_POST['text'] )?></p>
              <footer>
                by <a href="<?= Users::$VIEW_URL ?>?userid=<?=h( $cur['id'] )?>"><?=h( $cur['login'] ) ?></a>
              </footer>
            </blockquote>
            <form action="<?= Comments::$DELETE_PREVIEW_COMMENT_URL ?>" method="POST" style="display:inline">
              <input type="hidden" name="previewid" value="<?= h( $previewid ) ?>" />
              <input type="hidden" name="picid" value="<?= h( $_POST['picid'] ) ?>" />
              <button type="submit" class="btn btn-default">Cancel</button> 
           </form>
           <form action="<?= Comments::$ADD_COMMENT_URL; ?>" method="POST"style="display:inline">
             <input type="hidden" name="previewid" value="<?= h( $previewid ) ?>" />
             <input type="hidden" name="picid" value="<?= h( $_POST['picid'] ) ?>" />
             <button type="submit" class="btn btn-default">Create</button>
           </form>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>

<?php our_footer(); ?>
