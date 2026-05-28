<?php
declare(strict_types=1);

require_once __DIR__ . "/property_listing_helpers.php";

$userId = pl_require_user();
$maxFiles = 15;
$maxBytes = 5 * 1024 * 1024;
$allowedMime = [
    "image/jpeg" => "jpg",
    "image/png" => "png",
    "image/webp" => "webp",
];

function pl_compress_image(string $source, string $destination, string $mime): bool
{
    if (!extension_loaded("gd")) {
        return move_uploaded_file($source, $destination);
    }

    if ($mime === "image/jpeg") {
        $image = imagecreatefromjpeg($source);
        $ok = $image ? imagejpeg($image, $destination, 82) : false;
    } elseif ($mime === "image/png") {
        $image = imagecreatefrompng($source);
        if ($image) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }
        $ok = $image ? imagepng($image, $destination, 7) : false;
    } elseif ($mime === "image/webp" && function_exists("imagecreatefromwebp")) {
        $image = imagecreatefromwebp($source);
        $ok = $image ? imagewebp($image, $destination, 82) : false;
    } else {
        return move_uploaded_file($source, $destination);
    }

    if (!empty($image)) {
        imagedestroy($image);
    }

    return (bool) $ok;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "delete") {
    $path = pl_safe_relative_path($_POST["path"] ?? "");
    if ($path === "" || strpos($path, "uploads/properties/tmp/" . $userId . "/") !== 0) {
        pl_json("error", "Invalid image path.", [], 422);
    }

    $absolute = pl_project_path($path);
    if (is_file($absolute)) {
        unlink($absolute);
    }

    pl_json("success", "Image removed.");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    pl_json("error", "Invalid request method.", [], 405);
}

$existingCount = max(0, (int) ($_POST["existing_count"] ?? 0));
if (!isset($_FILES["images"])) {
    pl_json("error", "No images were uploaded.", [], 422);
}

$files = $_FILES["images"];
$fileCount = is_array($files["name"]) ? count($files["name"]) : 0;
if ($existingCount + $fileCount > $maxFiles) {
    pl_json("error", "You can upload a maximum of 15 images.", [], 422);
}

$uploadDir = pl_project_path("uploads/properties/tmp/" . $userId);
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$uploaded = [];
$errors = [];

for ($i = 0; $i < $fileCount; $i++) {
    if ($files["error"][$i] !== UPLOAD_ERR_OK) {
        $errors[] = $files["name"][$i] . " could not be uploaded.";
        continue;
    }

    if ($files["size"][$i] > $maxBytes) {
        $errors[] = $files["name"][$i] . " is larger than 5MB.";
        continue;
    }

    $mime = $finfo->file($files["tmp_name"][$i]);
    if (!isset($allowedMime[$mime])) {
        $errors[] = $files["name"][$i] . " must be JPG, PNG, or WEBP.";
        continue;
    }

    $extension = $allowedMime[$mime];
    $filename = "property_" . $userId . "_" . bin2hex(random_bytes(10)) . "." . $extension;
    $destination = $uploadDir . DIRECTORY_SEPARATOR . $filename;

    if (!pl_compress_image($files["tmp_name"][$i], $destination, $mime)) {
        $errors[] = $files["name"][$i] . " could not be processed.";
        continue;
    }

    $uploaded[] = [
        "path" => "uploads/properties/tmp/" . $userId . "/" . $filename,
        "name" => htmlspecialchars($files["name"][$i], ENT_QUOTES, "UTF-8"),
    ];
}

if (empty($uploaded) && !empty($errors)) {
    pl_json("error", implode(" ", $errors), ["errors" => $errors], 422);
}

pl_json("success", "Images uploaded successfully.", [
    "images" => $uploaded,
    "errors" => $errors,
]);
