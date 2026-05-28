<?php
$submittedCode = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $submittedCode = $_POST["verification_code"] ?? "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>OTP Test | Amobic Homes</title>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f5f7f0;
    }

    .amobic-auth-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
    }

    .amobic-auth-card {
      width: 100%;
      max-width: 430px;
      background: #fff;
      padding: 35px;
      border-radius: 22px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    }

    .amobic-auth-header {
      text-align: center;
      margin-bottom: 28px;
    }

    .amobic-auth-header h1 {
      margin: 0;
      font-size: 28px;
      color: #1f2a1f;
    }

    .amobic-auth-header p {
      color: #666;
      font-size: 15px;
    }

    .amobic-auth-form {
      display: flex;
      flex-direction: column;
      gap: 22px;
    }

    .amobic-code-inputs {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .amobic-code-inputs input {
      width: 50px;
      height: 55px;
      border: 1px solid #ddd;
      border-radius: 12px;
      text-align: center;
      font-size: 22px;
      font-weight: 700;
      outline: none;
    }

    .amobic-code-inputs input:focus {
      border-color: #6B7F4A;
      box-shadow: 0 0 0 4px rgba(107, 127, 74, 0.12);
    }

    .amobic-auth-primary-btn {
      height: 54px;
      border: none;
      border-radius: 14px;
      background: #6B7F4A;
      color: #fff;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
    }

    .amobic-auth-primary-btn:hover {
      background: #55663a;
    }

    .result-box {
      margin-bottom: 20px;
      padding: 14px;
      background: #eef4e6;
      border: 1px solid #cbd8bc;
      border-radius: 12px;
      color: #31421f;
      font-weight: 700;
      text-align: center;
    }
  </style>
</head>

<body>

<section class="amobic-auth-section">
  <div class="amobic-auth-card">

    <div class="amobic-auth-header">
      <h1>Verify Code</h1>
      <p>Enter the 6 digit code sent to your email</p>
    </div>

    <?php if (!empty($submittedCode)): ?>
      <div class="result-box">
        Submitted Code: <?php echo htmlspecialchars($submittedCode); ?>
      </div>
    <?php endif; ?>

    <form action="" method="post" class="amobic-auth-form" id="otpForm">

      <div class="amobic-code-inputs">
        <input type="text" maxlength="1" inputmode="numeric" required>
        <input type="text" maxlength="1" inputmode="numeric" required>
        <input type="text" maxlength="1" inputmode="numeric" required>
        <input type="text" maxlength="1" inputmode="numeric" required>
        <input type="text" maxlength="1" inputmode="numeric" required>
        <input type="text" maxlength="1" inputmode="numeric" required>
      </div>

      <input type="hidden" name="verification_code" id="verificationCode">

      <button type="submit" class="amobic-auth-primary-btn">
        Verify and Continue
      </button>

    </form>

  </div>
</section>


<script>
document.addEventListener("DOMContentLoaded", function () {

  const form = document.getElementById("otpForm");
  const hiddenCode = document.getElementById("verificationCode");
  const inputs = document.querySelectorAll(".amobic-code-inputs input");

  inputs[0].focus();

  inputs.forEach((input, index) => {

    input.addEventListener("input", function () {
      this.value = this.value.replace(/[^0-9]/g, "");

      if (this.value && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });

    input.addEventListener("keydown", function (e) {
      if (e.key === "Backspace" && !this.value && index > 0) {
        inputs[index - 1].focus();
      }
    });

    input.addEventListener("paste", function (e) {
      e.preventDefault();

      const pastedCode = e.clipboardData
        .getData("text")
        .replace(/\D/g, "")
        .slice(0, 6);

      pastedCode.split("").forEach((digit, i) => {
        if (inputs[i]) {
          inputs[i].value = digit;
        }
      });

      if (pastedCode.length > 0) {
        const nextIndex = Math.min(pastedCode.length, inputs.length) - 1;
        inputs[nextIndex].focus();
      }
    });

  });

  form.addEventListener("submit", function (e) {
    let code = "";

    inputs.forEach(input => {
      code += input.value;
    });

    if (code.length !== 6) {
      e.preventDefault();
      alert("Please enter the complete 6 digit code");
      return;
    }

    hiddenCode.value = code;
  });

});
</script>

</body>
</html>
