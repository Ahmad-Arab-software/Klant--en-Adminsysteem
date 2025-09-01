<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Functie om mediabestanden te uploaden en op te slaan in product_images tabel.
 */
function handleMediaUpload($files, $product_id) {
    global $pdo;
    $uploaded_filenames = [];
    $target_dir = __DIR__ . '/../uploads/';

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (!empty($files['name'][0]) && is_array($files['name'])) {
        foreach ($files['name'] as $index => $filename) {
            if ($files['error'][$index] === UPLOAD_ERR_OK) {
                $tmp_name = $files['tmp_name'][$index];
                $filename = uniqid() . '_' . basename($files['name'][$index]);
                $target_path = $target_dir . $filename;

                if (move_uploaded_file($tmp_name, $target_path)) {
                    try {
                        $stmt = $pdo->prepare("INSERT INTO product_images (product_id, filename) VALUES (?, ?)");
                        $stmt->execute([$product_id, $filename]);
                        $uploaded_filenames[] = $filename;
                    } catch (PDOException $e) {
                        error_log("Database error bij opslaan media: " . $e->getMessage());
                        // Optionally handle the error, maybe remove the uploaded file if DB insert fails
                        unlink($target_path);
                    }
                } else {
                    error_log("Failed to move uploaded file: " . $files['name'][$index]);
                }
            } elseif ($files['error'][$index] !== UPLOAD_ERR_NO_FILE) {
                error_log("Upload error for file " . $files['name'][$index] . ": " . $files['error'][$index]);
            }
        }
    }
    return $uploaded_filenames;
}

/**
 * Functie om product videos te koppelen.
 */
function handleProductVideos($product_id, $video_ids) {
    global $pdo;
    // Verwijder eerst bestaande video koppelingen om duplicaten te voorkomen
    $stmt_delete = $pdo->prepare("DELETE FROM product_videos WHERE product_id = ?");
    $stmt_delete->execute([$product_id]);

    if (is_array($video_ids)) {
        foreach ($video_ids as $video_id) {
            $stmt_insert = $pdo->prepare("INSERT INTO product_videos (product_id, video_id) VALUES (?, ?)");
            $stmt_insert->execute([$product_id, $video_id]);
        }
    }
}

/*
 * Verwerking van POST-acties:
 * - Verwijderen van een product
 * - Bewerken van een product
 * - Toevoegen van een nieuw product
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Product verwijderen
    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];
        try {
            $pdo->beginTransaction();

            // Verwijder eerst alle keuzes die horen bij de opties van dit product
            $stmt = $pdo->prepare("DELETE k FROM product_opties_keuzes k
                                   JOIN product_opties o ON k.optie_id = o.id
                                   WHERE o.product_id = ?");
            $stmt->execute([$product_id]);

            // Verwijder de opties
            $stmt = $pdo->prepare("DELETE FROM product_opties WHERE product_id = ?");
            $stmt->execute([$product_id]);

            // Verwijder de product images
            $stmt = $pdo->prepare("DELETE FROM product_images WHERE product_id = ?");
            $stmt->execute([$product_id]);

            // Verwijder de product videos
            $stmt = $pdo->prepare("DELETE FROM product_videos WHERE product_id = ?");
            $stmt->execute([$product_id]);

            // Verwijder het product
            $stmt = $pdo->prepare("DELETE FROM producten WHERE id = ?");
            $stmt->execute([$product_id]);

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            die("Fout bij verwijderen: " . $e->getMessage());
        }

        header("Location: index.php?page=producten");
        exit();
    }

    // Product bewerken
    if (isset($_POST['edit_product'])) {
        $product_id      = $_POST['product_id'];
        $categorie_id    = $_POST['categorie_id'];
        $naam            = $_POST['naam'];
        $beschrijving    = $_POST['beschrijving'];
        $prijs           = $_POST['prijs'];
        $file_types      = $_POST['file_types'] ?? '';
        $requirements    = $_POST['requirements'] ?? null;
        $allowed_file_types = implode(',', $_POST['allowed_file_types'] ?? []); // Combineer de geselecteerde bestandstypen

        $product_videos  = $_POST['product_videos'] ?? [];

        try {
            $pdo->beginTransaction();

            // Werk het product bij
            $stmt = $pdo->prepare("UPDATE producten SET categorie_id = ?, naam = ?, beschrijving = ?, prijs = ?, file_types = ?, requirements = ?, allowed_file_types = ? WHERE id = ?");
            $stmt->execute([$categorie_id, $naam, $beschrijving, $prijs, $file_types, $requirements, $allowed_file_types, $product_id]);

            // Verwerk product videos
            handleProductVideos($product_id, $product_videos);

            // Verwerk eventuele nieuwe mediabestanden en voeg deze toe
            handleMediaUpload($_FILES['media'], $product_id);

            // Verwijder bestaande opties en bijbehorende keuzes voor dit product
            $stmt = $pdo->prepare("DELETE k FROM product_opties_keuzes k
                                   JOIN product_opties o ON k.optie_id = o.id
                                   WHERE o.product_id = ?");
            $stmt->execute([$product_id]);
            $stmt = $pdo->prepare("DELETE FROM product_opties WHERE product_id = ?");
            $stmt->execute([$product_id]);

            // Voeg de nieuwe opties (indien aanwezig) toe
            if (isset($_POST['optie_naam']) && isset($_POST['keuze'])) {
                foreach ($_POST['optie_naam'] as $index => $optie_naam) {
                    $stmt = $pdo->prepare("INSERT INTO product_opties (product_id, optie_naam) VALUES (?, ?)");
                    $stmt->execute([$product_id, $optie_naam]);
                    $optie_id = $pdo->lastInsertId();

                    if (!empty($_POST['keuze'][$index])) {
                        foreach ($_POST['keuze'][$index] as $keuze) {
                            $stmt = $pdo->prepare("INSERT INTO product_opties_keuzes (optie_id, keuze_naam) VALUES (?, ?)");
                            $stmt->execute([$optie_id, $keuze]);
                        }
                    }
                }
            }

            // Verwerk verwijderde media
            if (!empty($_POST['delete_media'])) {
                $mediaToDelete = $_POST['delete_media'];
                if (is_array($mediaToDelete)) {
                    foreach ($mediaToDelete as $mediaFile) {
                        $stmt = $pdo->prepare("DELETE FROM product_images WHERE product_id = ? AND filename = ?");
                        $stmt->execute([$product_id, $mediaFile]);

                        // Optionally delete the physical file
                        $file_path = __DIR__ . '/../uploads/' . $mediaFile;
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                }
            }

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            die("Fout bij bewerken: " . $e->getMessage());
        }

        header("Location: index.php?page=producten");
        exit();
    }

    // Nieuw product toevoegen
    if (isset($_POST['add_product'])) {
        $categorie_id    = $_POST['categorie_id'];
        $naam            = $_POST['naam'];
        $beschrijving    = $_POST['beschrijving'];
        $prijs           = $_POST['prijs'];
        $file_types      = $_POST['file_types'] ?? '';
        $requirements    = $_POST['requirements'] ?? null;
        $allowed_file_types = implode(',', $_POST['allowed_file_types'] ?? []); // Combineer de geselecteerde bestandstypen

        $product_videos  = $_POST['product_videos'] ?? [];

        try {
            $pdo->beginTransaction();

            // Voeg het product toe
            $stmt = $pdo->prepare("INSERT INTO producten (categorie_id, naam, beschrijving, prijs, file_types, requirements, allowed_file_types) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$categorie_id, $naam, $beschrijving, $prijs, $file_types, $requirements, $allowed_file_types]);
            $product_id = $pdo->lastInsertId();

            // Verwerk productvideos
            handleProductVideos($product_id, $product_videos);

            // Verwerk mediabestanden en sla ze op in product_images tabel
            handleMediaUpload($_FILES['media'], $product_id);

            // Voeg productopties toe (indien aanwezig)
            if (isset($_POST['optie_naam']) && isset($_POST['keuze'])) {
                foreach ($_POST['optie_naam'] as $index => $optie_naam) {
                    $stmt = $pdo->prepare("INSERT INTO product_opties (product_id, optie_naam) VALUES (?, ?)");
                    $stmt->execute([$product_id, $optie_naam]);
                    $optie_id = $pdo->lastInsertId();

                    if (!empty($_POST['keuze'][$index])) {
                        foreach ($_POST['keuze'][$index] as $keuze) {
                            $stmt = $pdo->prepare("INSERT INTO product_opties_keuzes (optie_id, keuze_naam) VALUES (?, ?)");
                            $stmt->execute([$optie_id, $keuze]);
                        }
                    }
                }
            }

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            die("Fout bij opslaan: " . $e->getMessage());
        }

        header("Location: index.php?page=producten");
        exit();
    }
}

// Haal alle categorieën op
$stmt = $pdo->query("SELECT * FROM categorieen ORDER BY naam ASC");
$categorieen = $stmt->fetchAll();

// Haal alle videos op
$stmt_videos = $pdo->query("SELECT * FROM videos ORDER BY name ASC");
$videos = $stmt_videos->fetchAll();

// Haal producten op met JOIN voor categorienaam en voeg het volledige productrecord (inclusief categorie_id) toe
$sql = "SELECT p.*, c.naam AS categorie_naam,
        (SELECT GROUP_CONCAT(video_id) FROM product_videos pv WHERE pv.product_id = p.id) as video_ids_str
        FROM producten p
        LEFT JOIN categorieen c ON p.categorie_id = c.id
        ORDER BY p.id DESC";
$stmt = $pdo->query($sql);
$producten = $stmt->fetchAll();

// Haal de opties en bijbehorende keuzes op voor alle producten
if (!empty($producten)) {
    $product_ids = array_column($producten, 'id');
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));

    $sql_options = "SELECT o.*, k.keuze_naam
                    FROM product_opties o
                    LEFT JOIN product_opties_keuzes k ON o.id = k.optie_id
                    WHERE o.product_id IN ($placeholders)
                    ORDER BY o.id, k.id";
    $stmt = $pdo->prepare($sql_options);
    $stmt->execute($product_ids);
    $opties_data = $stmt->fetchAll();

    // Groepeer opties en keuzes per product
    $producten_opties = [];
    foreach ($opties_data as $row) {
        $product_id = $row['product_id'];
        $optie_id = $row['id'];
        if (!isset($producten_opties[$product_id][$optie_id])) {
            $producten_opties[$product_id][$optie_id] = [
                'optie_naam' => $row['optie_naam'],
                'keuzes' => []
            ];
        }
        if (!empty($row['keuze_naam'])) {
            $producten_opties[$product_id][$optie_id]['keuzes'][] = $row['keuze_naam'];
        }
    }

    // Voeg de opties en images en videos toe aan het desbetreffende product
    foreach ($producten as &$product) {
        $product_id = $product['id'];
        $product['opties'] = isset($producten_opties[$product_id]) ? array_values($producten_opties[$product_id]) : [];
        // Fetch product images
        $stmt_images = $pdo->prepare("SELECT filename FROM product_images WHERE product_id = ?");
        $stmt_images->execute([$product_id]);
        $product['media'] = $stmt_images->fetchAll(PDO::FETCH_COLUMN); // Use 'media' to be consistent with view, contains array of filenames
        // Fetch product videos IDs
        $product['videos'] = explode(',', $product['video_ids_str'] ?? ''); // Convert comma-separated string to array
    }
    unset($product);
}

require_once __DIR__ . '/../views/producten.view.php';