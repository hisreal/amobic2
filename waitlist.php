<?php  $hide_navigation = true; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
        $propertyName = "Amobic Homes";
        $locationName = "Cape Town";
        $propertyType = "Property & Lifestyle Platform";
        $sleeps = "Guests";
        $priceFrom = "";
        $currency = "";
        $pageUrl = "https://www.amobic.com/waitlist";
        $imageUrl = "https://www.amobic.com/assets/img/hero/home.jpg";
        $metaTitle = "Amobic Homes Waitlist | Early Access to Cape Town's Premier Property & Lifestyle Platform";
        $metaDescription = "Join the Amobic Homes waitlist for early access to Cape Town's premium property and lifestyle platform launching September 2026.";
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

   


    

<main>

  <section class="amobic-waitlist-hero">

    <div class="container">
     
      <div class="amobic-waitlist-copy wow animate__fadeInUp">
        <div style="padding: 80px;" class="amobic-waitlist-title-banner">
         <a href="index.php" class="amobic-waitlist-hero-logo">
        <img  style="width: 150px; padding-top: 20px;" src="assets/img/logo/amobic-logo-white-full.png" alt="Amobic">
      </a>


       <h5 class="ul-banner-slide-title amobic-waitlist-title">Cape Town's Most Anticipated Property & Lifestyle Platform</h5>
       <p style="font-size: 10px; margin-bottom: 2rem;" class="amobic-waitlist-title-subtext">Coming September 2026</p>
        </div>  

          <span style="color: #373636; font-size: 14px; margin-top: 1rem;">
            <br>
            Be first. Early property owners and partners get guaranteed priority
            placement and reduced fees for Year 1.
          </span>

          <div class="amobic-waitlist-actions">
            <a href="property-owner.php" class="amobic-waitlist-primary">
              List Your Property
              <i class="bi bi-arrow-right"></i>
            </a>

            <a href="partner.php" class="amobic-waitlist-secondary">
              Partner With Us
            </a>
          </div>

        </div>
        <div style="margin-top: 2rem; padding: 10px;" class="row justify-content-center">
        <div class="amobic-waitlist-card wow animate__fadeInUp col-lg-8 col-md-8">
          <div class="amobic-waitlist-card-top">
            <span>Priority Access</span>
            <strong>Year 1</strong>
          </div>

          <h2>Join before the city-wide launch</h2>
          <p>
            Secure early visibility for your property, restaurant, spa, tour,
            or curated experience.
          </p>

          <div class="amobic-waitlist-card-list">
            <div>
              <i class="bi bi-stars"></i>
              <span>Reduced early partner fees</span>
            </div>
            <div>
              <i class="bi bi-geo-alt"></i>
              <span>Priority placement in Cape Town areas</span>
            </div>
            <div>
              <i class="bi bi-graph-up-arrow"></i>
              <span>Launch marketing exposure</span>
            </div>
          </div>

          
        
        </div>
        <div class="amobic-waitlist-proof ">
            <i class="bi bi-shield-check"></i>
            <span>
              Already trusted by property owners in Atlantic Seaboard, Sea Point
              and Green Point.
            </span>
          </div>
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


  <!--const openSidebar = document.getElementById("openSidebar");
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
});-->

</body>

</html>
