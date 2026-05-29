<?php
session_start();
$hide_navigation = true;
if (empty($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
        $propertyName = "Amobic Homes";
        $locationName = "Cape Town";
        $propertyType = "Lifestyle Partner Waitlist";
        $sleeps = "Partners";
        $priceFrom = "";
        $currency = "";
        $pageUrl = "https://www.amobic.com/partner";
        $imageUrl = "https://www.amobic.com/assets/img/images/properties-management.jpg";
        $metaTitle = "Partner Waitlist | Restaurants, Spas & Experiences | Amobic Homes";
        $metaDescription = "Apply to join the Amobic Homes lifestyle partner waitlist for restaurants, spas, wellness studios, transport, and local experiences.";
    ?>

    <title><?php echo $metaTitle; ?></title>
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Amobic">
    <link rel="canonical" href="<?php echo $pageUrl; ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo $metaTitle; ?>">
    <meta property="og:description" content="<?php echo $metaDescription; ?>">
    <meta property="og:image" content="<?php echo $imageUrl; ?>">
    <meta property="og:url" content="<?php echo $pageUrl; ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Amobic">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $metaTitle; ?>">
    <meta name="twitter:description" content="<?php echo $metaDescription; ?>">
    <meta name="twitter:image" content="<?php echo $imageUrl; ?>">
       <link rel="icon" href="assets/img/images/favicon.png" type="image/png">

    <!-- libraries CSS -->
    <link rel="stylesheet" href="assets/icon/flaticon_real_estate.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/splide/splide.min.css">
    <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="assets/vendor/slim-select/slimselect.css">
    <link rel="stylesheet" href="assets/vendor/animate-wow/animate.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- custom CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css');?>">
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LodgingBusiness",
      "name": "<?php echo $propertyName; ?>",
      "description": "<?php echo $metaDescription; ?>",
      "url": "<?php echo $pageUrl; ?>",
      "image": "<?php echo $imageUrl; ?>",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "<?php echo $locationName; ?>",
        "addressCountry": "South Africa"
      },
      "priceRange": "<?php echo $currency . ' ' . $priceFrom; ?>",
      "brand": {
        "@type": "Brand",
        "name": "Amobic"
      },
      "amenityFeature": [
        {
          "@type": "LocationFeatureSpecification",
          "name": "Refined Interiors",
          "value": true
        },
        {
          "@type": "LocationFeatureSpecification",
          "name": "Prime Location",
          "value": true
        },
        {
          "@type": "LocationFeatureSpecification",
          "name": "Professional Management",
          "value": true
        }
      ]
    }
    </script>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.amobic.com/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Properties",
          "item": "https://www.amobic.com/properties"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "<?php echo $propertyName; ?>",
          "item": "<?php echo $pageUrl; ?>"
        }
      ]
    }
    </script>
</head>

<body>
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>
    <center> <img style="width: 150px; padding-bottom: 20px; padding-top: 30px;" src="assets/img/logo/amobic-logo-dark-full.png" alt="Amobic"></center>

    <div class="amobic-auth-topbar">
    <button type="button" class="amobic-back-btn" onclick="history.back()">
      <i class="bi bi-arrow-left"></i>
    </button>
    <!--<a href="waitlist.php" class="amobic-home-btn">Back to Home</a>-->
  </div>

  <section class="amobic-waitlist-section amobic-waitlist-partner-section" id="partner-waitlist">
    <div class="container">
      <div class="amobic-waitlist-split">
        <div class="amobic-waitlist-partner-copy">
          <h2>Partner Your Restaurant, Spa, or Experience</h2>
          <p>
            Connect with premium guests before they arrive. We are onboarding
            trusted lifestyle partners across Cape Town ahead of launch.
          </p>

          <div class="amobic-waitlist-mini-grid">
            <div>
              <strong>01</strong>
              <p>Restaurants and cafes</p>
            </div>
            <div>
              <strong>02</strong>
              <p>Spas and wellness studios</p>
            </div>
            <div>
              <strong>03</strong>
              <p>Tours and experiences</p>
            </div>
          </div>
        </div>

        <form id="PartnerForm" method="post" class="amobic-waitlist-form amobic-waitlist-partner-form">
          <input type="hidden" name="waitlist_type" value="lifestyle_partner">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

          <div class="amobic-waitlist-form-title">
            <h3>Apply as a launch partner</h3>
            <p>Tell us where you fit into the Amobic guest experience.</p>
          </div>

          <label>Business Name</label>
          <input type="text" name="business_name" placeholder="Your business name" required>

          <label>Email</label>
          <input type="email" name="email" placeholder="partner@example.com" required>

          <label>Category</label>
          <select name="category" required>
            <option value="">Select category</option>
            <option value="restaurant">Restaurant</option>
            <option value="spa">Spa</option>
            <option value="wellness">Wellness</option>
            <option value="experience">Experience</option>
            <option value="transport">Chauffeur Service</option>
          </select>

          <label>Location</label>
          <input type="text" name="location" placeholder="Atlantic Seaboard, Green Point..." required>

          <div id="alertMessage" class="alert"></div>

          <button type="submit" class="amobic-waitlist-submit">
            Join Partner Waitlist
            <i class="bi bi-arrow-right"></i>
          </button>
        </form>
      </div>
    </div>
  </section>
</main>


    <!-- FOOTER SECTION START -->
<footer class="ul-footer amobic-footer">
   
               

    <!-- footer bottom -->
    <div class="ul-footer-bottom amobic-footer-bottom">
        <div class="ul-container">
            <div class="amobic-footer-bottom-wrap">
                <p class="copyright-txt">
                    &copy; 2026 Amobic Homes All rights reserved.
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
    <script src="assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/splide/splide.min.js"></script>
    <script src="assets/vendor/splide/splide-extension-auto-scroll.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/slim-select/slimselect.min.js"></script>
    <script src="assets/vendor/animate-wow/wow.min.js"></script>
    <script src="assets/vendor/splittype/index.min.js"></script>
    <script src="assets/vendor/mixitup/mixitup.min.js"></script>
    <script src="assets/vendor/fslightbox/fslightbox.js"></script>

    <!-- custom JS -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/tab.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/form-auth.js"></script>
    <script>
      $(document).ready(function () {
        $("#PartnerForm").on("submit", function (e) {
          e.preventDefault();

          const form = $(this);
          const alertBox = $("#alertMessage");
          const submitBtn = form.find("button[type='submit']");
          const buttonText = 'Join Partner Waitlist <i class="bi bi-arrow-right"></i>';

          alertBox.html("");
          submitBtn.prop("disabled", true);
          submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Sending...');
  
          $.ajax({
            url: "authentication",
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
              }
            },
            error: function (xhr, status, error) {
              console.log("AJAX STATUS:", status);
              console.log("AJAX ERROR:", error);
              console.log("SERVER RESPONSE:", xhr.responseText);

              let message = "Something went wrong. Please try again.";

              if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
              } else if (xhr.responseText) {
                try {
                  const response = JSON.parse(xhr.responseText);
                  if (response.message) {
                    message = response.message;
                  }
                } catch (e) {}
              }

              alertBox.html(
                '<div class="alert alert-danger">' +
                  message +
                '</div>'
              );
            },
            complete: function () {
              submitBtn.prop("disabled", false);
              submitBtn.html(buttonText);
            }
          });
        });
      });
    </script>


</body>

</html>
