<?php
$pageTitle = "List Your Property | Amobic Homes";
$extraScripts = '<script src="../assets/js/property-listing.js?v=' . filemtime("../assets/js/property-listing.js") . '"></script>';
require_once("header.php");
?>

<div class="amobic-sidebar-overlay" id="sidebarOverlay"></div>

<main class="amobic-dashboard-main property-listing-shell">
  <section class="listing-card">
    <div class="listing-head">
      <div>
        <span class="listing-kicker">Property onboarding</span>
        <h1>List a property</h1>
        <p>Complete each section to prepare your listing for review.</p>
      </div>
      <div class="draft-pill" id="draftStatus">
        <i class="bi bi-cloud-check"></i>
        <span>No draft yet</span>
      </div>
    </div>

    <div class="listing-progress-wrap">
      <div class="listing-progress-line">
        <div class="listing-progress-fill" id="progressFill"></div>
      </div>
      <div class="listing-steps-indicator" id="stepsIndicator">
        <button type="button" class="step-dot active" data-step-target="0"><span>1</span><small>Location</small></button>
        <button type="button" class="step-dot" data-step-target="1"><span>2</span><small>Class</small></button>
        <button type="button" class="step-dot" data-step-target="2"><span>3</span><small>Amenities</small></button>
        <button type="button" class="step-dot" data-step-target="3"><span>4</span><small>Security</small></button>
        <button type="button" class="step-dot" data-step-target="4"><span>5</span><small>Rules</small></button>
      </div>
    </div>

    <div id="listingAlert" class="listing-alert"></div>

    <form id="propertyListingForm" method="post" enctype="multipart/form-data" novalidate>
      <input type="hidden" name="draft_id" id="draftId">
      <input type="hidden" name="image_paths" id="imagePaths">

      <section class="listing-step active" data-step="0">
        <div class="step-title">
          <i class="bi bi-geo-alt"></i>
          <div>
            <h2>Property Location</h2>
            <p>Use the full address guests and property managers can recognize.</p>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-12">
            <label class="form-label" for="full_address">Full Property Address</label>
            <input type="text" class="form-control" id="full_address" name="full_address" required maxlength="255">
            <div class="field-error" data-error-for="full_address"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="suburb_area">Suburb / Area</label>
            <input type="text" class="form-control" id="suburb_area" name="suburb_area" required maxlength="160">
            <div class="field-error" data-error-for="suburb_area"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="landmark">Complex Name / Nearest Landmark</label>
            <input type="text" class="form-control" id="landmark" name="landmark" maxlength="160">
          </div>
        </div>
      </section>

      <section class="listing-step" data-step="1">
        <div class="step-title">
          <i class="bi bi-buildings"></i>
          <div>
            <h2>Property Classification</h2>
            <p>Help us match the listing to the right guest and tenant searches.</p>
          </div>
        </div>

        <div class="form-group-block">
          <label class="form-label">Property Type</label>
          <div class="choice-grid option-group" data-required-group="property_types">
            <?php foreach (["Apartment", "House", "Villa", "Townhouse", "Penthouse", "Studio", "Cottage"] as $type): ?>
              <label class="choice-card"><input type="checkbox" name="property_types[]" value="<?= $type; ?>"> <span><?= $type; ?></span></label>
            <?php endforeach; ?>
          </div>
          <div class="field-error" data-error-for="property_types"></div>
        </div>

        <div class="row g-3">
          <div class="col-lg-6">
            <label class="form-label">Bedrooms</label>
            <div class="choice-grid compact option-group" data-required-group="bedrooms">
              <?php foreach (["Studio", "1", "2", "3", "4", "5+"] as $item): ?>
                <label class="choice-card"><input type="radio" name="bedrooms" value="<?= $item; ?>" required> <span><?= $item; ?></span></label>
              <?php endforeach; ?>
            </div>
            <div class="field-error" data-error-for="bedrooms"></div>
          </div>
          <div class="col-lg-6">
            <label class="form-label">Bathrooms</label>
            <div class="choice-grid compact option-group" data-required-group="bathrooms">
              <?php foreach (["1", "2", "3", "4", "5+"] as $item): ?>
                <label class="choice-card"><input type="radio" name="bathrooms" value="<?= $item; ?>" required> <span><?= $item; ?></span></label>
              <?php endforeach; ?>
            </div>
            <div class="field-error" data-error-for="bathrooms"></div>
          </div>
          <div class="col-lg-6">
            <label class="form-label">Parking</label>
            <div class="choice-grid option-group" data-required-group="parking">
              <?php foreach (["None", "1 Bay", "2 Bays", "Garage", "Street Only"] as $item): ?>
                <label class="choice-card"><input type="radio" name="parking" value="<?= $item; ?>" required> <span><?= $item; ?></span></label>
              <?php endforeach; ?>
            </div>
            <div class="field-error" data-error-for="parking"></div>
          </div>
          <div class="col-lg-6">
            <label class="form-label">Occupancy Type</label>
            <div class="choice-grid option-group" data-required-group="occupancy_type">
              <?php foreach (["Short-Term Only", "Long-Term Only", "Both"] as $item): ?>
                <label class="choice-card"><input type="radio" name="occupancy_type" value="<?= $item; ?>" required> <span><?= $item; ?></span></label>
              <?php endforeach; ?>
            </div>
            <div class="field-error" data-error-for="occupancy_type"></div>
          </div>
        </div>
      </section>

      <section class="listing-step" data-step="2">
        <div class="step-title">
          <i class="bi bi-stars"></i>
          <div>
            <h2>Furnishing & Amenities</h2>
            <p>Capture the operational details guests ask about most often.</p>
          </div>
        </div>

        <div class="row g-3">
          <?php
          $groups = [
              "furnishing_status" => ["Furnishing Status", ["Unfurnished", "Semi-Furnished", "Fully Furnished"]],
              "wifi_internet" => ["WiFi / Internet", ["Yes", "No"]],
              "wifi_speed" => ["WiFi Speed", ["Not Sure", "Under 10 Mbps", "10-25 Mbps", "25-50 Mbps", "50-100 Mbps", "100+ Mbps"]],
              "load_shedding_solution" => ["Load-Shedding Solution", ["None", "UPS", "Inverter", "Generator", "Solar Backup"]],
              "air_conditioning" => ["Air Conditioning", ["Yes", "No"]],
              "swimming_pool" => ["Swimming Pool", ["Yes", "No"]],
              "braai_outdoor_area" => ["Braai / Outdoor Area", ["Yes", "No"]],
              "washing_machine" => ["Washing Machine", ["Yes", "No"]],
          ];
          foreach ($groups as $name => [$label, $options]):
          ?>
            <div class="col-lg-6">
              <label class="form-label"><?= $label; ?></label>
              <div class="choice-grid option-group <?= count($options) <= 2 ? 'two-col' : ''; ?>" data-required-group="<?= $name; ?>">
                <?php foreach ($options as $item): ?>
                  <label class="choice-card"><input type="radio" name="<?= $name; ?>" value="<?= $item; ?>" required> <span><?= $item; ?></span></label>
                <?php endforeach; ?>
              </div>
              <div class="field-error" data-error-for="<?= $name; ?>"></div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <section class="listing-step" data-step="3">
        <div class="step-title">
          <i class="bi bi-shield-check"></i>
          <div>
            <h2>Furnishing & Amenities</h2>
            <p>Add security and access details for the property.</p>
          </div>
        </div>

        <div class="row g-3">
          <?php foreach (["access_control" => "Access Control", "cctv_alarm" => "CCTV / Alarm"] as $name => $label): ?>
            <div class="col-md-6">
              <label class="form-label"><?= $label; ?></label>
              <div class="choice-grid two-col option-group" data-required-group="<?= $name; ?>">
                <label class="choice-card"><input type="radio" name="<?= $name; ?>" value="Yes" required> <span>Yes</span></label>
                <label class="choice-card"><input type="radio" name="<?= $name; ?>" value="No" required> <span>No</span></label>
              </div>
              <div class="field-error" data-error-for="<?= $name; ?>"></div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <section class="listing-step" data-step="4">
        <div class="step-title">
          <i class="bi bi-card-checklist"></i>
          <div>
            <h2>House Rules & Images</h2>
            <p>Finish the listing with policies and property photos.</p>
          </div>
        </div>

        <div class="row g-3">
          <?php
          $rules = [
              "smoking_policy" => ["Smoking Policy", ["No Smoking", "Outdoor Only", "Smoking Allowed"]],
              "events_parties" => ["Events / Parties", ["Not Allowed", "Allowed With Approval", "Allowed"]],
              "pets_allowed" => ["Pets Allowed", ["No Pets", "Cats Only", "Dogs Only", "Small Pets Only", "Pets Allowed"]],
          ];
          foreach ($rules as $name => [$label, $options]):
          ?>
            <div class="col-lg-4">
              <label class="form-label"><?= $label; ?></label>
              <div class="choice-grid option-group" data-required-group="<?= $name; ?>">
                <?php foreach ($options as $item): ?>
                  <label class="choice-card"><input type="radio" name="<?= $name; ?>" value="<?= $item; ?>" required> <span><?= $item; ?></span></label>
                <?php endforeach; ?>
              </div>
              <div class="field-error" data-error-for="<?= $name; ?>"></div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="upload-panel">
          <div class="upload-copy">
            <h3>Property images</h3>
            <p>Upload up to 15 JPG, PNG, or WEBP images. Each image must be 5MB or less.</p>
          </div>
          <div class="dropzone" id="dropzone">
            <input type="file" id="propertyImages" accept="image/jpeg,image/png,image/webp" multiple hidden>
            <i class="bi bi-cloud-arrow-up"></i>
            <strong>Drop images here</strong>
            <span>or click to browse</span>
          </div>
          <div class="upload-progress" id="uploadProgress" aria-hidden="true">
            <div class="progress">
              <div class="progress-bar" id="uploadProgressBar" style="width:0%"></div>
            </div>
            <small id="uploadProgressText">Preparing upload...</small>
          </div>
          <div class="image-preview-grid" id="imagePreviewGrid"></div>
          <div class="field-error" data-error-for="images"></div>
        </div>
      </section>

      <div class="listing-actions">
        <button type="button" class="btn btn-outline-success" id="prevStep">
          <i class="bi bi-arrow-left"></i> Previous
        </button>
        <button type="button" class="btn btn-success" id="nextStep">
          Next <i class="bi bi-arrow-right"></i>
        </button>
        <button type="submit" class="btn btn-success d-none" id="submitListing">
          <span class="submit-label">Submit Listing</span>
          <span class="spinner-border spinner-border-sm d-none" id="submitSpinner"></span>
        </button>
      </div>
    </form>
  </section>
</main>

<div class="modal fade" id="draftModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content listing-modal">
      <div class="modal-header">
        <h5 class="modal-title">You have an unfinished draft. Continue where you stopped?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="mb-0">Your saved answers and uploaded images can be restored automatically.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="startFresh">Start Fresh</button>
        <button type="button" class="btn btn-success" id="continueDraft">Continue Draft</button>
      </div>
    </div>
  </div>
</div>

<?php require_once("footer.php"); ?>
