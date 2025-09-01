<?php
// logic/dashboard.logic.php

require_once __DIR__ . '/../config/database.php';

if (!isset($pdo)) {
    die("Kritieke fout: Databaseverbinding mislukt.");
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

// --- Status Update & Delete Logica (blijft onveranderd) ---
// ... (de code voor updaten en verwijderen die we al hebben gemaakt) ...
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    if (!is_numeric($orderId)) {
        $_SESSION['error_message'] = "Ongeldige bestellings-ID.";
    } else {
        $allowedStatuses = ['nieuw', 'sign', 'in_behandeling', 'wacht', 'print', 'klaar', 'opgehaald'];
        if (in_array($newStatus, $allowedStatuses)) {
            $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
            try {
                $stmt->execute([$newStatus, $orderId]);
                $_SESSION['success_message'] = "Status van order #" . htmlspecialchars($orderId) . " bijgewerkt.";
            } catch (PDOException $e) {
                $_SESSION['error_message'] = "Fout bij bijwerken van status voor order #" . htmlspecialchars($orderId) . ".";
                error_log("Error updating order status for ID " . $orderId . ": " . $e->getMessage());
            }
        } else {
            $_SESSION['error_message'] = "Ongeldige status ontvangen.";
        }
    }
    header("Location: index.php?page=dashboard&" . http_build_query($_GET));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $orderId = $_POST['order_id'];

    if (!is_numeric($orderId)) {
        $_SESSION['error_message'] = "Ongeldige bestellings-ID voor verwijdering.";
    } else {
        try {
            $pdo->beginTransaction();
            $stmt_files = $pdo->prepare("SELECT bestandspad FROM order_regels WHERE order_id = ? AND bestandspad IS NOT NULL");
            $stmt_files->execute([$orderId]);
            $files_to_delete = $stmt_files->fetchAll(PDO::FETCH_COLUMN);
            $stmt_delete = $pdo->prepare("DELETE FROM orders WHERE id = ?");
            $stmt_delete->execute([$orderId]);
            if ($stmt_delete->rowCount() > 0) {
                foreach ($files_to_delete as $file_path_rel) {
                    $full_path = dirname(__DIR__) . '/' . $file_path_rel;
                    if (file_exists($full_path)) {
                        unlink($full_path);
                    }
                }
                $_SESSION['success_message'] = "Order #" . htmlspecialchars($orderId) . " en bijbehorende bestanden succesvol verwijderd.";
            } else {
                $_SESSION['error_message'] = "Order #" . htmlspecialchars($orderId) . " niet gevonden.";
            }
            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            $_SESSION['error_message'] = "Fout bij verwijderen van order #" . htmlspecialchars($orderId) . ".";
            error_log("Error deleting order ID " . $orderId . ": " . $e->getMessage());
        }
    }
    header("Location: index.php?page=dashboard&" . http_build_query($_GET));
    exit();
}


// --- Categorieën Ophalen (onveranderd) ---
$categories = [];
try {
    $stmtCategories = $pdo->query("SELECT id, naam FROM categorieen ORDER BY naam ASC");
    $categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching categories: " . $e->getMessage());
}

// --- Orders Ophalen Logica (AANGEPAST VOOR PRINT-DETAILS) ---
$bestellingen = [];
$errorMessage = '';

try {
    // We gebruiken JSON_ARRAYAGG en JSON_OBJECT om een JSON-structuur direct in SQL te bouwen.
    // Dit is zeer efficiënt.
    $sql = "SELECT
                o.id,
                o.klant_email,
                o.besteld_op,
                o.status,
                GROUP_CONCAT(DISTINCT p.naam SEPARATOR ', ') AS product_namen,
                GROUP_CONCAT(DISTINCT c.naam SEPARATOR ', ') AS categorie_namen,
                COUNT(r.id) as aantal_items,
                -- HIER WORDT DE JSON MET ALLE DETAILS GEBOUWD --
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'product_naam', p.naam,
                        'aantal', r.aantal,
                        'gekozen_opties', r.gekozen_opties
                    )
                ) AS print_details_json
            FROM
                orders o
            LEFT JOIN
                order_regels r ON o.id = r.order_id
            LEFT JOIN
                producten p ON r.product_id = p.id
            LEFT JOIN
                categorieen c ON p.categorie_id = c.id
            ";

    $whereClauses = [];
    $params = [];

    // Filters (blijven onveranderd)
    if (!empty($_GET['status_filter'])) {
        $whereClauses[] = "o.status = ?";
        $params[] = $_GET['status_filter'];
    } else {
        $whereClauses[] = "o.status != 'opgehaald'";
    }
    if (!empty($_GET['category_filter']) && is_numeric($_GET['category_filter'])) {
        $whereClauses[] = "o.id IN (SELECT DISTINCT r.order_id FROM order_regels r JOIN producten p ON r.product_id = p.id WHERE p.categorie_id = ?)";
        $params[] = (int)$_GET['category_filter'];
    }
    if (!empty(trim($_GET['search'] ?? ''))) {
        $searchTerm = '%' . trim($_GET['search']) . '%';
        $whereClauses[] = "(o.klant_email LIKE ? OR o.id LIKE ? OR p.naam LIKE ?)";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }

    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    $sql .= " GROUP BY o.id, o.klant_email, o.besteld_op, o.status";
    $sql .= " ORDER BY FIELD(o.status, 'nieuw', 'sign', 'in_behandeling', 'wacht', 'print', 'klaar', 'opgehaald') ASC, o.besteld_op DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $bestellingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $errorMessage = "Er ging iets mis bij het ophalen van de bestellingen. Probeer het later opnieuw.";
    error_log("Error fetching orders for admin dashboard: " . $e->getMessage());
}

// Laad de view aan het einde
include __DIR__ . '/../views/dashboard.view.php';