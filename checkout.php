<?php require 'includes/header.php';
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }
if(empty($_SESSION['cart'])){ header("Location: index.php"); exit; }

if($_SERVER['REQUEST_METHOD']=='POST'){
  $name=$_POST['name']; $address=$_POST['address']; $phone=$_POST['phone'];
  $total=0;
  foreach($_SESSION['cart'] as $pid=>$qty){
    $s=$pdo->prepare("SELECT price FROM products WHERE id=?"); $s->execute([$pid]); $pr=$s->fetch();
    $total+= $pr['price']*$qty;
  }
  $pdo->prepare("INSERT INTO orders (user_id,total_amount,customer_name,address,phone) VALUES (?,?,?,?,?)")
      ->execute([$_SESSION['user_id'],$total,$name,$address,$phone]);
  $order_id=$pdo->lastInsertId();
  foreach($_SESSION['cart'] as $pid=>$qty){
    $s=$pdo->prepare("SELECT price FROM products WHERE id=?"); $s->execute([$pid]); $pr=$s->fetch();
    $pdo->prepare("INSERT INTO order_items (order_id,product_id,quantity,price) VALUES (?,?,?,?)")
        ->execute([$order_id,$pid,$qty,$pr['price']]);
  }
  $_SESSION['cart']=[];
  echo "<div class='alert alert-success'>Order placed! ID: $order_id</div>";
}
?>
<h3>Checkout</h3>
<form method="post" class="col-md-6">
  <input name="name" class="form-control mb-2" placeholder="Full Name" required>
  <textarea name="address" class="form-control mb-2" placeholder="Delivery Address" required></textarea>
  <input name="phone" class="form-control mb-2" placeholder="Phone Number" required>
  <button class="btn btn-primary">Place Order (COD)</button>
</form>
<?php require 'includes/footer.php'; ?>
