<?php
// De header en sidebar worden hier geladen.
include 'header.view.php';
include 'sidebar.view.php';

// Start de sessie als deze nog niet gestart is, om toegang te krijgen tot $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video's Beheren</title>
    <link rel="stylesheet" href="./css/videos.css">

</head>
<body>

<!-- Logica om de flash message te tonen (deze PHP-code is ongewijzigd) -->
<?php if (isset($_SESSION['flash_message'])): ?>
    <div id="flash-message" class="flash-message <?php echo htmlspecialchars($_SESSION['flash_message']['type']); ?>">
        <span><?php echo $_SESSION['flash_message']['text']; ?></span>
        <span class="flash-close" onclick="document.getElementById('flash-message').classList.add('hide');">×</span>
    </div>
    <?php
    // Verwijder de boodschap uit de sessie zodat deze niet opnieuw getoond wordt
    unset($_SESSION['flash_message']);
    ?>
<?php endif; ?>


<main class="video-container">
    <h2>Video's Beheren</h2>

    <!-- Formulier om een nieuwe video toe te voegen -->
    <div class="form-container">
        <h3>Nieuwe Video Toevoegen</h3>
        <form action="/test_ph/index.php?page=videos" method="POST">
            <div class="form-group">
                <label for="name">Video Naam</label>
                <input type="text" id="name" name="name" required placeholder="Voer een beschrijvende naam in...">
            </div>
            <div class="form-group">
                <label for="link">YouTube Embed Link</label>
                <input type="text" id="link" name="link" required placeholder="https://www.youtube.com/embed/...">
            </div>
            <button type="submit" name="add_video" class="btn btn-add">Video Toevoegen</button>
        </form>
    </div>

    <!-- Tabel met bestaande video's -->
    <div class="table-container">
        <?php if (empty($videos)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🎬</div>
                <h3>Geen video's gevonden</h3>
                <p>Voeg de eerste video toe om te beginnen!</p>
            </div>
        <?php else: ?>
            <h3>Bestaande Video's</h3>
            <table class="video-table">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Video Preview</th>
                    <th>Acties</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($videos as $video): ?>
                    <tr>
                        <td>
                            <span class="video-name"><?php echo htmlspecialchars($video['name']); ?></span>
                        </td>
                        <td>
                            <div class="video-iframe-container">
                                <iframe src="<?php echo htmlspecialchars($video['link']); ?>" title="<?php echo htmlspecialchars($video['name']); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-edit" onclick="openEditModal(<?php echo $video['id']; ?>, '<?php echo htmlspecialchars($video['name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($video['link'], ENT_QUOTES); ?>')">Bewerken</button>
                                <button class="btn btn-delete" onclick="openDeleteModal(<?php echo $video['id']; ?>, '<?php echo htmlspecialchars($video['name'], ENT_QUOTES); ?>')">Verwijderen</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<!-- De Modal voor het bewerken van een video -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeEditModal()">×</span>
        <h3>Video Bewerken</h3>
        <form action="/test_ph/index.php?page=videos" method="POST">
            <input type="hidden" id="edit-id" name="id">
            <div class="form-group">
                <label for="edit-name">Video Naam</label>
                <input type="text" id="edit-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="edit-link">YouTube Embed Link</label>
                <input type="text" id="edit-link" name="link" required>
            </div>
            <button type="submit" name="edit_video" class="btn btn-edit">Wijzigingen Opslaan</button>
        </form>
    </div>
</div>

<!-- De Modal voor het verwijderen van een video (verbeterde versie) -->
<div id="deleteModal" class="modal delete-modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeDeleteModal()">×</span>
        <div class="delete-icon">🗑️</div>
        <h3>Video Verwijderen</h3>
        <p>Weet je zeker dat je "<strong><span id="delete-video-name"></span></strong>" definitief wilt verwijderen?</p>
        <form action="/test_ph/index.php?page=videos" method="POST">
            <input type="hidden" id="delete-id" name="id">
            <input type="hidden" id="delete-name-hidden" name="name">
            <div class="modal-buttons">
                <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">Annuleren</button>
                <button type="submit" name="delete_video" class="btn btn-confirm-delete">Definitief Verwijderen</button>
            </div>
        </form>
    </div>
</div>

<script>
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');

    function openEditModal(id, name, link) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-link').value = link;
        editModal.style.display = "block";
    }

    function closeEditModal() {
        editModal.style.display = "none";
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-id').value = id;
        document.getElementById('delete-video-name').textContent = name;
        document.getElementById('delete-name-hidden').value = name;
        deleteModal.style.display = "block";
    }

    function closeDeleteModal() {
        deleteModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == editModal) {
            closeEditModal();
        }
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
    }

    // JavaScript voor de flash message (deze code is ongewijzigd)
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            // Verberg de boodschap na 5 seconden (5000 milliseconden)
            setTimeout(() => {
                flashMessage.classList.add('hide');
            }, 5000);
        }
    });
</script>

</body>
</html>