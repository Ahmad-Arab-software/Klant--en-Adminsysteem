<?php
// /test_PH/klant/logic/status_logic.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Pad naar de database configuratie
require_once '../../config/database.php';

// --- HELPER FUNCTIES (onveranderd) ---

function vertaalStatus($status) {
    switch ($status) {
        case 'nieuw': return 'Nieuw (in afwachting van behandeling)';
        case 'sign': return 'Wacht op akkoord Sign';
        case 'in_behandeling': return 'In behandeling';
        case 'wacht': return 'In de wacht gezet';
        case 'print': return 'Wordt geprint';
        case 'klaar': return '✅ Klaar (kan opgehaald worden)';
        case 'opgehaald': return '🏁 Opgehaald';
        default: return htmlspecialchars(ucfirst($status));
    }
}

function getStatusIcon($status) {
    switch ($status) {
        case 'nieuw': return '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
        case 'sign': return '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>';
        case 'in_behandeling': return '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path></svg>';
        case 'wacht': return '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>';
        case 'print': return '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path></svg>';
        case 'klaar': return '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
        case 'opgehaald': return '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"></path></svg>';
        default: return '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
    }
}

function getStatusColor($status) {
    switch ($status) {
        case 'nieuw': return 'bg-blue-100 text-blue-800 border-blue-200';
        case 'sign': return 'bg-purple-100 text-purple-800 border-purple-200';
        case 'in_behandeling': return 'bg-yellow-100 text-yellow-800 border-yellow-200';
        case 'wacht': return 'bg-orange-100 text-orange-800 border-orange-200';
        case 'print': return 'bg-indigo-100 text-indigo-800 border-indigo-200';
        case 'klaar': return 'bg-green-100 text-green-800 border-green-200';
        case 'opgehaald': return 'bg-gray-100 text-gray-800 border-gray-200';
        default: return 'bg-gray-100 text-gray-800 border-gray-200';
    }
}

// --- DATA OPHALEN ---

$bestellingen = []; // We blijven deze naam gebruiken voor consistentie in de view
$actieve_bestellingen = [];
$opgehaalde_bestellingen = [];
$error_message = '';

if (!isset($pdo)) {
    // Dit zou niet moeten gebeuren als database.php correct is opgenomen
    $error_message = 'ERROR_CODE_PDO_MISSING: Het PDO-connectieobject is niet gevonden.';
} elseif (isset($_SESSION['login']) && $_SESSION['login'] === true && isset($_SESSION['gebruikersnaam'])) {
    try {
        $gebruikersnaam = $_SESSION['gebruikersnaam'];
        $klantEmail = $gebruikersnaam . '@glr.nl';

        // ==================================================================
        // GECORRIGEERDE QUERY: Gebruik de 'orders' tabel
        // ==================================================================
        $sql = "SELECT id, status, besteld_op FROM orders WHERE klant_email = ? ORDER BY besteld_op DESC";
        // ==================================================================

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$klantEmail]);
        $bestellingen = $stmt->fetchAll();

        // De rest van de logica blijft hetzelfde, omdat de kolomnamen (id, status, besteld_op) identiek zijn.
        foreach ($bestellingen as $bestelling) {
            if ($bestelling['status'] === 'opgehaald') {
                $opgehaalde_bestellingen[] = $bestelling;
            } else {
                $actieve_bestellingen[] = $bestelling;
            }
        }
    } catch (PDOException $e) {
        // Vang de fout op als de query mislukt (bijv. als de tabel echt niet bestaat)
        $error_message = 'ERROR_CODE_DB_QUERY: Fout bij het ophalen van bestellingen. Details: ' . $e->getMessage();
        // Log de fout voor debugging
        error_log($error_message);
    }
} else {
    // Gebruiker is niet ingelogd, stuur naar de homepagina
    header('Location: ../views/index.php'); // Aangepast naar de view map
    exit();
}
?>