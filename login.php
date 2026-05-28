<?php
$metaTitle = "Login | Amobic Homes";
$metaDescription = "Log in to your Amobic Homes account.";
require_once("header2.php");
?>

<section class="amobic-auth-section">
  <div class="amobic-auth-card">

    <div class="amobic-auth-header">
        <a href="index.php" class="amobic-auth-logo">
          <img src="assets/img/logo/amobic-logo-dark-full.png" alt="Amobic">
        </a>
      <h1>Log in</h1>
    </div>

    <form id="loginForm" method="post" class="amobic-auth-form">
      <div class="amobic-auth-group">
        <label>Email </label>
        <input type="text" name="email" placeholder="Enter email" required>
      </div>

       <div class="amobic-auth-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>
      </div>
      <input type="hidden" name="login-user" value="1">
      <div class="amobic-auth-row amobic-auth-between">
        <div class="amobic-auth-group amobic-auth-flex-row">
          <input type="checkbox" name="remember_me" id="rememberMe">
          <label for="rememberMe">Remember me</label>
        </div>
        <a href="#">Forgot password?</a>
      </div>
      <div id="alertMessage"></div>
      <input type="hidden" name="login-user" value="1">
      <button type="submit" id="submitBtn" class="amobic-auth-primary-btn">
        Continue
      </button>
    </form>
   <div class="amobic-auth-footer">
    <p>
     You dont have an account?
      <a href="signup.php">Sign up</a>
    </p>
  </div>
    <div class="amobic-auth-divider">
      <span>or</span>
    </div>

    <div class="amobic-social-login">
      <button type="button">
        <i class="bi bi-google"></i>
        Continue with Google
      </button>

      <button type="button">
        <i class="bi bi-apple"></i>
        Continue with Apple
      </button>
    </div>

    <p class="amobic-auth-policy">
      By continuing, you agree to Amobic’s
      <a href="#">Terms of Service</a> and
      <a href="#">Privacy Policy</a>.
    </p>

  </div>
</section>


<?php require_once("footer2.php"); ?>
