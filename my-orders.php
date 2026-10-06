<?php require 'includes/header.php';
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }
$stmt=$pdo->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC");
$stmt->execute([$_SESSION['user_id']]);
?>
<h3>My Orders</h3>
<table class="table"><tr><th>ID</th><th>Total</th><th>Status</th><th>Date</th></tr>
<?php foreach($stmt->fetchAll() as $o): ?>
<tr><td>#<?= $o['id'] ?></td><td>Rs. <?= $o['total_amount'] ?></td><td><span class="badge bg-warning"><?= $o['status'] ?></span></td><td><?= $o['created_at'] ?></td></tr>
<?php endforeach; ?>
</table>
<?php require 'includes/footer.php'; ?>
