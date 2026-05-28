<?php
$metaTitle = "Verify Your Email | Amobic Homes";
$metaDescription = "Enter your Amobic Homes verification code to confirm your email address.";
require_once("header2.php");
?>

<section class="amobic-auth-section">
  <div class="amobic-auth-card">

    <div class="amobic-auth-header">
      <a href="index.php" class="amobic-auth-logo">
        <img src="assets/img/logo/amobic-logo-dark-full.png" alt="Amobic">
      </a>


      <h1>Confirm your code</h1>
      <p>Enter the 6 digit code sent to your email or phone.</p>
    </div>
   <form  method="post" class="amobic-auth-form" id="otpForm">

  <div class="amobic-code-inputs">

    <input type="text" name="digit1" maxlength="1" inputmode="numeric" >
    <input type="text" name="digit2" maxlength="1" inputmode="numeric" >
    <input type="text" name="digit3" maxlength="1" inputmode="numeric" >
    <input type="text" name="digit4" maxlength="1" inputmode="numeric" >
    <input type="text" name="digit5" maxlength="1" inputmode="numeric" >
    <input type="text" name="digit6" maxlength="1" inputmode="numeric" >

  </div>
  <input type="hidden" name="verify" value="1">
  <!-- Combined verification code -->
  <input type="hidden" name="verification_code" id="verificationCode">

    <div id="alertMessage"></div>
  <button type="submit" id="submitBtn" name="verify" class="amobic-auth-primary-btn">
    Verify and Continue
  </button>

</form>

    <p class="amobic-auth-policy">
      Did not get a code?
      <a href="#">Resend code</a>
    </p>

  </div>
</section>


<script>
        /* verification code input handling */

const inputs = document.querySelectorAll(".amobic-code-inputs input");
const form = document.getElementById("otpForm");
const hiddenCode = document.getElementById("verificationCode");


/* =========================================
   AUTO MOVE BETWEEN INPUTS
========================================= */

inputs.forEach((input, index) => {

  input.addEventListener("input", (e) => {

    /* Allow numbers only */
    input.value = input.value.replace(/[^0-9]/g, "");

    /* Move to next box */
    if (input.value && index < inputs.length - 1) {
      inputs[index + 1].focus();
    }
  });


  /* =========================================
     BACKSPACE NAVIGATION
  ========================================= */

  input.addEventListener("keydown", (e) => {

    if (e.key === "Backspace" && !input.value && index > 0) {
      inputs[index - 1].focus();
    }
  });


  /* =========================================
     PASTE FULL 6 DIGIT CODE
  ========================================= */

  input.addEventListener("paste", (e) => {

    e.preventDefault();

    const pastedData = e.clipboardData
      .getData("text")
      .replace(/\D/g, "")
      .slice(0, 6);

    if (pastedData.length === 6) {

      pastedData.split("").forEach((digit, i) => {

        if (inputs[i]) {
          inputs[i].value = digit;
        }
      });

      inputs[5].focus();
    }
  });
});


/* =========================================
   COMBINE ALL INPUTS BEFORE SUBMIT
========================================= */

form.addEventListener("submit", () => {

  let code = "";

  inputs.forEach(input => {
    code += input.value;
  });

  hiddenCode.value = code;
});
</script>
<?php require_once("footer2.php"); ?>
