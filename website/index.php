<?php

require_once("include/html_functions.php");

?>

<?php our_header("home"); ?>


<div class="jumbotron">
  <h2>Welcome to <?php echo title(); ?></h2>
  <p>
    On <?php echo title(); ?>, you can share all your crazy pics with your friends. <br />
    But that's not all, you can also buy the rights to the high quality <br />
    version of someone's pictures. <?php echo title()?> is fun for the whole family.
  </p>
</div>

<div class="row">
  <div class="col-xs-2">
  </div>
  <div class="col-xs-4">
  <h3>New Here?</h3>
  <p>
    <h4><a href="/users/register.php">Create an account</a></h4>
  </p>
  <p>
    <h4><a href="/users/sample.php?userid=1">Check out a sample user!</a></h4>
  </p>
  <p>
    <h4><a href="/calendar.php">What is going on today?</a></h4>
  </p>
  </div>
  <div class="col-xs-4">
  <p>
    <h4>Or you can test to see if <?php echo title()?> can handle a file:</h4> <br />
    <form enctype="multipart/form-data" action="/piccheck.php" method="POST">
      <div class="form-group">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <label for="userfile">Check this file</label>
        <label id="userfile" class="btn btn-default btn-file">Browse<input name="userfile" type="file" style="display: none;"/></label> 
      </div>
      <div class="form-group">
        <label for="filename">With this name</label>
        <input id="filename" name="name" type="text" placeholder="mypic.jpg" /> 
        <br /> 
        <br />
      </div>
      <input type="submit" class="btn btn-default" value="Send File" />
      <br /> 
    </form>
  </script>
  </p>
  </div>
  <div class="col-xs-2">
  </div>
</div>


<?php our_footer(); ?>
