<?php
declare(strict_types=1);

require_once __DIR__ . "/property_listing_helpers.php";

$userId = pl_require_user();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    pl_json("error", "Invalid request method.", [], 405);
}

$payload = pl_payload_from_request($_POST);
$errors = pl_validate_payload($payload, true);

$images = json_decode($_POST["image_paths"] ?? "[]", true);
$images = is_array($images) ? array_values(array_filter(array_map("pl_safe_relative_path", $images))) : [];
if (count($images) > 15) {
    $errors["images"] = "You can upload a maximum of 15 images.";
}

if (!empty($errors)) {
    pl_json("error", "Please correct the highlighted fields.", ["errors" => $errors], 422);
}

$draftId = (int) ($_POST["draft_id"] ?? 0);
$propertyTypesJson = json_encode($payload["property_types"], JSON_UNESCAPED_SLASHES);
$payloadJson = json_encode($payload, JSON_UNESCAPED_SLASHES);

$conn->begin_transaction();

try {
    $stmt = $conn->prepare(
        "INSERT INTO properties (
            user_id, draft_id, full_address, suburb_area, landmark, property_types, bedrooms, bathrooms,
            parking, occupancy_type, furnishing_status, wifi_internet, wifi_speed, load_shedding_solution,
            air_conditioning, swimming_pool, braai_outdoor_area, washing_machine, access_control, cctv_alarm,
            smoking_policy, events_parties, pets_allowed, payload_json
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "iissssssssssssssssssssss",
        $userId,
        $draftId,
        $payload["full_address"],
        $payload["suburb_area"],
        $payload["landmark"],
        $propertyTypesJson,
        $payload["bedrooms"],
        $payload["bathrooms"],
        $payload["parking"],
        $payload["occupancy_type"],
        $payload["furnishing_status"],
        $payload["wifi_internet"],
        $payload["wifi_speed"],
        $payload["load_shedding_solution"],
        $payload["air_conditioning"],
        $payload["swimming_pool"],
        $payload["braai_outdoor_area"],
        $payload["washing_machine"],
        $payload["access_control"],
        $payload["cctv_alarm"],
        $payload["smoking_policy"],
        $payload["events_parties"],
        $payload["pets_allowed"],
        $payloadJson
    );
    $stmt->execute();
    $propertyId = $stmt->insert_id;
    $stmt->close();

    $finalDirRelative = "uploads/properties/" . $userId;
    $finalDir = pl_project_path($finalDirRelative);
    if (!is_dir($finalDir)) {
        mkdir($finalDir, 0755, true);
    }

    $sort = 0;
    foreach ($images as $path) {
        $source = pl_project_path($path);
        if (!is_file($source)) {
            continue;
        }

        $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));
        $filename = "property_" . $propertyId . "_" . bin2hex(random_bytes(8)) . "." . $extension;
        $targetRelative = $finalDirRelative . "/" . $filename;
        $target = pl_project_path($targetRelative);

        if (!rename($source, $target)) {
            copy($source, $target);
            unlink($source);
        }

        $originalName = basename($path);
        $stmt = $conn->prepare("INSERT INTO property_images (property_id, user_id, image_path, original_name, sort_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissi", $propertyId, $userId, $targetRelative, $originalName, $sort);
        $stmt->execute();
        $stmt->close();
        $sort++;
    }

    if ($draftId > 0) {
        $stmt = $conn->prepare("UPDATE property_drafts SET status = 'completed', completed_at = NOW(), completion_percentage = 100 WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $draftId, $userId);
        $stmt->execute();
        $stmt->close();
    }

    $conn->commit();

    pl_json("success", "Property listing submitted successfully.", [
        "property_id" => $propertyId,
        "redirect" => "dashboard.php",
    ]);
} catch (Throwable $exception) {
    $conn->rollback();
    pl_json("error", "The listing could not be saved. Please try again.", [
        "debug" => defined("APP_DEBUG") && APP_DEBUG ? $exception->getMessage() : null,
    ], 500);
}
