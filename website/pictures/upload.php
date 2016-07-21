<?php

require_once("../include/users.php");
require_once("../include/pictures.php");
require_once("../include/html_functions.php");
require_once("../include/functions.php");

session_start();
require_login();

$user = Users::current_user();

$file_uploaded = False;
if (isset($_POST['tag']) && isset($_POST['name']) && isset($_FILES['pic']) && isset($_POST['price']) && isset($_POST['title']))
{
   if ($_POST['tag'] == "" || $_POST['name'] == "" || $_POST['price'] == "" || $_POST['title'] == "")
   {
      $flash['error'] = "Must include all fields";
   }
   else
   {
      $_POST['name'] = str_replace("..", "", $_POST['name']);
      $_POST['name'] = str_replace(" ", "", $_POST['name']);
      $_POST['name'] = str_replace("/", "", $_POST['name']);
      if (!file_exists("../upload/{$_POST['tag']}/"))
      {
	 mkdir("../upload/{$_POST['tag']}", 0777, True);
      }
      $filename = "../upload/{$_POST['tag']}/{$_POST['name']}";
      $relfilename = "{$_POST['tag']}/{$_POST['name']}";
      if ($_POST['price'] < 0)
      {
	 $_POST['price'] = abs($_POST['price']);
      }
      if (file_exists($filename))
      {
	 $new_name = tempnam("../upload", $filename);
	 move_uploaded_file($_FILES['pic']['tmp_name'], $new_name);
	 $id = Pictures::add_conflict($filename, $new_name, $_POST['tag'], $_POST['title'], $_POST['price'], $user['id']);
	 http_redirect(Pictures::$CONFLICT_URL . "?conflictid={$id}");
      }
      else
      {
	 if (move_uploaded_file($_FILES['pic']['tmp_name'], $filename))
	 {
	    
	    if ($id = Pictures::create_picture($_POST['title'], 128, 128, $_POST['tag'], $relfilename, $_POST['price'], $user['id']))
	    {
	       $main = ".550.jpg";
	       $side = ".128.jpg";
	       $thumb= ".128_128.jpg";
	       Pictures::resize_image($filename, $filename . $main, 550, 10000000);
	       Pictures::resize_image($filename, $filename . $side, 128, 10000000);
	       Pictures::resize_image($filename, $filename . $thumb, 128, 128);
	       
	       http_redirect(Pictures::$VIEW_PIC_URL . "?picid={$id}");
	       $file_uploaded = True;
	    }
	    else
	    {
	       $flash['error'] = "Couldn't create your picture, something wrong with the database";
	    }
	 }
	 else
	 {
	    $flash['error'] = "Couldn't move picture";
	 }
      }
   }
}


if (!$file_uploaded)
{

   our_header("upload");
?>
<div class="container-fluid">
<div class="col-md-11 col-md-offset-1" >

<h2> Upload a Picture! </h2>
<?php error_message(); ?>

<form enctype="multipart/form-data" action="<?=h( $_SERVER['PHP_SELF'] )?>" method="POST">
  <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
  <div class="form-group">
    <label for="tag">Tag</label>
    <input type="text" class="form-control" id="tag" name="tag" placeholder="Tag">
    <p class="help-block">A tag used to categorize your photo.</p>
  </div>
  <div class="form-group">
    <label for="name">File Name</label>
    <input type="text" class="form-control" id="name" placeholder="mypic.jpg">
  </div>
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" placeholder="Title">
    <p class="help-block">A title to list your photo.</p>
  </div>
  <div class="form-group">
    <label for="price">Price</label>
    <input type="text" id="price" name="price" placeholder="1">
    <p class="help-block">The number of tradebux required for others to buy this photo.</p>
  </div>
  <div class="form-group">
    <label for="picLabel">File</label>
    <label id="picLabel" class="btn btn-default btn-file">
      Browse
      <input type="file" id="pic" name="pic" style="display: none;"/>
    </label>
  </div>
  <button type="submit" class="btn btn-default">Upload File</button>
</form>

</div>
</div>
<?php
    our_footer();
}
?>
