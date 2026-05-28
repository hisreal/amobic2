<?php
declare(strict_types=1);

require_once __DIR__ . "/property_listing_helpers.php";

$userId = pl_require_user();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $stmt = $conn->prepare("SELECT id, draft_token, payload_json, image_paths, completion_percentage, last_completed_step, updated_at FROM property_drafts WHERE user_id = ? AND status = 'in_progress' ORDER BY updated_at DESC LIMIT 1");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $draft = $result->fetch_assoc();
    $stmt->close();

    if (!$draft) {
        pl_json("success", "No unfinished draft found.", ["draft" => null]);
    }

    $draft["payload"] = json_decode($draft["payload_json"], true) ?: [];
    $draft["images"] = json_decode($draft["image_paths"] ?? "[]", true) ?: [];
    unset($draft["payload_json"], $draft["image_paths"]);

    pl_json("success", "Draft found.", ["draft" => $draft]);
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    pl_json("error", "Invalid request method.", [], 405);
}

$rawPayload = json_decode($_POST["payload"] ?? "[]", true);
if (!is_array($rawPayload)) {
    pl_json("error", "Invalid draft payload.", [], 422);
}

$payload = pl_payload_from_request($rawPayload);
$images = json_decode($_POST["image_paths"] ?? "[]", true);
$images = is_array($images) ? array_values(array_filter(array_map("pl_safe_relative_path", $images))) : [];
$lastStep = max(0, min(5, (int) ($_POST["last_completed_step"] ?? 0)));
$completion = max(0, min(100, (int) ($_POST["completion_percentage"] ?? 0)));
$draftId = (int) ($_POST["draft_id"] ?? 0);
$payloadJson = json_encode($payload, JSON_UNESCAPED_SLASHES);
$imagesJson = json_encode($images, JSON_UNESCAPED_SLASHES);

if ($draftId > 0) {
    $stmt = $conn->prepare("UPDATE property_drafts SET payload_json = ?, image_paths = ?, completion_percentage = ?, last_completed_step = ? WHERE id = ? AND user_id = ? AND status = 'in_progress'");
    $stmt->bind_param("ssiiii", $payloadJson, $imagesJson, $completion, $lastStep, $draftId, $userId);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();

    if ($affected >= 0) {
        pl_json("success", "Draft saved successfully.", ["draft_id" => $draftId]);
    }
}

$stmt = $conn->prepare("SELECT id FROM property_drafts WHERE user_id = ? AND status = 'in_progress' LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$existing = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($existing) {
    $draftId = (int) $existing["id"];
    $stmt = $conn->prepare("UPDATE property_drafts SET payload_json = ?, image_paths = ?, completion_percentage = ?, last_completed_step = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssiiii", $payloadJson, $imagesJson, $completion, $lastStep, $draftId, $userId);
    $stmt->execute();
    $stmt->close();
    pl_json("success", "Draft saved successfully.", ["draft_id" => $draftId]);
}

$draftToken = bin2hex(random_bytes(16));
$stmt = $conn->prepare("INSERT INTO property_drafts (user_id, draft_token, payload_json, image_paths, completion_percentage, last_completed_step) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssii", $userId, $draftToken, $payloadJson, $imagesJson, $completion, $lastStep);
$stmt->execute();
$draftId = $stmt->insert_id;
$stmt->close();

pl_json("success", "Draft saved successfully.", ["draft_id" => $draftId]);
