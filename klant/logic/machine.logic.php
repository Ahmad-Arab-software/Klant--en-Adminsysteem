<?php
// /test_PH/klant/logic/machine.logic.php

// Zorg ervoor dat de databaseverbinding beschikbaar is
require_once __DIR__ . '/../../config/database.php';

$items = []; // Initialiseer een lege array om de items in op te slaan
$error_message = null; // Variabele om eventuele foutmeldingen op te slaan

try {
    // --- AANGEPAST ---
    // We selecteren nu ook de 'is_available' kolom.
    $stmt = $pdo->prepare("SELECT id, title, description, image_path, is_available, created_at FROM items ORDER BY created_at DESC");
    $stmt->execute();

    // Haal alle resultaten op als een associatieve array
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Log de fout voor debugging
    error_log("Database error in machine.logic.php: " . $e->getMessage());
    // Stel een gebruikersvriendelijke foutmelding in
    $error_message = "Er is een fout opgetreden bij het ophalen van de machinegegevens. Probeer het later opnieuw.";
}
?>