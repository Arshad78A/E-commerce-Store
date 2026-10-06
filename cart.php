<?php require 'includes/header.php';
if(isset($_POST['add_to_cart'])){
  $pid=$_POST['product_id']; $qty=$_POST['qty'];
  $_SESSION['cart'][$pid]=($_SESSION['cart'][$pid]??0)+$qty;
  header("Location: cart.php"); exit;
}
if(isset($_GET['remove'])){
  unset($_SESSION['cart'][$_GET['remove']]);
  header("Location: cart.php"); exit;
}
$cart=$_SESSION['cart']??[];
?>
<h3>Your Cart (<?= count($cart)?> items)</h3>
<?php if(empty($cart)):?>
  <p>Cart is empty. <a href="index.php">Shop now</a></p>
<?php else:?>
<table class="table align-middle">
<tr><th>Image</th><th>Product</th><th>Price</th><th>Qty</th><th>Total</th><th></th></tr>
<?php $total=0; foreach($cart as $pid=>$qty):
  $stmt=$pdo->prepare("SELECT * FROM products WHERE id=?"); $stmt->execute([$pid]); $p=$stmt->fetch();
  if(!$p) continue;
  $sub=$p['price']*$qty; $total+=$sub;
  $imgPath="uploads/".$p['image']; $hasImg=!empty($p['image']) && file_exists($imgPath);
?>
<tr>
  <td><?php if($hasImg):?><img src="<?= $imgPath?>" class="cart-img"><?php else:?><div class="cart-img bg-light d-flex align-items-center justify-content-center"><small><?= $p['category']?></small></div><?php endif;?></td>
  <td><b><?= htmlspecialchars($p['name'])?></b><br><small class="text-muted"><?= $p['category']?></small></td>
  <td>Rs. <?= $p['price']?></td>
  <td><?= $qty?></td>
  <td><b>Rs. <?= $sub?></b></td>
  <td><a href="?remove=<?= $pid?>" class="btn btn-sm btn-danger">X</a></td>
</tr>
<?php endforeach;?>
<tr><th colspan="4">Grand Total</th><th>Rs. <?= $total?></th><th></th></tr>
</table>
<a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
<a href="index.php" class="btn btn-outline-dark">Continue Shopping</a>
<?php endif;?>
<?php require 'includes/footer.php';?>
