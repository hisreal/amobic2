<?php 
 require_once('session.php');
require_ONCE("../config/dbh.php");
$current_page = basename($_SERVER['PHP_SELF']);
$page_titles = [
    "dashboard.php" => "My Bookings | Amobic Homes",
    "saved-home.php" => "Saved Homes | Amobic Homes",
    "profile.php" => "My Profile | Amobic Homes",
    "password.php" => "Change Password | Amobic Homes"
];
$pageTitle = $pageTitle ?? ($page_titles[$current_page] ?? "Dashboard | Amobic Homes");
$pageUrl = $pageUrl ?? "https://www.amobic.com/user/" . $current_page;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  

    <title><?php echo htmlspecialchars($pageTitle); ?></title>
  
    <meta name="author" content="Amobic">
    <link rel="canonical" href="<?php echo $pageUrl; ?>">

    

   
       <link rel="icon" href="../assets/img/images/favicon.png" type="image/png">

    <!-- libraries CSS -->
    <link rel="stylesheet" href="../assets/icon/flaticon_real_estate.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/splide/splide.min.css">
    <link rel="stylesheet" href="../assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/vendor/slim-select/slimselect.css">
    <link rel="stylesheet" href="../assets/vendor/animate-wow/animate.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- custom CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo filemtime('../assets/css/style.css');?>">
    <!-- Structured Data -->
 
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


<div class="amobic-dashboard">

    <header class="amobic-dashboard-navbar">
      <div style="margin-bottom: -30px;" class="amobic-dashboard-logo">
      <a href="dashboard.php"  class="amobic-auth-logo">
        <img style="width: 50px" src="../assets/img/images/favicon.png" alt="Amobic">
      </a>
      </div>

      <nav class="amobic-desktop-nav">
            <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                My Bookings
            </a>

            <a href="saved-home.php" class="<?= ($current_page == 'saved-home.php') ? 'active' : ''; ?>">
                Saved Homes
            </a>

            <a href="profile.php" class="<?= ($current_page == 'profile.php') ? 'active' : ''; ?>">
                My Profile
            </a>

            <a href="password.php" class="<?= ($current_page == 'password.php') ? 'active' : ''; ?>">
                Change Password
            </a>

            <a href="logout.php" class="<?= ($current_page == 'logout.php') ? 'active' : ''; ?>">
                Logout
            </a>
        </nav>

      <div class="amobic-navbar-right">
        <a href="dashboard.php" class="amobic-switch-link">Switch to Property Owners</a>

        <div class="amobic-user-avatar">
          A
        </div>

        <button class="amobic-mobile-menu-btn" id="openSidebar">
          <i class="bi bi-list"></i>
        </button>
      </div>
    </header>

    <aside class="amobic-mobile-sidebar" id="mobileSidebar">
      <div class="amobic-sidebar-head">
      <img style="width: 50px" src="../assets/img/images/favicon.png" alt="Amobic">

        <button id="closeSidebar">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <nav class="amobic-sidebar-menu">
        <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
          <i class="bi bi-calendar3"></i> My Bookings
        </a>
        <a href="saved-home.php" class="<?= ($current_page == 'saved-home.php') ? 'active' : ''; ?>">
          <i class="bi bi-house-door"></i> Saved Homes
        </a>
        <a href="profile.php" class="<?= ($current_page == 'profile.php') ? 'active' : ''; ?>">
          <i class="bi bi-person"></i> Profile
        </a>
        <a href="password.php" class="<?= ($current_page == 'password.php') ? 'active' : ''; ?>">
          <i class="bi bi-lock"></i> Password
        </a>
        <a href="logout.php" class="<?= ($current_page == 'logout.php') ? 'active' : ''; ?>">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      </nav>
    </aside>
