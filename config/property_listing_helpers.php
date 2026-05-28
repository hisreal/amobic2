<?php
declare(strict_types=1);

require_once __DIR__ . "/dbh.php";

function pl_json(string $status, string $message, array $data = [], int $code = 200): void
{
    http_response_code($code);
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode(array_merge([
        "status" => $status,
        "message" => $message,
    ], $data));
    exit;
}

function pl_require_user(): int
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION["guest_id"], $_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
        pl_json("error", "Please log in to continue.", [], 401);
    }

    return (int) $_SESSION["guest_id"];
}

function pl_clean(?string $value, int $max = 255): string
{
    $value = trim((string) $value);
    $value = preg_replace('/\s+/', ' ', $value) ?? "";
    if (function_exists("mb_substr")) {
        return mb_substr($value, 0, $max, "UTF-8");
    }

    return substr($value, 0, $max);
}

function pl_clean_array($values, array $allowed): array
{
    if (!is_array($values)) {
        return [];
    }

    $clean = [];
    foreach ($values as $value) {
        $value = pl_clean((string) $value, 80);
        if (in_array($value, $allowed, true) && !in_array($value, $clean, true)) {
            $clean[] = $value;
        }
    }

    return $clean;
}

function pl_allowed(): array
{
    return [
        "property_types" => ["Apartment", "House", "Villa", "Townhouse", "Penthouse", "Studio", "Cottage"],
        "bedrooms" => ["Studio", "1", "2", "3", "4", "5+"],
        "bathrooms" => ["1", "2", "3", "4", "5+"],
        "parking" => ["None", "1 Bay", "2 Bays", "Garage", "Street Only"],
        "occupancy_type" => ["Short-Term Only", "Long-Term Only", "Both"],
        "furnishing_status" => ["Unfurnished", "Semi-Furnished", "Fully Furnished"],
        "yes_no" => ["Yes", "No"],
        "wifi_speed" => ["Not Sure", "Under 10 Mbps", "10-25 Mbps", "25-50 Mbps", "50-100 Mbps", "100+ Mbps"],
        "load_shedding_solution" => ["None", "UPS", "Inverter", "Generator", "Solar Backup"],
        "smoking_policy" => ["No Smoking", "Outdoor Only", "Smoking Allowed"],
        "events_parties" => ["Not Allowed", "Allowed With Approval", "Allowed"],
        "pets_allowed" => ["No Pets", "Cats Only", "Dogs Only", "Small Pets Only", "Pets Allowed"],
    ];
}

function pl_payload_from_request(array $source): array
{
    $allowed = pl_allowed();

    return [
        "full_address" => pl_clean($source["full_address"] ?? "", 255),
        "suburb_area" => pl_clean($source["suburb_area"] ?? "", 160),
        "landmark" => pl_clean($source["landmark"] ?? "", 160),
        "property_types" => pl_clean_array($source["property_types"] ?? [], $allowed["property_types"]),
        "bedrooms" => pl_select($source["bedrooms"] ?? "", $allowed["bedrooms"]),
        "bathrooms" => pl_select($source["bathrooms"] ?? "", $allowed["bathrooms"]),
        "parking" => pl_select($source["parking"] ?? "", $allowed["parking"]),
        "occupancy_type" => pl_select($source["occupancy_type"] ?? "", $allowed["occupancy_type"]),
        "furnishing_status" => pl_select($source["furnishing_status"] ?? "", $allowed["furnishing_status"]),
        "wifi_internet" => pl_select($source["wifi_internet"] ?? "", $allowed["yes_no"]),
        "wifi_speed" => pl_select($source["wifi_speed"] ?? "", $allowed["wifi_speed"], true),
        "load_shedding_solution" => pl_select($source["load_shedding_solution"] ?? "", $allowed["load_shedding_solution"]),
        "air_conditioning" => pl_select($source["air_conditioning"] ?? "", $allowed["yes_no"]),
        "swimming_pool" => pl_select($source["swimming_pool"] ?? "", $allowed["yes_no"]),
        "braai_outdoor_area" => pl_select($source["braai_outdoor_area"] ?? "", $allowed["yes_no"]),
        "washing_machine" => pl_select($source["washing_machine"] ?? "", $allowed["yes_no"]),
        "access_control" => pl_select($source["access_control"] ?? "", $allowed["yes_no"]),
        "cctv_alarm" => pl_select($source["cctv_alarm"] ?? "", $allowed["yes_no"]),
        "smoking_policy" => pl_select($source["smoking_policy"] ?? "", $allowed["smoking_policy"]),
        "events_parties" => pl_select($source["events_parties"] ?? "", $allowed["events_parties"]),
        "pets_allowed" => pl_select($source["pets_allowed"] ?? "", $allowed["pets_allowed"]),
    ];
}

function pl_select($value, array $allowed, bool $optional = false): string
{
    $value = pl_clean((string) $value, 80);
    if ($optional && $value === "") {
        return "";
    }
    return in_array($value, $allowed, true) ? $value : "";
}

function pl_validate_payload(array $payload, bool $final = false): array
{
    $errors = [];
    $required = [
        "full_address" => "Full property address is required.",
        "suburb_area" => "Suburb / Area is required.",
        "bedrooms" => "Select the bedroom count.",
        "bathrooms" => "Select the bathroom count.",
        "parking" => "Select a parking option.",
        "occupancy_type" => "Select an occupancy type.",
        "furnishing_status" => "Select furnishing status.",
        "wifi_internet" => "Select WiFi / Internet availability.",
        "load_shedding_solution" => "Select a load-shedding solution.",
        "air_conditioning" => "Select air conditioning availability.",
        "swimming_pool" => "Select swimming pool availability.",
        "braai_outdoor_area" => "Select braai / outdoor area availability.",
        "washing_machine" => "Select washing machine availability.",
        "access_control" => "Select access control availability.",
        "cctv_alarm" => "Select CCTV / Alarm availability.",
        "smoking_policy" => "Select a smoking policy.",
        "events_parties" => "Select events / parties policy.",
        "pets_allowed" => "Select pets policy.",
    ];

    foreach ($required as $field => $message) {
        if (($payload[$field] ?? "") === "") {
            $errors[$field] = $message;
        }
    }

    if (empty($payload["property_types"])) {
        $errors["property_types"] = "Select at least one property type.";
    }

    if ($final && strlen($payload["full_address"]) < 8) {
        $errors["full_address"] = "Please enter a more complete property address.";
    }

    return $errors;
}

function pl_project_path(string $relative): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $relative);
}

function pl_safe_relative_path(string $path): string
{
    $path = trim($path);
    $path = str_replace("\\", "/", $path);
    $path = ltrim($path, "/");

    if (!preg_match('#^uploads/properties/(tmp/[0-9]+/|[0-9]+/)[A-Za-z0-9._-]+\.(jpg|jpeg|png|webp)$#i', $path)) {
        return "";
    }

    return $path;
}
