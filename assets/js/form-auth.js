$(document).ready(function () {

  function handleAjaxForm(formId, url, buttonText = "Continue") {

    $(formId).on("submit", function (e) {
      e.preventDefault();

      const form = $(this);
      const alertBox = $("#alertMessage");
      const submitBtn = form.find("button[type='submit']");

      alertBox.html("");

      submitBtn.prop("disabled", true);
      submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Sending...');

      $.ajax({
        url: url,
        type: "POST",
        data: form.serialize(),
        dataType: "json",

        success: function (response) {

          const alertClass = response.status === "success"
            ? "alert-success"
            : "alert-danger";

          alertBox.html(
            '<div class="alert ' + alertClass + '">' +
              response.message +
            '</div>'
          );

          if (response.status === "success") {

            form[0].reset();

            if (response.redirect) {
              setTimeout(function () {
                window.location.href = response.redirect;
              }, 1200);
            }
          }
        },

        

        error: function (xhr, status, error) {

          console.log("AJAX STATUS:", status);
          console.log("AJAX ERROR:", error);
          console.log("SERVER RESPONSE:", xhr.responseText);

          alertBox.html(
            '<div class="alert alert-danger">' +
              "Something went wrong. Please try again." +
            '</div>'
          );
        },

        complete: function () {
          submitBtn.prop("disabled", false);
          submitBtn.html(buttonText);
        }
      });
    });
  }


  handleAjaxForm("#signup-form", "config/send-code.php", "Continue");

  handleAjaxForm("#otpForm", "config/send-code.php", "Verify and Continue");

  handleAjaxForm("#profileForm", "config/send-code.php", "Save Changes");

  handleAjaxForm("#loginForm", "config/send-code", "Login");

  handleAjaxForm("#profileUpdateForm", "../config/update-code.php", "Save Changes");

  handleAjaxForm("#PropertyOwnerForm", "config/send-code.php", "Join Property Owner Waitlist");

});


$(document).on("submit", "#profileUpdateForm", function(e) {
    e.preventDefault();
    alert("AJAX submit caught");
});
