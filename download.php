<?php
// /test_PH/download.php

// Zorg ervoor dat je database.php correct wordt ingeladen
require_once __DIR__ . '/config/database.php';

// Zorg ervoor dat sessies gestart zijn als je authenticatie gebruikt
// session_start(); // Uncomment this if you use sessions for admin login

// --- Beveiliging: Controleer of de gebruiker een admin is ---
// Dit is CRUCIAAL! Zonder dit kan iedereen met de juiste URL bestanden downloaden.
// Implementeer hier je eigen admin check logica. Bijvoorbeeld:
/*
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Niet geautoriseerd
    http_response_code(403); // Forbidden
    die("Toegang geweigerd.");
}
*/
// Voor dit voorbeeld slaan we de authenticatie over, maar voeg dit ZEKER toe in productie!
// --- Einde Beveiliging ---


// ==================================================================
// AANGEPASTE LOGICA: Gebruik 'regel_id' in plaats van 'order_id'
// ==================================================================
if (!isset($_GET['regel_id']) || !is_numeric($_GET['regel_id'])) {
    http_response_code(400); // Bad Request
    die("Ongeldige aanvraag. Regel ID ontbreekt.");
}

$regel_id = (int)$_GET['regel_id'];

// Haal het bestandspad en de originele naam op uit de 'order_regels' tabel
$sql = "SELECT bestandspad, bestand_originele_naam FROM order_regels WHERE id = ?";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$regel_id]);
    $regel_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$regel_info || empty($regel_info['bestandspad'])) {
        http_response_code(404); // Not Found
        die("Bestandsinformatie niet gevonden voor deze orderregel.");
    }

    $bestandspad_db = $regel_info['bestandspad'];
    $originele_naam = $regel_info['bestand_originele_naam'] ?? 'bestand'; // Fallback naam

    // Construct het volledige pad naar het bestand op de server
    // __DIR__ is de directory van het huidige script (/test_PH/)
    $full_file_path = __DIR__ . '/' . $bestandspad_db;

    // Controleer of het bestand daadwerkelijk bestaat op de server
    if (!file_exists($full_file_path)) {
        error_log("Fysiek bestand niet gevonden op server: " . $full_file_path);
        http_response_code(404); // Not Found
        die("Bestand niet gevonden op de server.");
    }

    // --- Bestand downloaden (logica blijft hetzelfde) ---

    // Zorg ervoor dat er geen onnodige output is voordat we headers sturen
    if (ob_get_level()) {
        ob_end_clean();
    }

    // Stel de juiste headers in voor een bestand download
    header('Content-Description: File Transfer');
    $mime_type = mime_content_type($full_file_path);
    header('Content-Type: ' . ($mime_type ?: 'application/octet-stream'));
    header('Content-Disposition: attachment; filename="' . basename($originele_naam) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($full_file_path));

    // Lees het bestand en stuur het naar de output buffer
    readfile($full_file_path);

    exit; // Stop de scriptuitvoering na het downloaden

} catch (PDOException $e) {
    // Foutafhandeling bij databasefout
    error_log("Error fetching file path for regel_id " . $regel_id . ": " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    die("Er ging iets mis bij het ophalen van de bestandsinformatie.");
} catch (Exception $e) {
    // Algemene foutafhandeling
    error_log("Error during file download for regel_id " . $regel_id . ": " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    die("Er ging iets mis tijdens het downloaden van het bestand.");
}