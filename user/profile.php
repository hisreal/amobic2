<?php require_once("header.php"); ?>
<?php

$user_id = $_SESSION['guest_id'];

/* =========================================
   FETCH USER DATA
========================================= */

$stmt = $conn->prepare("
    SELECT
        first_name,
        last_name,
        email,
        phone,
        sex,
        dob,
        preferred_currency,
        preferred_language,
        bio
    
    FROM amobic_users
    WHERE id = ?
    LIMIT 1
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("User not found.");
}

$user = $result->fetch_assoc();

?>

<div class="amobic-sidebar-overlay" id="sidebarOverlay"></div>

<main class="amobic-dashboard-main">

    <section class="amobic-profile-section">

        <div class="amobic-profile-card">
      
          <div class="amobic-profile-header">
      
            <div class="amobic-profile-avatar-wrap">
      
              <img
                src="../assets/img/logo/placeholder.jpg"
                alt="Profile"
                class="amobic-profile-avatar"
              >
      
              <label class="amobic-profile-upload">
                <input type="file" hidden>
                <i class="bi bi-camera"></i>
              </label>
      
            </div>
      
            <div class="amobic-profile-header-txt">
              <h3>Profile Settings</h3>
              <p>
                Manage your personal information and account details.
              </p>
            </div>
      
          </div>
      
      
          <form method="post" id="profileUpdateForm" class="amobic-profile-form">
    <input type="hidden" name="update-profile" value="1">
            <div class="row ul-bs-row">
                <div class="col-md-4">
                    <div class="amobic-profile-group">

                        <label>First Name</label>

                        <input
                            type="text"
                            name="first_name"
                            value="<?= htmlspecialchars($user['first_name']); ?>"
                        >

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="amobic-profile-group">

                        <label>Last Name</label>

                        <input
                            type="text"
                            name="last_name"
                            value="<?= htmlspecialchars($user['last_name']); ?>"
                        >

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="amobic-profile-group">

                        <label>Email Address</label>

                        <input
                            type="email"
                            name="email"
                            value="<?= htmlspecialchars($user['email']); ?>"
                            readonly
                        >

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="amobic-profile-group">

                        <label>Phone Number</label>

                        <input
                            type="text"
                            name="phone"
                            value="<?= htmlspecialchars($user['phone']); ?>"
                        >

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="amobic-profile-group">

                        <label>Gender</label>

                        <select name="sex">

                            <option value="Male"
                                <?= ($user['sex'] == 'Male') ? 'selected' : ''; ?>>
                                Male
                            </option>

                            <option value="Female"
                                <?= ($user['sex'] == 'Female') ? 'selected' : ''; ?>>
                                Female
                            </option>

                        </select>

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="amobic-profile-group">

                        <label>Date of Birth</label>

                        <input
                            type="date"
                            name="dob"
                            value="<?= htmlspecialchars($user['dob']); ?>"
                        >

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="amobic-profile-group">

                        <label>Preferred Currency</label>

                        <select name="preferred_currency" required>

                            <option value="USD"
                                <?= ($user['preferred_currency'] == 'USD') ? 'selected' : ''; ?>>
                                USD - US Dollar
                            </option>

                            <option value="GBP"
                                <?= ($user['preferred_currency'] == 'GBP') ? 'selected' : ''; ?>>
                                GBP - British Pound
                            </option>

                            <option value="EUR"
                                <?= ($user['preferred_currency'] == 'EUR') ? 'selected' : ''; ?>>
                                EUR - Euro
                            </option>

                            <option value="NGN"
                                <?= ($user['preferred_currency'] == 'NGN') ? 'selected' : ''; ?>>
                                NGN - Nigerian Naira
                            </option>

                            <option value="ZAR"
                                <?= ($user['preferred_currency'] == 'ZAR') ? 'selected' : ''; ?>>
                                ZAR - South African Rand
                            </option>

                        </select>

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="amobic-profile-group">

                        <label>Preferred Language</label>

                        <select name="preferred_language" required>

                            <option value="en"
                                <?= ($user['preferred_language'] == 'en') ? 'selected' : ''; ?>>
                                English
                            </option>

                            <option value="fr"
                                <?= ($user['preferred_language'] == 'fr') ? 'selected' : ''; ?>>
                                French
                            </option>

                            <option value="es"
                                <?= ($user['preferred_language'] == 'es') ? 'selected' : ''; ?>>
                                Spanish
                            </option>

                            <option value="pt"
                                <?= ($user['preferred_language'] == 'pt') ? 'selected' : ''; ?>>
                                Portuguese
                            </option>

                        </select>

                    </div>
                </div>


                <div class="col-12">
                    <div class="amobic-profile-group">

                        <label>Bio</label>

                        <textarea
                            name="bio"
                            rows="5"
                            placeholder="Tell us about yourself..."
                        ><?= htmlspecialchars($user['bio']); ?></textarea>

                    </div>
                    <div id="alertMessage" class="alert-message"></div>
                </div>

            </div>


            <div class="amobic-profile-actions">

                <button
                    type="submit"
                    id="submitBtn"
              
                    class="ul-btn"
                >
                    Save Changes
                </button>

            </div>

            </form>
                  
        </div>
      
      </section>
    

</main>


<?php require_once("footer.php"); ?>