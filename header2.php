<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
        $propertyName = $propertyName ?? "Amobic Homes";
        $locationName = $locationName ?? "Cape Town";
        $propertyType = $propertyType ?? "Premium Stays";
        $sleeps = $sleeps ?? "Guests";
        $priceFrom = $priceFrom ?? "";
        $currency = $currency ?? "";
        $pageUrl = $pageUrl ?? "https://www.amobic.com/";
        $imageUrl = $imageUrl ?? "https://www.amobic.com/assets/img/hero/home.jpg";
        $metaTitle = $metaTitle ?? "Amobic Homes | Account Access";
        $metaDescription = $metaDescription ?? "Access your Amobic Homes account, verify your email, complete your profile, and manage your guest experience.";
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
      
<div class="amobic-auth-topbar">
  <button type="button" class="amobic-back-btn" onclick="history.back()">
    <i class="bi bi-arrow-left"></i>
  </button>
  <a href="../index.php" class="amobic-home-btn">Back to Home</a>
</div>
