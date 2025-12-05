<?php
session_start();
$errorMsg = ""; // Initialize error message

if(isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']); // Consider switching to password_hash in production
  $sql ="SELECT EmailId,Password,FullName FROM tblusers WHERE EmailId=:email and Password=:password";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);

  if($query->rowCount() > 0) {
    $_SESSION['login'] = $_POST['email'];
    $_SESSION['fname'] = $results[0]->FullName;
    $currentpage = $_SERVER['REQUEST_URI'];
    echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
    exit();
  } else {
    $errorMsg = "Invalid email or password.";
  }
}
?>
<div class="modal fade" id="loginform" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h3 class="modal-title" id="loginModalLabel">Login</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="login_wrap">
            <div class="col-md-12 col-sm-6">

              <!-- Display error message if any -->
              <?php if(!empty($errorMsg)): ?>
                <div class="alert alert-danger text-center"><?php echo htmlentities($errorMsg); ?></div>
              <?php endif; ?>

              <!-- Login Form -->
              <form method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="Email address*" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password*" required>
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="remember">
                  <label for="remember">Remember me</label>
                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="Login" class="btn btn-block btn-primary">
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer text-center">
        <p>Don't have an account? <a href="#signupform" data-toggle="modal" data-dismiss="modal">Signup Here</a></p>
        <p><a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">Forgot Password?</a></p>
      </div>

    </div>
  </div>
</div>