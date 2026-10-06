<?php require 'includes/header.php';
$id=$_GET['id']??0;
$stmt=$pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$p=$stmt->fetch();
if(!$p) die("Product not found");
$imgPath="uploads/".$p['image'];
$hasImg=!empty($p['image']) && file_exists($imgPath);
?>
<div class="row">
  <div class="col-md-6">
    <?php if($hasImg):?><img src="<?= $imgPath?>" class="img-fluid rounded border" style="max-height:500px;width:100%;object-fit:contain"><?php else:?><div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:400px">No Image</div><?php endif;?>
  </div>
  <div class="col-md-6">
    <h2><?= htmlspecialchars($p['name'])?></h2>
    <p><span class="badge bg-secondary"><?= $p['category']?></span></p>
    <p><?= htmlspecialchars($p['description'])?></p>
    <h3>Rs. <?= $p['price']?></h3>
    <form method="post" action="cart.php" class="mt-3">
      <input type="hidden" name="product_id" value="<?= $p['id']?>">
      <div class="d-flex gap-2"><input type="number" name="qty" value="1" min="1" class="form-control w-25"><button name="add_to_cart" class="btn btn-dark w-75">Add to Cart</button></div>
    </form>
  </div>
</div>
<?php require 'includes/footer.php';?>
