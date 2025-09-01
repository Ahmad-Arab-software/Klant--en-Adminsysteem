
<?php
// File: /test_PH/klant/logic/upload_temp_file.logic.php

// Good practice for production: log errors, don't display them
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// The database connection is not used here, so it can be safely removed to make the script faster.
// require_once __DIR__ . '/../../config/database.php';

// These paths are defined correctly.
define('PROJECT_ROOT', dirname(__DIR__, 2));
define('TEMP_UPLOAD_DIR_ABS', PROJECT_ROOT . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR);
define('TEMP_UPLOAD_DIR_REL', 'uploads/temp/');

function sendJsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("[upload_temp_file] Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    sendJsonResponse(['status' => 'error', 'message' => 'Invalid request method.']);
}

// --- VERBETERDE FOUTAFHANDELING ---
// Check if the file key exists and if there was an upload error.
if (!isset($_FILES['product_file']) || $_FILES['product_file']['error'] !== UPLOAD_ERR_OK) {
    $error_code = $_FILES['product_file']['error'] ?? UPLOAD_ERR_NO_FILE;

    // Create a map of error codes to human-readable messages
    $error_messages = [
        UPLOAD_ERR_INI_SIZE   => 'Het bestand is te groot (serverlimiet: upload_max_filesize).',
        UPLOAD_ERR_FORM_SIZE  => 'Het bestand is te groot (formulierlimiet).',
        UPLOAD_ERR_PARTIAL    => 'Het bestand is slechts gedeeltelijk geüpload.',
        UPLOAD_ERR_NO_FILE    => 'Er is geen bestand geselecteerd om te uploaden.',
        UPLOAD_ERR_NO_TMP_DIR => 'Serverfout: de tijdelijke map ontbreekt.',
        UPLOAD_ERR_CANT_WRITE => 'Serverfout: Kan bestand niet naar schijf schrijven. Controleer de maprechten. (Fout 7)',
        UPLOAD_ERR_EXTENSION  => 'Een PHP-extensie heeft de upload gestopt.',
    ];

    // Get the specific message or a default one
    $message = $error_messages[$error_code] ?? "Onbekende uploadfout ({$error_code}).";

    error_log("[upload_temp_file] Upload error: " . $message);
    sendJsonResponse(['status' => 'error', 'message' => $message]);
}
// --- EINDE VERBETERDE FOUTAFHANDELING ---


$file = $_FILES['product_file'];
$original_filename = basename($file['name']);
$temp_file_path = $file['tmp_name'];
$file_size = $file['size'];
$file_type = $file['type'];

$max_file_size_bytes = 500 * 1024 * 1024; // 500 MB
if ($file_size > $max_file_size_bytes) {
    sendJsonResponse(['status' => 'error', 'message' => 'Bestand is te groot. Maximaal 500MB.']);
}

// This list of allowed extensions is fine.
$allowed_extensions = ['png', 'jpg', 'jpeg', 'gif', 'pdf', 'ai', 'eps', 'svg', 'zip', 'rar'];
$file_extension = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
if (!in_array($file_extension, $allowed_extensions)) {
    sendJsonResponse(['status' => 'error', 'message' => 'Ongeldig bestandstype.']);
}

// Your directory checks are excellent.
if (!is_dir(TEMP_UPLOAD_DIR_ABS)) {
    if (!mkdir(TEMP_UPLOAD_DIR_ABS, 0755, true)) {
        error_log("[upload_temp_file] Kan tijdelijke upload map niet aanmaken: " . TEMP_UPLOAD_DIR_ABS);
        sendJsonResponse(['status' => 'error', 'message' => 'Serverfout: Kan tijdelijke map niet aanmaken.']);
    }
}
if (!is_writable(TEMP_UPLOAD_DIR_ABS)) {
    error_log("[upload_temp_file] Tijdelijke upload map is niet schrijfbaar: " . TEMP_UPLOAD_DIR_ABS);
    sendJsonResponse(['status' => 'error', 'message' => 'Serverfout: Tijdelijke map is niet schrijfbaar. Controleer de serverrechten.']);
}

$unique_filename = uniqid('temp_') . '_' . bin2hex(random_bytes(8)) . '.' . $file_extension;
$destination_path_abs = TEMP_UPLOAD_DIR_ABS . $unique_filename;
$destination_path_rel = TEMP_UPLOAD_DIR_REL . $unique_filename;

if (move_uploaded_file($temp_file_path, $destination_path_abs)) {
    sendJsonResponse([
        'status' => 'success',
        'message' => 'Bestand succesvol geüpload.',
        'temp_file_path' => $destination_path_rel,
        'original_filename' => $original_filename,
        'file_size' => $file_size,
        'file_type' => $file_type
    ]);
} else {
    $error = error_get_last();
    error_log("[upload_temp_file] Fout bij move_uploaded_file: " . ($error['message'] ?? 'Onbekende fout'));
    sendJsonResponse(['status' => 'error', 'message' => 'Kon bestand niet opslaan op de server.']);
}