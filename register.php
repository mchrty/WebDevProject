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
    <!-- Signup Form -->

    <div class="form signup">
      <div class="form-content">
        <header>Signup</header>
        <h5 class="reg-error" style="background: #f001; width: 100%; padding: 10px 12px">
          Passwords Do Not Match.
        </h5>
        <form class="reg-form" action="Auth/Auth.php?action=register" method="POST">
          <div class="field input-field">
            <input type="text" name="reg-firstname" placeholder="First Name" class="input" required />
          </div>

          <div class="field input-field">
            <input type="text" name="reg-lastname" placeholder="Last Name" class="input" required />
          </div>
          <div class="field input-field">
            <select name="reg-gender" style="
                  width: 100%;
                  height: 100%;
                  width: 100%;
                  border: none;
                  font-size: 16px;
                  font-weight: 400;
                  border-radius: 6px;
                  outline: none;
                  padding: 0 15px;
                  border: 1px solid#CACACA;
                " class="input">
              <option value="Male" selected>Male</option>
              <option value="Female">Female</option>
              <option value="Others">Others</option>
            </select>
          </div>
          <div class="field input-field">
            <input type="text" name="reg-address" placeholder="Address" class="input" required />
          </div>

          <div class="field input-field">
            <input type="email" name="reg-email" placeholder="Email" class="input" required />
          </div>

          <div class="field input-field">
            <input type="password" name="reg-password" placeholder="Create password" class="password" required />
          </div>

          <div class="field input-field">
            <input type="password" name="confirm-password" placeholder="Confirm password" class="password" required />
            <i class="bx bx-hide eye-icon"></i>
          </div>

          <div class="field button-field">
            <input class="sub reg-submit-btn" type="submit" id="registerBtn" name="submit" value="Register" />
          </div>
        </form>

        <div class="form-link">
          <span>Already have an account? <a href="login.php">Login</a></span>
        </div>
      </div>
    </div>
  </section>
  <script>
    const submitBtn = document.querySelector(".reg-submit-btn"),
      regForm = document.querySelector(".reg-form"),
      error = document.querySelector(".reg-error");

    submitBtn.addEventListener("click", (e) => {
      const passwords = regForm.querySelectorAll(".password"),
        inputs = regForm.querySelectorAll("input");
      if (passwords[0].value !== passwords[1].value) {
        inputs.forEach((inputField, index) => {
          if (index != inputs.length - 1) {
            inputField.value = "";
            error.classList.add("show");
          }
        });
        e.preventDefault();
      }
    });
  </script>
</body>

</html>