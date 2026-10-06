<?php require 'includes/header.php';
$cat = $_GET['cat'] ?? 'All';
if($cat!='All'){
  $stmt=$pdo->prepare("SELECT * FROM products WHERE category=? ORDER BY id DESC");
  $stmt->execute([$cat]);
} else {
  $stmt=$pdo->query("SELECT * FROM products ORDER BY id DESC");
}
$products=$stmt->fetchAll();
$cats=$pdo->query("SELECT DISTINCT category FROM products")->fetchAll();
?>
<h3>All Products</h3>
<div class="mb-3">
<a href="?cat=All" class="btn btn-sm <?= $cat=='All'?'btn-dark':'btn-outline-dark'?>">All</a>
<?php foreach($cats as $c):?>
<a href="?cat=<?= urlencode($c['category'])?>" class="btn btn-sm <?= $cat==$c['category']?'btn-dark':'btn-outline-dark'?>"><?= $c['category']?></a>
<?php endforeach;?>
</div>
<div class="row">
<?php foreach($products as $p): 
  $imgPath = "uploads/".$p['image'];
  $hasImg = !empty($p['image']) && file_exists($imgPath);
?>
  <div class="col-md-4 mb-4">
    <div class="card h-100">
      <?php if($hasImg):?>
        <img src="<?= $imgPath?>" class="product-img card-img-top">
      <?php else:?>
        <div class="product-img bg-light d-flex align-items-center justify-content-center text-muted"><small>No Image<br><?= $p['category']?></small></div>
      <?php endif;?>
      <div class="card-body">
        <h5><?= htmlspecialchars($p['name'])?></h5>
        <p class="small text-muted"><?= htmlspecialchars(substr($p['description'],0,60))?>...</p>
        <p><span class="badge bg-secondary"><?= $p['category']?></span></p>
        <h6>Rs. <?= $p['price']?></h6>
        <div class="d-flex gap-2">
          <a href="product.php?id=<?= $p['id']?>" class="btn btn-outline-dark btn-sm w-50">View</a>
          <form method="post" action="cart.php" class="w-50"><input type="hidden" name="product_id" value="<?= $p['id']?>"><input type="hidden" name="qty" value="1"><button name="add_to_cart" class="btn btn-dark btn-sm w-100">Add to Cart</button></form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach;?>
</div>
<?php require 'includes/footer.php';?>
