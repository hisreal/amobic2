<?php require_once("header.php"); ?>


<div class="amobic-sidebar-overlay" id="sidebarOverlay"></div>

<main class="amobic-dashboard-main">

<div class="row justify-content-center">

<div class="col-lg-6">

  <section class="amobic-security-section">

    <div class="amobic-security-card">

      <div class="amobic-security-header">
        <h3>Password & Security</h3>
        <p>
          Manage your password and protect your account.
        </p>
      </div>

      <form action="update-password.php" method="post" class="amobic-security-form">

        <h4>Change Password</h4>

        <div class="amobic-security-group">
          <label>Current Password</label>
          <input type="password" name="current_password" required>
        </div>

        <div class="amobic-security-group">
          <label>New Password</label>
          <input type="password" name="new_password" required>
        </div>

        <div class="amobic-security-group">
          <label>Confirm New Password</label>
          <input type="password" name="confirm_password" required>
        </div>

        <button type="submit" name="change-password" class="ul-btn">
          Update Password
        </button>

      </form>


      <div class="amobic-two-factor-box">

        <div>
          <h4>Two Factor Authentication</h4>

          <p>
            Add an extra layer of security to your Amobic account.
          </p>
        </div>

        <label class="amobic-security-switch">
          <input type="checkbox" name="two_factor_enabled">
          <span></span>
        </label>

      </div>

    </div>

  </section>

</div>

</div>

</main>


<?php require_once("footer.php"); ?>