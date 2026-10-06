<?php require 'includes/header.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
  $name=$_POST['name']; $email=$_POST['email']; $pass=password_hash($_POST['password'], PASSWORD_DEFAULT);
  try{
    $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)")->execute([$name,$email,$pass]);
    echo "<div class='alert alert-success'>Registered! <a href='login.php'>Login now</a></div>";
  }catch(Exception $e){ echo "<div class='alert alert-danger'>Email already exists</div>"; }
}
?>
<h3>Register</h3>
<form method="post" class="col-md-4">
  <input name="name" class="form-control mb-2" placeholder="Name" required>
  <input name="email" type="email" class="form-control mb-2" placeholder="Email" required>
  <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
  <button class="btn btn-primary w-100">Register</button>
</form>
<?php require 'includes/footer.php'; ?>
