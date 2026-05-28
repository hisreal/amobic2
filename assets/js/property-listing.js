(function ($) {
  "use strict";

  const storageKey = "amobic_property_listing_draft";
  const imageBase = "../";
  const $form = $("#propertyListingForm");
  const $steps = $(".listing-step");
  const $dots = $(".step-dot");
  const totalSteps = $steps.length;
  const state = {
    currentStep: 0,
    maxCompletedStep: 0,
    draftId: "",
    images: [],
    isSubmitting: false,
    isDirty: false,
    submitted: false
  };
  let autosaveTimer = null;

  const messages = {
    full_address: "Full property address is required.",
    suburb_area: "Suburb / Area is required.",
    property_types: "Select at least one property type.",
    bedrooms: "Select the bedroom count.",
    bathrooms: "Select the bathroom count.",
    parking: "Select a parking option.",
    occupancy_type: "Select an occupancy type.",
    furnishing_status: "Select furnishing status.",
    wifi_internet: "Select WiFi / Internet availability.",
    wifi_speed: "Select WiFi speed.",
    load_shedding_solution: "Select a load-shedding solution.",
    air_conditioning: "Select air conditioning availability.",
    swimming_pool: "Select swimming pool availability.",
    braai_outdoor_area: "Select braai / outdoor area availability.",
    washing_machine: "Select washing machine availability.",
    access_control: "Select access control availability.",
    cctv_alarm: "Select CCTV / Alarm availability.",
    smoking_policy: "Select a smoking policy.",
    events_parties: "Select events / parties policy.",
    pets_allowed: "Select pets policy."
  };

  function setAlert(type, text) {
    if (!text) {
      $("#listingAlert").html("");
      return;
    }
    $("#listingAlert").html('<div class="alert alert-' + type + '">' + escapeHtml(text) + "</div>");
  }

  function escapeHtml(value) {
    return $("<div>").text(value || "").html();
  }

  function setDraftStatus(text) {
    $("#draftStatus span").text(text);
  }

  function getPayload() {
    const payload = {};
    $form.serializeArray().forEach(function (item) {
      if (item.name === "draft_id" || item.name === "image_paths") {
        return;
      }
      if (item.name.endsWith("[]")) {
        const key = item.name.replace("[]", "");
        payload[key] = payload[key] || [];
        payload[key].push(item.value);
      } else {
        payload[item.name] = item.value;
      }
    });
    return payload;
  }

  function saveLocal() {
    localStorage.setItem(storageKey, JSON.stringify({
      draft_id: state.draftId,
      payload: getPayload(),
      images: state.images,
      current_step: state.currentStep,
      max_completed_step: state.maxCompletedStep,
      saved_at: new Date().toISOString()
    }));
  }

  function applyPayload(payload) {
    if (!payload) return;
    Object.keys(payload).forEach(function (name) {
      const value = payload[name];
      const $fields = $form.find('[name="' + name + '"], [name="' + name + '[]"]');
      if (!$fields.length) return;

      if (Array.isArray(value)) {
        $fields.each(function () {
          this.checked = value.indexOf(this.value) !== -1;
        });
      } else {
        const type = ($fields.first().attr("type") || "").toLowerCase();
        if (type === "radio" || type === "checkbox") {
          $fields.each(function () {
            this.checked = this.value === value;
          });
        } else {
          $fields.val(value);
        }
      }
    });
  }

  function stepComplete(index, showErrors) {
    const $step = $steps.eq(index);
    let valid = true;

    $step.find(".field-error").text("");
    $step.find(".is-invalid").removeClass("is-invalid");

    $step.find("input[required][type='text']").each(function () {
      if (!$.trim($(this).val())) {
        valid = false;
        if (showErrors) {
          $(this).addClass("is-invalid");
          $('[data-error-for="' + this.name + '"]').text(messages[this.name] || "This field is required.");
        }
      }
    });

    $step.find("[data-required-group]").each(function () {
      const name = $(this).data("required-group");
      const checked = $form.find('[name="' + name + '"], [name="' + name + '[]"]').filter(":checked").length > 0;
      if (!checked) {
        valid = false;
        if (showErrors) {
          $(this).addClass("is-invalid");
          $('[data-error-for="' + name + '"]').text(messages[name] || "Please choose an option.");
        }
      }
    });

    return valid;
  }

  function validateAll() {
    let valid = true;
    for (let i = 0; i < totalSteps; i++) {
      if (!stepComplete(i, true)) {
        valid = false;
        if (state.currentStep !== i) {
          showStep(i);
        }
        scrollToFirstError();
        break;
      }
    }
    return valid;
  }

  function scrollToFirstError() {
    const $target = $(".is-invalid, .field-error").filter(function () {
      return $(this).hasClass("is-invalid") || $.trim($(this).text()) !== "";
    }).first();
    if ($target.length) {
      $("html, body").animate({ scrollTop: Math.max(0, $target.offset().top - 120) }, 260);
    }
  }

  function showStep(index) {
    state.currentStep = Math.max(0, Math.min(totalSteps - 1, index));
    $steps.removeClass("active").eq(state.currentStep).addClass("active");
    updateUi();
    $("html, body").animate({ scrollTop: $(".listing-card").offset().top - 20 }, 180);
  }

  function updateUi() {
    const percent = Math.round((state.currentStep / (totalSteps - 1)) * 100);
    $("#progressFill").css("width", percent + "%");

    $dots.each(function (index) {
      $(this)
        .toggleClass("active", index === state.currentStep)
        .toggleClass("complete", index <= state.maxCompletedStep && index < state.currentStep);
    });

    $("#prevStep").toggleClass("invisible", state.currentStep === 0);
    $("#nextStep").toggleClass("d-none", state.currentStep === totalSteps - 1);
    $("#submitListing").toggleClass("d-none", state.currentStep !== totalSteps - 1);
    $("#nextStep").prop("disabled", !stepComplete(state.currentStep, false));
    $("#imagePaths").val(JSON.stringify(state.images.map(function (image) { return image.path; })));
    $("#draftId").val(state.draftId);
  }

  function saveDraft() {
    saveLocal();
    return $.ajax({
      url: state.draftId ? "../config/property-draft-update.php" : "../config/property-draft-save.php",
      method: "POST",
      dataType: "json",
      data: {
        draft_id: state.draftId,
        payload: JSON.stringify(getPayload()),
        image_paths: JSON.stringify(state.images.map(function (image) { return image.path; })),
        last_completed_step: state.maxCompletedStep,
        completion_percentage: Math.round((state.maxCompletedStep / totalSteps) * 100)
      }
    }).done(function (response) {
      if (response.status === "success") {
        state.draftId = response.draft_id || state.draftId;
        $("#draftId").val(state.draftId);
        saveLocal();
        setDraftStatus("Draft saved successfully");
      }
    });
  }

  function scheduleAutoSave() {
    clearTimeout(autosaveTimer);
    autosaveTimer = setTimeout(function () {
      saveDraft();
    }, 1400);
  }

  function renderImages() {
    const $grid = $("#imagePreviewGrid").empty();
    state.images.forEach(function (image, index) {
      const src = image.path.indexOf("uploads/") === 0 ? imageBase + image.path : image.path;
      const $item = $(
        '<div class="image-preview">' +
          '<img alt="Property image preview">' +
          '<button type="button" aria-label="Remove image"><i class="bi bi-x"></i></button>' +
          '<span></span>' +
        '</div>'
      );
      $item.find("img").attr("src", src);
      $item.find("span").text(image.name || "Property image");
      $item.find("button").on("click", function () {
        removeImage(index);
      });
      $grid.append($item);
    });
    updateUi();
  }

  function uploadFiles(fileList) {
    const files = Array.from(fileList || []);
    const valid = [];
    const errors = [];
    const allowed = ["image/jpeg", "image/png", "image/webp"];

    files.forEach(function (file) {
      if (state.images.length + valid.length >= 15) {
        errors.push("A maximum of 15 images is allowed.");
      } else if (allowed.indexOf(file.type) === -1) {
        errors.push(file.name + " must be JPG, PNG, or WEBP.");
      } else if (file.size > 5 * 1024 * 1024) {
        errors.push(file.name + " is larger than 5MB.");
      } else {
        valid.push(file);
      }
    });

    if (errors.length) {
      $('[data-error-for="images"]').text(errors.join(" "));
    }
    if (!valid.length) {
      return;
    }

    const formData = new FormData();
    valid.forEach(function (file) {
      formData.append("images[]", file);
    });
    formData.append("existing_count", state.images.length);

    $("#uploadProgress").show().attr("aria-hidden", "false");
    $("#uploadProgressBar").css("width", "0%");
    $("#uploadProgressText").text("Uploading images...");

    $.ajax({
      url: "../config/property-images.php",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      xhr: function () {
        const xhr = $.ajaxSettings.xhr();
        if (xhr.upload) {
          xhr.upload.addEventListener("progress", function (event) {
            if (event.lengthComputable) {
              const percent = Math.round((event.loaded / event.total) * 100);
              $("#uploadProgressBar").css("width", percent + "%");
              $("#uploadProgressText").text(percent + "% uploaded");
            }
          });
        }
        return xhr;
      }
    }).done(function (response) {
      if (response.status === "success") {
        state.images = state.images.concat(response.images || []);
        $('[data-error-for="images"]').text((response.errors || []).join(" "));
        renderImages();
        state.isDirty = true;
        saveDraft();
      } else {
        $('[data-error-for="images"]').text(response.message || "Upload failed.");
      }
    }).fail(function (xhr) {
      const response = xhr.responseJSON || {};
      $('[data-error-for="images"]').text(response.message || "Upload failed. Please try again.");
    }).always(function () {
      setTimeout(function () {
        $("#uploadProgress").hide().attr("aria-hidden", "true");
      }, 700);
    });
  }

  function removeImage(index) {
    const image = state.images[index];
    state.images.splice(index, 1);
    renderImages();
    state.isDirty = true;
    saveLocal();

    if (image && image.path && image.path.indexOf("uploads/properties/tmp/") === 0) {
      $.post("../config/property-images.php", { action: "delete", path: image.path });
    }
  }

  function loadLocalDraft() {
    try {
      const local = JSON.parse(localStorage.getItem(storageKey) || "{}");
      if (local && local.payload) {
        applyPayload(local.payload);
        state.images = local.images || [];
        state.draftId = local.draft_id || "";
        state.maxCompletedStep = local.max_completed_step || 0;
        renderImages();
        showStep(local.current_step || 0);
      }
    } catch (error) {
      localStorage.removeItem(storageKey);
    }
  }

  function promptServerDraft() {
    $.ajax({
      url: "../config/property-draft-get.php",
      method: "GET",
      dataType: "json"
    }).done(function (response) {
      if (!response.draft) {
        return;
      }

      const modal = new bootstrap.Modal(document.getElementById("draftModal"));
      $("#continueDraft").off("click").on("click", function () {
        const draft = response.draft;
        state.draftId = draft.id;
        state.images = draft.images || [];
        state.maxCompletedStep = draft.last_completed_step || 0;
        applyPayload(draft.payload || {});
        renderImages();
        showStep(Math.min(state.maxCompletedStep, totalSteps - 1));
        saveLocal();
        setDraftStatus("Draft restored");
        modal.hide();
      });
      $("#startFresh").off("click").on("click", function () {
        localStorage.removeItem(storageKey);
        state.draftId = response.draft.id;
        setDraftStatus("Fresh draft started");
      });
      modal.show();
    });
  }

  $("#nextStep").on("click", function () {
    if (!stepComplete(state.currentStep, true)) {
      scrollToFirstError();
      updateUi();
      return;
    }
    state.maxCompletedStep = Math.max(state.maxCompletedStep, state.currentStep + 1);
    state.isDirty = true;
    saveDraft();
    showStep(state.currentStep + 1);
  });

  $("#prevStep").on("click", function () {
    showStep(state.currentStep - 1);
  });

  $dots.on("click", function () {
    const target = Number($(this).data("step-target"));
    if (target <= state.maxCompletedStep || target < state.currentStep) {
      showStep(target);
    }
  });

  $form.on("input change", "input", function () {
    state.isDirty = true;
    saveLocal();
    scheduleAutoSave();
    updateUi();
  });

  $("#dropzone").on("click", function () {
    $("#propertyImages").trigger("click");
  }).on("dragover", function (event) {
    event.preventDefault();
    $(this).addClass("dragover");
  }).on("dragleave drop", function (event) {
    event.preventDefault();
    $(this).removeClass("dragover");
    if (event.type === "drop") {
      uploadFiles(event.originalEvent.dataTransfer.files);
    }
  });

  $("#propertyImages").on("change", function () {
    uploadFiles(this.files);
    this.value = "";
  });

  $form.on("submit", function (event) {
    event.preventDefault();
    if (state.isSubmitting || !validateAll()) {
      return;
    }

    state.isSubmitting = true;
    $("#submitListing").prop("disabled", true);
    $("#submitSpinner").removeClass("d-none");
    setAlert("", "");

    const formData = new FormData(this);
    formData.set("draft_id", state.draftId);
    formData.set("image_paths", JSON.stringify(state.images.map(function (image) { return image.path; })));

    $.ajax({
      url: "../config/property-submit.php",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json"
    }).done(function (response) {
      if (response.status === "success") {
        state.submitted = true;
        state.isDirty = false;
        localStorage.removeItem(storageKey);
        setAlert("success", response.message);
        setDraftStatus("Submitted");
        setTimeout(function () {
          window.location.href = response.redirect || "dashboard.php";
        }, 1200);
      } else {
        setAlert("danger", response.message || "Submission failed.");
      }
    }).fail(function (xhr) {
      const response = xhr.responseJSON || {};
      if (response.errors) {
        Object.keys(response.errors).forEach(function (field) {
          $('[data-error-for="' + field + '"]').text(response.errors[field]);
          $('[name="' + field + '"], [name="' + field + '[]"]').addClass("is-invalid");
          $('[data-required-group="' + field + '"]').addClass("is-invalid");
        });
        scrollToFirstError();
      }
      setAlert("danger", response.message || "The listing could not be submitted.");
    }).always(function () {
      state.isSubmitting = false;
      $("#submitListing").prop("disabled", false);
      $("#submitSpinner").addClass("d-none");
    });
  });

  window.addEventListener("beforeunload", function (event) {
    if (state.isDirty && !state.submitted) {
      event.preventDefault();
      event.returnValue = "";
    }
  });

  loadLocalDraft();
  promptServerDraft();
  updateUi();
})(jQuery);
