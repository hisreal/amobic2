<?php
$metaTitle = "Homes | Browse Premium Stays | Amobic Homes";
$metaDescription = "Browse premium homes and curated stays available through Amobic Homes.";
$pageUrl = "https://www.amobic.com/homes";
require_once("header.php");
?>
<main>
<!-- BANNER SECTION START -->
        <section style="background: url(https://images.unsplash.com/photo-1580060839134-75a5edca2e99?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D) no-repeat center center;
" class="ul-banner">
            <!-- top -->
            <div class="top">
                <div class="ul-banner-slider swiper">
                    <div class="swiper-wrapper">
                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-banner-slide">
                                <div class="ul-banner-container">
                                    <div class="row align-items-center flex-sm-row flex-column-reverse">
                                        <!-- banner text -->
                                        <div class="col-md-9 col-sm-8">
                                            <div class="ul-banner-slide-txt wow animate__fadeInUp">
                                                <h1 class="ul-banner-slide-title">Explore Exceptional Homes</h1>
                                                <p class="ul-banner-slide-descr">Find premium stays designed for comfort, convenience, and elevated living experiences around the world.</p>
                                               
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
     <div class="ul-inner-page-content-wrapper ul-projects-page-content-wrapper">
            <div class="ul-inner-page-container">
                <!-- search filters -->
                <form action="#" class="ul-projects-search-filters">
                    <div class="row row-cols-lg-4 row-cols-sm-3 row-cols-2 row-cols-xxs-1 justify-content-center wow animate__fadeInUp">
                        <!-- <div class="col">
                            <select name="keyword" id="keyword">
                                <option data-placeholder="true">Enter Keyword</option>
                                <option value="01">Keyword 01</option>
                                <option value="02">Keyword 02</option>
                                <option value="03">Keyword 03</option>
                            </select>
                        </div>
                        -->
                        <div class="col">
                            <select name="location" id="location">
                                <option data-placeholder="true">Select Location</option>
                                <option value="los-angeles">LA</option>
                                <option value="san-francisco">San Francisco</option>
                                <option value="new-york">New York</option>
                            </select>
                        </div>

                        <div class="col">
                            <div class="ul-projects-custom-field">
                                <input type="date" name="check-in" id="check-in">
                            </div>
                        </div>

                        <div class="col">
                            <div class="ul-projects-custom-field">
                                <input type="date" name="check-out" id="check-out">
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="ul-projects-search-filters-btns">
                                <button type="button" class="ul-projects-search-filters-expand-btn"><i class="flaticon-filter"></i></button>
                                <button type="submit" class="ul-projects-search-filters-btn ul-btn">Search Properties</button>
                            </div>
                        </div>
                    </div>

                    <div class="ul-projects-search-filters-row-2 row row-cols-lg-4 row-cols-sm-3 row-cols-2 row-cols-xxs-1 justify-content-center wow animate__fadeInUp">
                       <div class="col">
                            <select name="guests" id="guests">
                                <option data-placeholder="true">Guests</option>
                                <option value="1">1 Guest</option>
                                <option value="2">2 Guests</option>
                                <option value="3">3 Guests</option>
                                <option value="4">4 Guests</option>
                                <option value="5">5+ Guests</option>
                            </select>
                            </div>

                            <div class="col">
                            <select name="property-type" id="property-type">
                                <option data-placeholder="true">Property Type</option>
                                <option value="apartment">Apartment</option>
                                <option value="studio">Studio</option>
                                <option value="villa">Villa</option>
                                <option value="penthouse">Penthouse</option>
                                <option value="shortlet">Shortlet</option>
                            </select>
                            </div>

                            <div class="col">
                            <select name="amenities[]" id="amenities" multiple>
                                <option value="wifi">WiFi</option>
                                <option value="parking">Parking</option>
                                <option value="pool">Pool</option>
                                <option value="gym">Gym</option>
                                <option value="air-conditioning">Air Conditioning</option>
                                <option value="kitchen">Kitchen</option>
                                <option value="security">Security</option>
                                <option value="sea-view">Sea View</option>
                            </select>
                            </div>

                            <div class="col">
                            <select name="price-range" id="price-range">
                                <option data-placeholder="true">Price Range</option>
                                <option value="0-100">$0 - $100</option>
                                <option value="100-250">$100 - $250</option>
                                <option value="250-500">$250 - $500</option>
                                <option value="500-plus">$500+</option>
                            </select>
                            </div>
                    </div>
                </form>

                <!-- project cards grid -->
                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                    <!-- single project -->
                    <div class="col wow animate__fadeInUp">
                        <div class="ul-project">
                            <div class="ul-project-img"><img src="assets/img/project-2.jpg" alt="Project Image"></div>
                            <div class="ul-project-txt">
                                <span class="ul-project-tag">Popular</span>
                                <div class="top">
                                    <div class="left">
                                        <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                        <a href="project-details.html" class="ul-project-title">Beverly Springfield</a>
                                        <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                    </div>
                                    <div class="right">
                                        <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                    </div>
                                </div>

                                <!-- bottom -->
                                <div class="ul-project-infos">
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bed-color"></i></span>
                                        <span class="text">3 Beds</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bath"></i></span>
                                        <span class="text">2 Bathrooms</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-scale"></i></span>
                                        <span class="text">6x7.5 m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single project -->
                    <div class="col wow animate__fadeInUp">
                        <div class="ul-project">
                            <div class="ul-project-img"><img src="assets/img/project-3.jpg" alt="Project Image"></div>
                            <div class="ul-project-txt">
                                <span class="ul-project-tag">Popular</span>
                                <div class="top">
                                    <div class="left">
                                        <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                        <a href="project-details.html" class="ul-project-title">Faulkner Ave</a>
                                        <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                    </div>
                                    <div class="right">
                                        <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                    </div>
                                </div>

                                <!-- bottom -->
                                <div class="ul-project-infos">
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bed-color"></i></span>
                                        <span class="text">3 Beds</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bath"></i></span>
                                        <span class="text">2 Bathrooms</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-scale"></i></span>
                                        <span class="text">6x7.5 m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single project -->
                    <div class="col wow animate__fadeInUp">
                        <div class="ul-project">
                            <div class="ul-project-img"><img src="assets/img/project-4.jpg" alt="Project Image"></div>
                            <div class="ul-project-txt">
                                <span class="ul-project-tag">Popular</span>
                                <div class="top">
                                    <div class="left">
                                        <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                        <a href="project-details.html" class="ul-project-title">St. Crystal</a>
                                        <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                    </div>
                                    <div class="right">
                                        <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                    </div>
                                </div>

                                <!-- bottom -->
                                <div class="ul-project-infos">
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bed-color"></i></span>
                                        <span class="text">3 Beds</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bath"></i></span>
                                        <span class="text">2 Bathrooms</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-scale"></i></span>
                                        <span class="text">6x7.5 m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single project -->
                    <div class="col wow animate__fadeInUp">
                        <div class="ul-project">
                            <div class="ul-project-img"><img src="assets/img/project-5.jpg" alt="Project Image"></div>
                            <div class="ul-project-txt">
                                <span class="ul-project-tag">Popular</span>
                                <div class="top">
                                    <div class="left">
                                        <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                        <a href="project-details.html" class="ul-project-title">Cove Red</a>
                                        <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                    </div>
                                    <div class="right">
                                        <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                    </div>
                                </div>

                                <!-- bottom -->
                                <div class="ul-project-infos">
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bed-color"></i></span>
                                        <span class="text">3 Beds</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bath"></i></span>
                                        <span class="text">2 Bathrooms</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-scale"></i></span>
                                        <span class="text">6x7.5 m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single project -->
                    <div class="col wow animate__fadeInUp">
                        <div class="ul-project">
                            <div class="ul-project-img"><img src="assets/img/project-6.jpg" alt="Project Image"></div>
                            <div class="ul-project-txt">
                                <span class="ul-project-tag">Popular</span>
                                <div class="top">
                                    <div class="left">
                                        <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                        <a href="project-details.html" class="ul-project-title">Tarpon Bay</a>
                                        <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                    </div>
                                    <div class="right">
                                        <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                    </div>
                                </div>

                                <!-- bottom -->
                                <div class="ul-project-infos">
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bed-color"></i></span>
                                        <span class="text">3 Beds</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-bath"></i></span>
                                        <span class="text">2 Bathrooms</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info">
                                        <span class="icon"><i class="flaticon-scale"></i></span>
                                        <span class="text">6x7.5 m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


  
<?php require_once ("footer.php"); ?>
