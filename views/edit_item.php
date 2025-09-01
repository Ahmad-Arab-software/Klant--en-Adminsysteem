<?php
// Laad de header en sidebar
include 'header.view.php';
include 'sidebar.view.php';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Bewerken: <?php echo htmlspecialchars($item['title']); ?></title>
    <style>
        .edit-container { padding: 20px; margin-left: 250px; /* Breedte van de sidebar */ }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            max-width: 600px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea { height: 150px; resize: vertical; }
        .form-group img { max-width: 300px; height: auto; border: 1px solid #ddd; padding: 5px; margin-top: 10px; }
        .btn { padding: 10px 15px; border: none; cursor: pointer; border-radius: 4px; color: white; font-size: 16px; }
        .btn-save { background-color: #4CAF50; /* Groen */ }
        .btn-delete { background-color: #f44336; /* Rood */ margin-top: 20px; }
    </style>
</head>
<body>

<div class="edit-container">
    <h2>Item Bewerken</h2>
    <h3><?php echo htmlspecialchars($item['title']); ?></h3>

    <!-- Formulier voor het bewerken van het item -->
    <form action="/test_ph/index.php?page=edit_item&id=<?php echo $item['id']; ?>" method="POST">
        <!-- Verborgen ID-veld om te weten welk item we updaten -->
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">

        <div class="form-group">
            <label for="title">Titel</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($item['title']); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Beschrijving</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($item['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Huidige Afbeelding</label>
            <img src="/test_ph/uploads/<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
            <p><small>Let op: Afbeelding uploaden is hier niet mogelijk. Dit kan alleen bij het aanmaken van een nieuw item.</small></p>
        </div>

        <div class="form-group">
            <label for="is_available">
                <input type="checkbox" id="is_available" name="is_available" value="1" <?php echo $item['is_available'] ? 'checked' : ''; ?>>
                Beschikbaar voor uitlenen
            </label>
        </div>

        <button type="submit" name="update_item" class="btn btn-save">Wijzigingen Opslaan</button>
    </form>

    <hr style="margin-top: 40px;">

    <!-- Apart formulier voor de verwijder-actie om ongelukken te voorkomen -->
    <h3>Item Verwijderen</h3>
    <p>Let op: Deze actie kan niet ongedaan worden gemaakt. De afbeelding wordt ook permanent verwijderd.</p>
    <form action="/test_ph/index.php?page=edit_item&id=<?php echo $item['id']; ?>" method="POST" onsubmit="return confirm('Weet je ZEKER dat je dit item en de bijbehorende afbeelding permanent wilt verwijderen?');">
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
        <button type="submit" name="delete_item" class="btn btn-delete">Verwijder Item Permanent</button>
    </form>

</div>

</body>
</html>