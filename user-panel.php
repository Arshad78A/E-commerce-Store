<?php require 'includes/header.php';
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }
$stmt=$pdo->prepare("SELECT * FROM users WHERE id=?"); $stmt->execute([$_SESSION['user_id']]); $u=$stmt->fetch();
$orders=$pdo->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC"); $orders->execute([$_SESSION['user_id']]); $myOrders=$orders->fetchAll();
?>
<h3>Welcome, <?= htmlspecialchars($u['name'])?>!</h3>
<div class="row">
<div class="col-md-4"><div class="card p-3"><p><b>Name:</b> <?= $u['name']?></p><p><b>Email:</b> <?= $u['email']?></p><p><b>Role:</b> <?= $u['role']?></p><p><b>Total Orders:</b> <?= count($myOrders)?></p><?php if($u['role']=='admin'):?><a href="admin/index.php" class="btn btn-warning w-100 mt-2">Admin Dashboard</a><?php endif;?></div></div>
<div class="col-md-8"><div class="card p-3"><h5>Recent Orders</h5><?php foreach(array_slice($myOrders,0,5) as $o):?><div class="d-flex justify-content-between border-bottom py-2"><span>Order #<?= $o['id']?> - <?= $o['status']?></span><b>Rs. <?= $o['total_amount']?></b></div><?php endforeach;?></div></div>
</div>
<?php require 'includes/footer.php';?>
