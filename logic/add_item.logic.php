<?php
// logic/add_item.logic.php

require_once './config/database.php';

// --- FUNCTIES ---
function getAllItems($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) { die("Fout bij ophalen items: " . $e->getMessage()); }
}
function getItemById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// --- POST REQUESTS AFHANDELEN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- ACTIE: NIEUW ITEM TOEVOEGEN (Onveranderd) ---
    if (isset($_POST['add_item'])) {
        // ... (Deze logica blijft exact hetzelfde als voorheen)
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $image = $_FILES['image'];
        if (empty($title) || empty($description) || $image['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['message'] = 'Alle velden (titel, beschrijving, afbeelding) zijn verplicht.';
            $_SESSION['message_type'] = 'error';
        } else {
            $uploadDir = __DIR__ . '/../uploads/';
            $imageExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            $imageName = 'item_' . uniqid() . '.' . $imageExtension;
            $imagePath = $uploadDir . $imageName;
            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
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

    // --- ACTIE: ITEM BIJWERKEN (AANGEPAST) ---
    if (isset($_POST['update_item'])) {
        $id = $_POST['id'];
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $is_available = isset($_POST['is_available']) ? 1 : 0;
        $current_image_path = $_POST['current_image_path']; // Huidige afbeelding
        $new_image = $_FILES['new_image']; // Potentiële nieuwe afbeelding

        $image_to_update = $current_image_path; // Standaard de oude afbeelding behouden

        // Controleer of er een NIEUWE afbeelding is geüpload
        if (isset($new_image) && $new_image['error'] === UPLOAD_ERR_OK) {
            // Ja, er is een nieuwe afbeelding. Verwerk deze.
            $uploadDir = __DIR__ . '/../uploads/';
            $imageExtension = strtolower(pathinfo($new_image['name'], PATHINFO_EXTENSION));
            $newImageName = 'item_' . uniqid() . '.' . $imageExtension;
            $newImagePath = $uploadDir . $newImageName;

            // Valideer en verplaats de nieuwe afbeelding
            if (move_uploaded_file($new_image['tmp_name'], $newImagePath)) {
                // Nieuwe afbeelding succesvol geüpload, verwijder de oude
                $oldImagePath = $uploadDir . $current_image_path;
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
                // Stel de nieuwe bestandsnaam in voor de database update
                $image_to_update = $newImageName;
            } else {
                // Fout bij uploaden, stop de operatie en geef een foutmelding
                $_SESSION['message'] = 'Fout bij het uploaden van de nieuwe afbeelding.';
                $_SESSION['message_type'] = 'error';
                header("Location: /test_ph/index.php?page=add_item");
                exit();
            }
        }

        // Voer de database update uit (met de oude of de nieuwe afbeeldingsnaam)
        try {
            $stmt = $pdo->prepare("UPDATE items SET title = ?, description = ?, is_available = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$title, $description, $is_available, $image_to_update, $id]);
            $_SESSION['message'] = 'Item succesvol bijgewerkt!';
            $_SESSION['message_type'] = 'success';
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Databasefout bij bijwerken: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }

    // --- ACTIE: ITEM VERWIJDEREN (Onveranderd) ---
    if (isset($_POST['delete_item'])) {
        // ... (Deze logica blijft exact hetzelfde als voorheen)
        $id = $_POST['id'];
        try {
            $itemToDelete = getItemById($pdo, $id);
            if ($itemToDelete) {
                $imagePath = __DIR__ . '/../uploads/' . $itemToDelete['image_path'];
                $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
                $stmt->execute([$id]);
                if (file_exists($imagePath)) { unlink($imagePath); }
                $_SESSION['message'] = 'Item succesvol verwijderd!';
                $_SESSION['message_type'] = 'success';
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Databasefout bij verwijderen: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }

    // Redirect na elke POST actie
    header("Location: /test_ph/index.php?page=add_item");
    exit();
}

// --- GET REQUESTS AFHANDELEN (PAGINA LADEN) ---
$view_data = [];
if (isset($_SESSION['message'])) {
    $view_data['message'] = $_SESSION['message'];
    $view_data['message_type'] = $_SESSION['message_type'];
    unset($_SESSION['message'], $_SESSION['message_type']);
} else {
    $view_data['message'] = '';
    $view_data['message_type'] = '';
}
$items = getAllItems($pdo);
require_once './views/add_item.view.php';