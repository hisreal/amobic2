/* =========================================================
   OTP CODE INPUT AUTO NAVIGATION
   ========================================================= */

/* Select all OTP input fields */
const inputs = document.querySelectorAll(".amobic-code-inputs input");

/* Loop through each input field */
inputs.forEach((input, index) => {

  /* Listen for typing inside each OTP box */
  input.addEventListener("input", () => {

    /* Allow only numbers */
    input.value = input.value.replace(/[^0-9]/g, "");

    /* Automatically move to the next input box */
    if (input.value && index < inputs.length - 1) {
      inputs[index + 1].focus();
    }
  });

  /* Listen for keyboard actions */
  input.addEventListener("keydown", (e) => {

    /* If backspace is pressed on an empty field,
       move focus back to previous input */
    if (e.key === "Backspace" && !input.value && index > 0) {
      inputs[index - 1].focus();
    }
  });
});



/* =========================================================
   SHOW / HIDE PASSWORD TOGGLE
   ========================================================= */

/*
  Function to toggle password visibility

  Parameters:
  id      = ID of password input field
  button  = button clicked containing the icon
*/
function togglePassword(id, button) {

  /* Get password input field */
  const input = document.getElementById(id);

  /* Get eye icon inside button */
  const icon = button.querySelector("i");

  /* If password is hidden */
  if (input.type === "password") {

    /* Show password */
    input.type = "text";

    /* Change icon to eye-slash */
    icon.classList.remove("bi-eye");
    icon.classList.add("bi-eye-slash");

  } else {

    /* Hide password */
    input.type = "password";

    /* Restore eye icon */
    icon.classList.remove("bi-eye-slash");
    icon.classList.add("bi-eye");
  }
}



/* =========================================================
   PROPERTY IMAGE PREVIEW SYSTEM
   ========================================================= */

/* Get image upload input */
const propertyImages = document.getElementById("propertyImages");

/* Get image preview container */
const imagePreview = document.getElementById("imagePreview");

/* Store selected image files */
let selectedFiles = [];


/* Listen for image selection */
propertyImages.addEventListener("change", function () {

  /* Convert uploaded files into array */
  selectedFiles = Array.from(this.files);

  /* Render image previews */
  renderPreview();
});


/* =========================================================
   RENDER IMAGE PREVIEW FUNCTION
   ========================================================= */

function renderPreview() {

  /* Clear existing previews */
  imagePreview.innerHTML = "";

  /* Loop through selected images */
  selectedFiles.forEach((file, index) => {

    /* Create file reader */
    const reader = new FileReader();

    /* When image loads */
    reader.onload = function (e) {

      /* Create preview wrapper */
      const item = document.createElement("div");

      /* Add preview item class */
      item.className = "amobic-preview-item";

      /* Create preview image and remove button */
      item.innerHTML = `
        <img src="${e.target.result}" alt="Property image preview">

        <button
          type="button"
          class="amobic-remove-image"
          onclick="removeImage(${index})"
        >
          <i class="bi bi-x"></i>
        </button>
      `;

      /* Add preview item to container */
      imagePreview.appendChild(item);
    };

    /* Read uploaded image */
    reader.readAsDataURL(file);
  });
}



/* =========================================================
   REMOVE IMAGE FUNCTION
   ========================================================= */

/*
  Remove image from preview and input file list
*/
function removeImage(index) {

  /* Remove selected image from array */
  selectedFiles.splice(index, 1);

  /* Create new DataTransfer object */
  const dataTransfer = new DataTransfer();

  /* Rebuild remaining file list */
  selectedFiles.forEach(file =>
    dataTransfer.items.add(file)
  );

  /* Update actual input files */
  propertyImages.files = dataTransfer.files;

  /* Re-render preview */
  renderPreview();
}
/* multiple select dropdown for amenities */
new SlimSelect({
  select: "#amenities",
  settings: {
    placeholderText: "Amenities",
    allowDeselect: true,
    closeOnSelect: false
  }
});
/* multiple select dropdown for guests, property type and price range */
new SlimSelect({ select: "#guests" });
new SlimSelect({ select: "#property-type" });
new SlimSelect({ select: "#price-range" });

  