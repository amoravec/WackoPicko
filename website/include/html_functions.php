<?php

require_once("users.php");
require_once("functions.php");
session_start();

function our_header($selected = "", $search_terms = "")
{
   
   ?>
<html>
  <head>
    <link rel="stylesheet" href="/css/blueprint/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="/css/blueprint/print.css" type="text/css" media="print"> 
    <!--[if IE]><link rel="stylesheet" href="/css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
    <link rel="stylesheet" href="/css/stylings.css" type="text/css" media="screen">

    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="/css/bootstrap-theme.css" type="text/css">
    <link rel="stylesheet" href="/css/justified-nav.css" type="text/css">

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>    
    <script src="/js/bootstrap.js"></script>

    <title><?php echo title()?></title>
  </head>
  <body style="padding-bottom: 70px">
    <div class="container" >
      <div class="masthead">
        <div class="row">
          <div class="col-md-1">&nbsp;</div>
          <div class="col-md-10">
            <h1 class="text-muted"><?php echo title()?></h1>
          </div>
	</div>
        <nav>
           <ul class="nav nav-justified">
	    <li class="<?php if($selected == "home"){ echo 'active'; } ?>"><a href="/users/home.php"><span>Home</span></a></li>
	    <li class="<?php if($selected == "upload"){ echo 'active'; } ?>"><a href="/pictures/upload.php"><span>Upload</span></a></li>
	    <li class="<?php if($selected == "recent"){ echo 'active'; } ?>"><a href="/pictures/recent.php"><span>Recent</span></a></li>
            <li class="<?php if($selected == "guestbook"){ echo 'active'; } ?>"><a href="/guestbook.php"><span>Guestbook</span></a></li>
            <?php if (Users::is_logged_in()) { ?><li class="<?php if($selected == "cart"){ echo 'active'; } ?>"><a href="/cart/review.php"><span>Cart</span></a></li> <?php } ?>
            <?php if (Users::is_logged_in()){ ?>
            <li><a href="/users/logout.php"><Span>Logout</span></a></li>
      <?php } else { ?>
            <li><a href="/users/login.php"><Span>Login</span></a></li>
      <?php } ?>
            <li style="min-width: 220px">
               <form class="navbar-form form-inline" action="/pictures/search.php" method="get">
        	 <div class="input-group">
                   <input id="query2" name="query" type="text" class="form-control" placeholder="Search" value="<?=h($search_terms) ?>"/>
                 </div>
                 <button type="submit" class="btn btn-default">Submit</button>
               </form>
            </li>
          </ul>
        </nav>

      </div>
      
      
      
   <?php
}

function error_message()
{
   global $flash;
   if ($flash['error'])
   {
      ?>
<p class="span-10 error">
	 <?= h($flash['error']) ?>
</p>

      <?
   }
}

function our_footer()
{
   ?>
       <div>
	<nav class="navbar navbar-default navbar-fixed-bottom">
          <div class="container">
          <ul class="nav navbar-nav">
	  <li><a href="/">Home</a></li>
          <li><a href="/admin/index.php?page=login">Admin</a></li>
	  <li><a href="/tos.php">Terms of Service</a></li>
          </ul>
	</div>
      </nav>
    </div>
  </body>
</html>  
   <?php

}

function thumbnail_pic_list($pictures, $link_to = False)
{
   if (!$link_to)
   {
      $link_to = Pictures::$VIEW_PIC_URL."?";
   }
   ?>
<div class="container-fluid">
<div class="row">
      <?php if ($pictures) { ?>
<?php

   for ($i = 0; $i < count($pictures); $i++)
   {
      $pic = $pictures[$i];
      if ($i != 0 && (($i % 6) == 0))
      {
	 ?>
</div>
<div class="row">
	 <?php
      }

?>
<div class="col-md-2">
<a href="<?=h( $link_to . "picid=" . $pic['id'] ) ?>">
<img src="/upload/<?=h( $pic['filename']) ?>.128_128.jpg" class="thumbnail" height="128" width="128" />
</a>
</div>
<?php

   }
?>
<?php }
   else { ?>
<h3 class="error">No pictures here...</h3>


<?php } ?>
</div>
<?php
}

function high_quality_item_link($item)
{
   $name = h($_SERVER['SERVER_NAME']);
   $link = "http://{$name}/pictures/highquality.php?picid={$item['id']}&key=highquality";
   return "<a href='{$link}'>{$link}</a>"; 
}

function title() {
   return "PhotoPlan";
}


?>
