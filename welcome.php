<?php
$metaTitle = "Welcome | Amobic Homes";
$metaDescription = "Welcome to Amobic Homes. Continue to your account or explore premium stays.";
require_once("header2.php");
?>

<section class="amobic-auth-section">
  <div class="amobic-auth-card text-center">
      <a href="index.php" class="amobic-auth-logo">
        <img src="assets/img/logo/amobic-logo-dark-full.png" alt="Amobic">
      </a>
      <br>

    <div class="amobic-success-icon">
      <i class="bi bi-check2"></i>
    </div>


    <p class="amobic-auth-success-text">
      Your account is ready. Start exploring curated Cape Town stays or partner with us.
    </p>

    <div class="amobic-welcome-actions">
      <a href="#" class="amobic-auth-primary-btn">
        Browse Properties
      </a>

      <a href="partner.php" class="amobic-auth-outline-btn">
        Become a Partner
      </a>
    </div>

  </div>
</section>

<?php require_once("footer2.php"); ?>
