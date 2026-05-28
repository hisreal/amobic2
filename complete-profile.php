<?php
$metaTitle = "Complete Your Profile | Amobic Homes";
$metaDescription = "Complete your Amobic Homes profile to finish setting up your guest account.";
require_once("header2.php");
?>

<section class="amobic-auth-section">
  <div class="amobic-auth-card">

    <div class="amobic-auth-header">
      <a href="index.php" class="amobic-auth-logo">
        <img src="assets/img/logo/amobic-logo-dark-full.png" alt="Amobic">
      </a>

      <h1>Complete your profile</h1>
      <p>Add your name and create a password.</p>
    </div>

   <form method="post" autocomplete="off" id="profileForm" class="amobic-auth-form">
    
    <div class="amobic-auth-group">
    <label>Email</label>
    <input type="text" disabled="disabled" value="<?php echo $_SESSION['pending_email']; ?>">
  </div>

  <div class="amobic-auth-group">
    <label>First Name</label>
    <input type="text" name="first_name" placeholder="Enter your first name" required>
  </div>

 <div class="amobic-auth-group">
 <label>Last Name</label>
    <input type="text" name="last_name" placeholder="Enter your last name" required>
  </div>

 <div class="amobic-auth-group">
  <label>Phone Number</label>
    <input type="number" name="phone" placeholder="Enter your phone number" required>
  </div>

  <div class="amobic-auth-row">

    <div class="amobic-auth-group">
      <label>Gender</label>

      <select name="sex" required>
        <option value="">Select gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="prefer_not_to_say">Prefer not to say</option>
      </select>
    </div>

    <div class="amobic-auth-group">
      <label>Date of birth</label>
      <input type="date" name="dob" required>
    </div>

  </div>

  <div class="amobic-auth-group">
    <label>Password</label>

    <div class="amobic-password-field">
      <input type="password" name="password" id="password" placeholder="Create password" required>

      <button type="button" onclick="togglePassword('password', this)">
        <i class="bi bi-eye"></i>
      </button>
    </div>
  </div>

  <div class="amobic-auth-group">
    <label>Confirm password</label>

    <div class="amobic-password-field">
      <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm password" required>

      <button type="button" onclick="togglePassword('confirmPassword', this)">
        <i class="bi bi-eye"></i>
      </button>
    </div>
  </div>
<input type="hidden" name="save-user" value="1">
    <div id="alertMessage"></div>
  <button type="submit" id="submitBtn"  class="amobic-auth-primary-btn">
    Continue to Amobic
  </button>

</form>

  </div>
</section>





<?php require_once("footer2.php"); ?>
