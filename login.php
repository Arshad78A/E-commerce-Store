<?php require 'includes/header.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
  $stmt=$pdo->prepare("SELECT * FROM users WHERE email=?"); $stmt->execute([$_POST['email']]);
  $u=$stmt->fetch();
  if($u && password_verify($_POST['password'], $u['password'])){
    $_SESSION['user_id']=$u['id']; $_SESSION['role']=$u['role']; $_SESSION['name']=$u['name'];
    if($u['role']=='admin') header("Location: admin/index.php");
    else header("Location: index.php");
    exit;
  } else echo "<div class='alert alert-danger'>Invalid login</div>";
}
?>
<h3>Login</h3>
<p class="small">Admin: admin@shop.com / admin123</p>
<form method="post" class="col-md-4">
  <input name="email" type="email" class="form-control mb-2" placeholder="Email" required>
  <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
  <button class="btn btn-primary w-100">Login</button>
</form>
<?php require 'includes/footer.php'; ?>
