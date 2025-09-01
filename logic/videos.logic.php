<?php
// --- TOEGEVOEGD ---
// Start de sessie om "flash messages" te kunnen gebruiken.
// Dit wordt vaak al in een centraal bestand zoals index.php gedaan,
// maar het is veilig om het hier ook te plaatsen.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusief de databaseconfiguratie.
require_once __DIR__ . '/../config/database.php';

// Functie om alle video's op te halen uit de database
function getVideos($pdo) {
    try {
        $stmt = $pdo->query("SELECT id, name, link FROM videos ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // In een productieomgeving zou je hier een fout loggen i.p.v. die() gebruiken.
        error_log("Fout bij het ophalen van video's: " . $e->getMessage());
        die("Er is een databasefout opgetreden. Probeer het later opnieuw.");
    }
}

// Controleer of het een POST-verzoek is om acties uit te voeren
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actionSuccess = false;

    // Actie: Een nieuwe video toevoegen
    if (isset($_POST['add_video'])) {
        $name = trim($_POST['name']);
        $link = trim($_POST['link']);

        if (!empty($name) && !empty($link)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO videos (name, link) VALUES (?, ?)");
                if ($stmt->execute([$name, $link])) {
                    // --- TOEGEVOEGD ---: Stel de succesboodschap in
                    $_SESSION['flash_message'] = [
                        'type' => 'success',
                        'text' => 'Video "' . htmlspecialchars($name) . '" is succesvol toegevoegd.'
                    ];
                }
            } catch (PDOException $e) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Fout bij het toevoegen van de video.'];
            }
        }
    }

    // Actie: Een bestaande video bijwerken
    if (isset($_POST['edit_video'])) {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $link = trim($_POST['link']);

        if (!empty($id) && !empty($name) && !empty($link)) {
            try {
                $stmt = $pdo->prepare("UPDATE videos SET name = ?, link = ? WHERE id = ?");
                if ($stmt->execute([$name, $link, $id])) {
                    // --- TOEGEVOEGD ---: Stel de succesboodschap in
                    $_SESSION['flash_message'] = [
                        'type' => 'success',
                        'text' => 'Video "' . htmlspecialchars($name) . '" is succesvol bijgewerkt.'
                    ];
                }
            } catch (PDOException $e) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Fout bij het bijwerken van de video.'];
            }
        }
    }

    // Actie: Een video verwijderen
    if (isset($_POST['delete_video'])) {
        $id = $_POST['id'];
        // --- GEWIJZIGD ---: Haal de naam op uit het POST-verzoek voor de boodschap.
        $name = $_POST['name'] ?? 'de video'; // Fallback voor als de naam niet meekomt

        if (!empty($id)) {
            try {
                $stmt = $pdo->prepare("DELETE FROM videos WHERE id = ?");
                if ($stmt->execute([$id])) {
                    // --- TOEGEVOEGD ---: Stel de succesboodschap in
                    $_SESSION['flash_message'] = [
                        'type' => 'success',
                        'text' => 'Video "' . htmlspecialchars($name) . '" is succesvol verwijderd.'
                    ];
                }
            } catch (PDOException $e) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Fout bij het verwijderen van de video.'];
            }
        }
    }

    // Stuur de gebruiker terug naar de video-pagina.
    // De browser laadt de pagina opnieuw, en daar kunnen we de flash message tonen.
    header("Location: /test_ph/index.php?page=videos");
    exit();
}

// Haal alle video's op om weer te geven in de view
$videos = getVideos($pdo);

// Laad de view die bij deze logica hoort.
require_once __DIR__ . '/../views/videos.view.php';
?>