<?php
$metaTitle = "Create Account | Amobic Homes";
$metaDescription = "Create your Amobic Homes account to book premium stays and manage your guest profile.";
require_once("header2.php");
?>

<section class="amobic-auth-section">
  <div class="amobic-auth-card">

    <div class="amobic-auth-header">
     <a href="index.php" class="amobic-auth-logo">
        <img src="assets/img/logo/amobic-logo-dark-full.png" alt="Amobic">
      </a>

      <h1>Sign up </h1>
    </div>

    <form id="signup-form" method="post" class="amobic-auth-form">
    <input type="hidden" name="signup" value="1">
  <div class="amobic-auth-group">
    <label>Email Address</label>
    <input type="email" name="email" placeholder="Enter email address">
  </div>

  <div id="alertMessage" class="amobic-auth-alert"></div>

  <button type="submit" id="submitBtn" name="signup" class="amobic-auth-primary-btn">
    Continue
  </button>

</form>
   <div class="amobic-auth-footer">
    <p>
      Already have an account?
      <a href="login.php">Log in</a>
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
