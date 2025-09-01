<?php
// Voorkom dubbele sessie-start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Altijd correcte JSON-header
header('Content-Type: application/json');

// Lees ruwe JSON-input
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// Controleer of de JSON goed is
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Ongeldige JSON']);
    exit;
}

// Controleer of sessiegegevens zijn meegegeven
if (!isset($data['session']) || !is_array($data['session'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Geen sessiegegevens ontvangen']);
    exit;
}

// Zet sessiegegevens
$session = $data['session'];
$_SESSION['login'] = true;
$_SESSION['ingelogdAls'] = $session['ingelogdAls'] ?? null;
$_SESSION['gebruikersnaam'] = $session['gebruikersnaam'] ?? '';
$_SESSION['mail'] = $session['mail'] ?? '';

// Verstuur geldige JSON-response
echo json_encode(['status' => 'ok']);
