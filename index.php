<?php
$metaTitle = "Amobic Homes | Premium Stays, Experiences & Property Management";
$metaDescription = "Discover premium stays, curated experiences, and professional property management with Amobic Homes.";
$pageUrl = "https://www.amobic.com/";
require_once("header.php");
?>
<main>
<!-- BANNER SECTION START -->
        <section style="background: url(assets/img/hero/home.jpg) no-repeat center;" class="ul-banner ul-banner-section">
            <!-- top -->
            <div class="">
                <div class=" ">
                    <div class="">
                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-banner-slide">
                                <div class="ul-banner-container">
                                    <div class="row align-items-center flex-sm-row flex-column-reverse">
                                        <!-- banner text -->
                                        <div class="col-md-9 col-sm-8">
                                            <div class="ul-banner-slide-txt wow animate__fadeInUp">
                                                <h1 class="ul-banner-slide-title">Refined Living, Anywhere</h1>
                                                <p class="ul-banner-slide-descr">Discover thoughtfully curated homes designed for comfort, elegance, and seamless living.</p>
                                                <div class="ul-banner-slide-btns">
                                                    <a href="homes.php" class="ul-btn">Explore Homes</a>  <a href="signup.php" class="ul-btn">List Your Properties</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>

            
        </section>
        <!-- BANNER SECTION END -->


         <!-- ABOUT SECTION START -->
        <section  class="property-management-section ul-2-about ul-section-spacing">
            <div class="ul-container">
               <div class="property-management-wrap">
                <!-- about content(change this row-cols-lg-1 to row-cols-lg-2 later) -->
                <div class="row row-cols-lg-1 row-cols-1  wow animate__fadeInUp">
                    <div class="col">
                        <div class="ul-2-about-txt">
                            
                            <div class="ul-2-about-points">
                                <!-- single point -->
                                <div class="ul-2-about-point">
                                    
                                    <div class="ul-2-about-point-txt">
                                        <h6 class="ul-section-sub-title">ABOUT US</h6>
                                        <p class="ul-2-about-point-descr">Amobic Homes is a global hospitality and property management brand dedicated to creating refined living experiences through 
                                          thoughtfully designed homes and seamless service.</p>
                                    <p class="ul-2-about-point-descr">We combine modern hospitality with intelligent property management to deliver comfort for guests and consistent value for property owners.</p>
                                                <br>
                                               <a href="about.php" class="ul-btn">Learn More</a>
                                    </div>
                                </div>
                                <!-- single point -->
                               
                            </div>
                        </div>
                    </div>

                    <!-- img -->
                    <div class="col">
                        <div class="ul-2-about-img">
                           <!-- <img src="assets/img/images/about.png" alt="Image" class="main-img">-->
                            
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <!-- ABOUT SECTION END -->
<section class="amobic-hero-search-section">
  <div class="amobic-hero-overlay"></div>

  <div class="ul-inner-page-container">
    <div class="amobic-hero-search-content text-center">
      <span class="ul-section-sub-title text-white">AMOBIC STAYS</span>

      <h1 class="amobic-hero-title">
        Designed for Living. Curated for Experience.
      </h1>

      <p class="amobic-hero-text">
        Every Amobic home is intentionally styled to inspire comfort, relaxation, and connection. From clean interiors to calming environments, each stay is crafted to feel personal and memorable.
      </p>
    </div>

    <div class="amobic-floating-search">
      <form action="homes.php" method="post" class="row g-3 align-items-end">
        <div class="col-lg-3 col-md-6">
          <label for="hero-location" class="amobic-hero-label">Location</label>
          <div class="amobic-field-wrap">
            <span class="amobic-field-icon"><i class="bi bi-geo-alt"></i></span>
            <input type="text" id="hero-location" class="form-control amobic-hero-input" placeholder="Cape Town">
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <label for="hero-checkin" class="amobic-hero-label">Check in</label>
          <div class="amobic-field-wrap">
            <span class="amobic-field-icon"><i class="bi bi-calendar3"></i></span>
            <input type="date" id="hero-checkin" class="form-control amobic-hero-input">
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <label for="hero-checkout" class="amobic-hero-label">Check out</label>
          <div class="amobic-field-wrap">
            <span class="amobic-field-icon"><i class="bi bi-calendar-check"></i></span>
            <input type="date" id="hero-checkout" class="form-control amobic-hero-input">
          </div>
        </div>

        <div class="col-lg-2 col-md-6">
          <label for="hero-guests" class="amobic-hero-label">Guests</label>
          <div class="amobic-field-wrap">
            <span class="amobic-field-icon"><i class="bi bi-people"></i></span>
            <select id="hero-guests" class="form-select amobic-hero-input">
              <option selected>Guests</option>
              <option>1 Guest</option>
              <option>2 Guests</option>
              <option>3 Guests</option>
              <option>4 Guests</option>
              <option>5+ Guests</option>
            </select>
          </div>
        </div>

        <div class="col-lg-1 col-md-12">
          <button type="submit" class="amobic-hero-search-btn w-100">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

        <section class="property-management-section ul-section-spacing">
  <div class="ul-inner-page-container">
    <div class="property-management-wrap">
      <div class="row align-items-center g-4">
        
        <!-- Text Content -->
        <div class="col-lg-6">
          <div class="property-management-content">
            <span class="ul-section-sub-title">PROPERTY MANAGEMENT</span>
            <h2 class="ul-section-title">Maximize Your Property Everywhere</h2>
            <p class="property-management-text">
              We transform properties into high performing assets through design, pricing strategy, and professional management.
              Enjoy increased returns without the operational stress.
            </p>

            <div class="property-management-points">
              <div class="pm-point">
                <span class="pm-icon"><i class="bi bi-house-check"></i></span>
                <span>Professional property positioning</span>
              </div>
              <div class="pm-point">
                <span class="pm-icon"><i class="bi bi-graph-up-arrow"></i></span>
                <span>Smarter pricing for stronger returns</span>
              </div>
              <div class="pm-point">
                <span class="pm-icon"><i class="bi bi-stars"></i></span>
                <span>Stress free guest and operations management</span>
              </div>
            </div>

            <a href="signup.php" class="ul-btn property-management-btn">
              Become a Partner
            </a>
          </div>
        </div>

        <!-- Image -->
        <div class="col-lg-6">
          <div class="property-management-image">
            <img src="assets/img/images/properties-management.jpg" alt="Luxury property management in Cape Town">
            <div class="property-management-badge">
              <strong>High Performing</strong>
              <span>Managed assets with premium care</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>


<section class="why-choose-section ul-section-spacing">
  <div class="ul-inner-page-container">
    <div class="why-choose-wrap">
      <div class="row align-items-center g-4">

        <!-- Image Side -->
        <div class="col-lg-6">
          <div class="why-choose-image-grid">
            <div class="why-img why-img-lg">
              <img src="assets/img/images/karabo-mdluli-vvOwE2uIBBA-unsplash.jpg" alt="Luxury home in prime Cape Town location">
            </div>
            <div class="why-img why-img-sm">
              <img src="assets/img/images/jonathan-mueller-5udAj3r0dXQ-unsplash.jpg" alt="Refined interior design">
            </div>
            <div class="why-floating-card">
              <span class="why-floating-icon"><i class="bi bi-patch-check-fill"></i></span>
              <div>
                <strong>Trusted Property Care</strong>
                <p>Designed for comfort, performance, and peace of mind.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Text Side -->
        <div class="col-lg-6">
          <div class="why-choose-content">
            <span class="ul-section-sub-title">WHY CHOOSE US</span>
            <h2 class="ul-section-title">A Better Standard of Stay and Property Care</h2>
            <p class="why-choose-intro">
              We combine premium locations, elegant interiors, and dependable management to create exceptional guest experiences and high performing homes.
            </p>

            <div class="row g-3">
              <div class="col-sm-6">
                <div class="why-card">
                  <div class="why-card-icon">
                    <i class="bi bi-geo-alt"></i>
                  </div>
                  <h3>Prime Locations</h3>
                  <p>Homes situated in Cape Town's most desirable areas.</p>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="why-card">
                  <div class="why-card-icon">
                    <i class="bi bi-lamp"></i>
                  </div>
                  <h3>Refined Interiors</h3>
                  <p>Modern, calm, and thoughtfully curated spaces.</p>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="why-card">
                  <div class="why-card-icon">
                    <i class="bi bi-stars"></i>
                  </div>
                  <h3>Seamless Experience</h3>
                  <p>Effortless booking and stay experience.</p>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="why-card">
                  <div class="why-card-icon">
                    <i class="bi bi-building-check"></i>
                  </div>
                  <h3>Professional Management</h3>
                  <p>Trusted by property owners for performance and care.</p>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<section style="background: linear-gradient(
      rgba(0, 0, 0, 0.55),
      rgba(0, 0, 0, 0.55)
    ),
    url('assets/img/images/jackson-belshaw-j2RTRckQFlQ-unsplash1.jpg') center/cover no-repeat;" class="cta-property-section">
  <div class="ul-inner-page-container">
    <div class="cta-property-wrap text-center">

      <h2 class="cta-property-title">
       Your Next Stay Starts Here
      </h2>

      <p class="cta-property-text">
        Discover beautifully curated homes in prime locations, designed for comfort, style, and unforgettable experiences.
      </p>

      <a href="homes.php" class="ul-btn cta-property-btn">
        Browse Properties
      </a>

      <p class="cta-trust">Trusted by property owners and guests worldwide</p>

    </div>
  </div>
</section>
<?php require_once("footer.php"); ?>
