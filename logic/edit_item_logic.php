<?php
// session_start() wordt al in index.php gedaan.

require_once __DIR__ . '/../config/database.php';

// --- FUNCTIES ---

// Functie om alle items op te halen
function getAllItems($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Fout bij ophalen items: " . $e->getMessage());
    }
}

// Functie om een item op ID te halen
function getItemById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// --- POST REQUESTS AFHANDELEN ---

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- ACTIE: NIEUW ITEM TOEVOEGEN ---
    if (isset($_POST['add_item'])) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $image = $_FILES['image'];

        // Validatie
        if (empty($title) || empty($description) || $image['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['message'] = 'Alle velden (titel, beschrijving, afbeelding) zijn verplicht.';
            $_SESSION['message_type'] = 'error';
        } else {
            // Afbeelding verwerken
            $uploadDir = __DIR__ . '/../uploads/';
            $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $imageName = 'item_' . uniqid() . '.' . $imageExtension;
            $imagePath = $uploadDir . $imageName;

            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                // Opslaan in database
                try {
                    $stmt = $pdo->prepare("INSERT INTO items (title, description, image_path) VALUES (?, ?, ?)");
                    $stmt->execute([$title, $description, $imageName]);
                    $_SESSION['message'] = 'Item succesvol toegevoegd!';
                    $_SESSION['message_type'] = 'success';
                } catch (PDOException $e) {
                    $_SESSION['message'] = 'Databasefout bij toevoegen: ' . $e->getMessage();
                    $_SESSION['message_type'] = 'error';
                }
            } else {
                $_SESSION['message'] = 'Fout bij het uploaden van de afbeelding.';
                $_SESSION['message_type'] = 'error';
            }
        }
    }

    // --- ACTIE: ITEM BIJWERKEN ---
    if (isset($_POST['update_item'])) {
        $id = $_POST['id'];
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $is_available = isset($_POST['is_available']) ? 1 : 0;

        try {
            $stmt = $pdo->prepare("UPDATE items SET title = ?, description = ?, is_available = ? WHERE id = ?");
            $stmt->execute([$title, $description, $is_available, $id]);
            $_SESSION['message'] = 'Item succesvol bijgewerkt!';
            $_SESSION['message_type'] = 'success';
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Databasefout bij bijwerken: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }

    // --- ACTIE: ITEM VERWIJDEREN ---
    if (isset($_POST['delete_item'])) {
        $id = $_POST['id'];
        try {
            $itemToDelete = getItemById($pdo, $id);
            if ($itemToDelete) {
                $imagePath = __DIR__ . '/../uploads/' . $itemToDelete['image_path'];
                $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
                $stmt->execute([$id]);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $_SESSION['message'] = 'Item succesvol verwijderd!';
                $_SESSION['message_type'] = 'success';
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Databasefout bij verwijderen: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }

    // Redirect na elke POST actie om form resubmission te voorkomen
    header("Location: /test_ph/index.php?page=add_item");
    exit();
}


// --- GET REQUESTS AFHANDELEN (PAGINA LADEN) ---

// Haal de melding uit de sessie en zet hem in $view_data
$view_data = [];
if (isset($_SESSION['message'])) {
    $view_data['message'] = $_SESSION['message'];
    $view_data['message_type'] = $_SESSION['message_type'];
    // Verwijder de melding uit de sessie zodat hij maar één keer getoond wordt
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
} else {
    $view_data['message'] = '';
    $view_data['message_type'] = '';
}

// Haal alle items op om te tonen in de lijst
$items = getAllItems($pdo);

// Laad de view
require_once __DIR__ . '/../views/add_item.php';