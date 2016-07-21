<?php

require_once("../include/users.php");
require_once("../include/pictures.php");
require_once("../include/cart.php");
require_once("../include/html_functions.php");
require_once("../include/functions.php");


session_start();
require_login();

$user = Users::current_user();

$cart = Cart::get_cart($user['id']);

if ($cart)
{
   $items = Cart::cart_items($cart['id']);
   $coupons = Cart::cart_coupons($cart['id']);
}
our_header("cart");
?>


<div class="container">
  <div class="col-md-12">

  <h2>Welcome to your cart <?= h( $user['login'] ) ?></h2>
  <form action="<?=h( Cart::$ACTION_URL . '?action=delete' ); ?>" method="POST">
<?php if ($cart) { ?>
  <table class="table table-striped">
    <thead>
      <th>Pic name</th> <th>Sample Pic</th> <th>Price</th> <th>Delete?</th>
    </thead>
    <tbody>
    <?php foreach($items as $item) { ?>
    <tr>
      <td><?=h($item['title']); ?></td> <td><img src="../upload/<?=h( $item['filename'] );?>" alt="<?=h( $item['title'] );?>" height="<?=h( $item['height'] );?>" width="<?=h( $item['width'] );?>" /></td><td><?=h( $item['price'] );?> Tradebux</td> <td><input type="checkbox" value="<?=h( $item['picture_id'] );?>" name="pics[]" /> </td>
    </tr>
    <?php } ?>
    </tbody>
  </table>			         
  <?php if ($coupons) { ?>
  <table>
    <tr>
      <th>Coupon Code</th> <th>Coupon Amount</th>
    </tr>
    <?php foreach($coupons as $coupon) { ?>
    <tr>
      <td><?=h($coupon['code']) ?></td><td><?=h( 100.0 - $coupon['discount']) ?>% Off</td>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
  <button type="submit" class="btn btn-default">Remove Selected From Cart</button>
</form>
<form action="<?=h( Cart::$ACTION_URL . '?action=addcoupon' ) ?>" method="POST">
<div class="form-group">
  <label for="couponCode">Enter Coupon Code:</label>
  <input type="text" id="couponCode" name="couponcode" />
  <button type="submit" class="btn btn-default">Submit Coupon</button>
</div>
</form>

<a class="btn btn-default" href="<?=h( Cart::$CONFIRM_URL );?>">Continue to Confirmation</a>
<?php } 
else { ?>
<h2> You don't have a cart! </h2>
<p><a href="<?=h (Pictures::$RECENT_URL)?>">Go find some pictures!</a></p>
<?php } ?>

  </div>
</div>
<?php
our_footer();
?>

