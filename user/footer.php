
    <!-- FOOTER SECTION START -->
<footer class="ul-footer amobic-footer">
   
               

    <!-- footer bottom -->
    <div class="ul-footer-bottom amobic-footer-bottom">
        <div class="ul-container">
            <div class="amobic-footer-bottom-wrap">
                <p class="copyright-txt">
                    &copy; 2026 Amobic. All rights reserved.
                </p>

                <div class="amobic-footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER SECTION END -->
    <!-- libraries JS -->
    <script src="../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/splide/splide.min.js"></script>
    <script src="../assets/vendor/splide/splide-extension-auto-scroll.min.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/slim-select/slimselect.min.js"></script>
    <script src="../assets/vendor/animate-wow/wow.min.js"></script>
    <script src="../assets/vendor/splittype/index.min.js"></script>
    <script src="../assets/vendor/mixitup/mixitup.min.js"></script>
    <script src="../assets/vendor/fslightbox/fslightbox.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- custom JS -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/tab.js"></script>
    <script src="../assets/js/custom.js"></script>
<script>
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


  handleAjaxForm("#profileUpdateForm", "../config/update-code.php", "Save Changes");
});


</script>
  
<script>
    /* sidebar toggle */

    const openSidebar = document.getElementById("openSidebar");
    const closeSidebar = document.getElementById("closeSidebar");
    const mobileSidebar = document.getElementById("mobileSidebar");
    const sidebarOverlay = document.getElementById("sidebarOverlay");

    openSidebar.addEventListener("click", function () {
    mobileSidebar.classList.add("active");
    sidebarOverlay.classList.add("active");
    });

    closeSidebar.addEventListener("click", function () {
    mobileSidebar.classList.remove("active");
    sidebarOverlay.classList.remove("active");
    });

    sidebarOverlay.addEventListener("click", function () {
    mobileSidebar.classList.remove("active");
    sidebarOverlay.classList.remove("active");
    });
</script>
</body>

</html>