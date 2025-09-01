<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once __DIR__ . '/../../config/database.php';

// Definieer alle benodigde paden
define('PROJECT_ROOT', dirname(__DIR__, 2));
define('TEMP_UPLOAD_DIR_ABS', PROJECT_ROOT . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR);
define('ORDER_UPLOAD_DIR_ABS', PROJECT_ROOT . DIRECTORY_SEPARATOR . 'Orders' . DIRECTORY_SEPARATOR);
define('ORDER_UPLOAD_DIR_REL', 'Orders/');

function sendJsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(['status' => 'error', 'message' => 'Ongeldige request methode.']);
}

$klant_email = trim($_SESSION['gebruikersnaam'] . '@glr.nl' ?? '');
$cart_metadata = json_decode($_POST['cart_metadata'] ?? '', true);

if (empty($klant_email) || !filter_var($klant_email, FILTER_VALIDATE_EMAIL)) {
    sendJsonResponse(['status' => 'error', 'message' => 'Ongeldig e-mailadres.']);
}
if (empty($cart_metadata)) {
    sendJsonResponse(['status' => 'error', 'message' => 'Winkelwagen is leeg.']);
}

if (!is_dir(ORDER_UPLOAD_DIR_ABS) || !is_writable(ORDER_UPLOAD_DIR_ABS)) {
    error_log("[Checkout] FATAL: Orders map niet gevonden of niet schrijfbaar: " . ORDER_UPLOAD_DIR_ABS);
    sendJsonResponse(['status' => 'error', 'message' => 'Serverfout: Kan bestanden niet opslaan.']);
}

global $pdo;
if (!$pdo) {
    sendJsonResponse(['status' => 'error', 'message' => 'Database connectie mislukt.']);
}

try {
    $pdo->beginTransaction();

    $sql_order = "INSERT INTO orders (klant_email, status) VALUES (:email, 'nieuw')";
    $stmt_order = $pdo->prepare($sql_order);
    $stmt_order->execute([':email' => $klant_email]);
    $order_id = $pdo->lastInsertId();

    if (!$order_id) {
        throw new Exception("Kon geen nieuwe order aanmaken.");
    }

    $item_index = 0; // Teller voor unieke bestandsnamen
    foreach ($cart_metadata as $itemKey => $item) {
        $item_index++;
        $product_id = filter_var($item['product_id'] ?? null, FILTER_VALIDATE_INT);
        $quantity = filter_var($item['quantity'] ?? 1, FILTER_VALIDATE_INT);
        if (!$product_id || $quantity < 1) continue;

        $bestandspad_relatief = null;
        $bestand_originele_naam_db = $item['original_filename'] ?? null;
        $temp_file_path = $item['temp_file_path'] ?? null;

        if (!empty($temp_file_path) && !empty($bestand_originele_naam_db)) {
            // ==================================================================
            // FIX 1: Gebruik een robuustere methode om het bronpad te bepalen.
            // We combineren de absolute pad-constante met alleen de bestandsnaam.
            // ==================================================================
            $source_path_abs = TEMP_UPLOAD_DIR_ABS . basename($temp_file_path);

            if (file_exists($source_path_abs)) {
                $safe_original_name = basename($bestand_originele_naam_db);
                $safe_original_name = preg_replace("/[^a-zA-Z0-9_.-]/", "_", $safe_original_name);

                // ==================================================================
                // FIX 2: Gebruik een simpele teller i.p.v. de complexe $itemKey.
                // ==================================================================
                $final_unique_filename = "order_{$order_id}_{$item_index}_" . time() . '_' . $safe_original_name;
                $destination_path_abs = ORDER_UPLOAD_DIR_ABS . $final_unique_filename;

                if (rename($source_path_abs, $destination_path_abs)) {
                    $bestandspad_relatief = ORDER_UPLOAD_DIR_REL . $final_unique_filename;
                    error_log("[Checkout] Bestand verplaatst van {$source_path_abs} naar {$destination_path_abs}");
                } else {
                    throw new Exception("Kon tijdelijk bestand '{$safe_original_name}' niet verplaatsen.");
                }
            } else {
                error_log("[Checkout] Fout: Tijdelijk bestand niet gevonden op het geconstrueerde pad: {$source_path_abs}");
                throw new Exception("Een vereist bestand kon niet worden gevonden op de server.");
            }
        }

        $gekozen_opties_json = json_encode($item['options'] ?? []);
        $sql_regel = "INSERT INTO order_regels (order_id, product_id, aantal, gekozen_opties, bestandspad, bestand_originele_naam)
                      VALUES (:order_id, :pid, :aantal, :opties, :pad, :orig_naam)";
        $stmt_regel = $pdo->prepare($sql_regel);
        $stmt_regel->execute([
            ':order_id' => $order_id,
            ':pid' => $product_id,
            ':aantal' => $quantity,
            ':opties' => $gekozen_opties_json,
            ':pad' => $bestandspad_relatief,
            ':orig_naam' => $bestand_originele_naam_db
        ]);
    }

    $pdo->commit();
    sendJsonResponse(['status' => 'success', 'message' => 'Bestelling succesvol ontvangen!', 'order_id' => $order_id]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("[Checkout] FATALE FOUT: " . $e->getMessage());
    sendJsonResponse(['status' => 'error', 'message' => 'Er ging iets mis: ' . $e->getMessage()]);
}