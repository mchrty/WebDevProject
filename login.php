<?php
session_start();
// ! Prevent access shortcut using link by header
if (isset($_SESSION['auth'])) {
  if ($_SESSION['role'] === 'admin') {
    header('Location: /WebdevProject/Admin/index.php');
  } else header('Location: /WebdevProject/User/index.php');
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login or Signup</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/login_regis.css" />

  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
  <a href="index.php" class="back"><i class="bx bx-arrow-back"></i></a>

  <section class="container forms">
    <!-- Sign In Form -->
    <div class="form login">
      <div class="form-content">
        <header>Login</header>
        <?php
        if (isset($_SESSION['popup-message'])) {
          echo '<h5 style="background: #f001; width: 100%; padding: 10px 12px;">' . $_SESSION["popup-message"] . '</h5>';
        } ?>
        <form action="Auth/Auth.php?action=login" method="POST">
          <div class="field input-field">
            <input type="email" name="login-email" placeholder="Email" class="input" required autofocus />
          </div>

          <div class="field input-field">
            <input type="password" name="login-password" placeholder="Password" class="password" required autofocus />
            <i class="bx bx-hide eye-icon"></i>
          </div>

          <div class="form-link">
            <a href="#" class="forgot-pass">Forgot password?</a>
          </div>

          <div class="field button-field">
            <input class="sub" type="submit" name="login" value="Login" />
          </div>
        </form>

        <div class="form-link">
          <span>Don't have an account? <a href="register.php">Signup</a></span>
        </div>
      </div>
    </div>
  </section>
</body>

</html>