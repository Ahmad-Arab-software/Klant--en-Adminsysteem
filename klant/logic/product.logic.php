<?php

require_once __DIR__ . '/../../config/database.php'; // Correct pad naar database.php

// --- DEZE FUNCTIES BLIJVEN ONGEWIJZIGD ---

function getAlleProducten() {
    global $pdo;
    try {
        $stmt = $pdo->query("
            SELECT p.*,
                   GROUP_CONCAT(pi.filename) AS image_filenames
            FROM producten p
            LEFT JOIN product_images pi ON p.id = pi.product_id
            GROUP BY p.id
        ");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($products as &$product) {
            $product['images'] = !empty($product['image_filenames']) ? explode(',', $product['image_filenames']) : [];
            unset($product['image_filenames']);
        }
        return $products;
    } catch (PDOException $e) {
        error_log("Database error in getAlleProducten: " . $e->getMessage());
        return [];
    }
}

function getCategorieen() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM categorieen");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getCategorieen: " . $e->getMessage());
        return [];
    }
}

function getProductenPerCategorie($categorie_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT p.*,
                   GROUP_CONCAT(pi.filename) AS image_filenames
            FROM producten p
            LEFT JOIN product_images pi ON p.id = pi.product_id
            WHERE p.categorie_id = ?
            GROUP BY p.id
        ");
        $stmt->execute([$categorie_id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($products as &$product) {
            $product['images'] = !empty($product['image_filenames']) ? explode(',', $product['image_filenames']) : [];
            unset($product['image_filenames']);
        }
        return $products;
    } catch (PDOException $e) {
        error_log("Database error in getProductenPerCategorie: " . $e->getMessage());
        return [];
    }
}

function getAfbeeldingUrl($filename) {
    $base_url = '/test_ph/';
    $upload_dir = 'uploads/';
    if (!empty($filename)) {
        return $base_url . $upload_dir . ltrim($filename, '/');
    }
    return $base_url . $upload_dir . 'default_image.jpg';
}

function getTechniekVideosForProduct($product_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT v.id, v.name, v.link
            FROM videos v
            INNER JOIN product_videos pv ON v.id = pv.video_id
            WHERE pv.product_id = ?
        ");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getTechniekVideosForProduct: " . $e->getMessage());
        return [];
    }
}


// --- DEZE FUNCTIE IS AANGEPAST VOOR ZOEKEN EN SORTEREN ---

/**
 * Haalt producten op op basis van filter-, zoek- en sorteerparameters uit $_GET.
 * Dit is de centrale functie die door zowel de view (bij de eerste laadbeurt)
 * als de API wordt gebruikt.
 */
function getFilteredProducten() {
    global $pdo;

    // Haal parameters op
    $categorieId = $_GET['categorie'] ?? '';
    $searchTerm = $_GET['search'] ?? '';
    $sortBy = $_GET['sort_by'] ?? 'newest';

    // Begin met de basisquery
    $sql = "SELECT p.*, GROUP_CONCAT(pi.filename) AS image_filenames
            FROM producten p
            LEFT JOIN product_images pi ON p.id = pi.product_id";

    // Bouw de WHERE clause dynamisch op
    $whereClauses = [];
    $params = [];

    if (!empty($categorieId)) {
        $whereClauses[] = "p.categorie_id = ?";
        $params[] = $categorieId;
    }

    if (!empty($searchTerm)) {
        // Zoek in naam EN beschrijving
        $whereClauses[] = "(p.naam LIKE ? OR p.beschrijving LIKE ?)";
        $params[] = "%" . $searchTerm . "%";
        $params[] = "%" . $searchTerm . "%";
    }

    if (count($whereClauses) > 0) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    // Voeg GROUP BY toe
    $sql .= " GROUP BY p.id";

    // Bouw de ORDER BY clause op
    $orderByClause = " ORDER BY ";
    switch ($sortBy) {
        case 'price-asc':
            $orderByClause .= "p.prijs ASC";
            break;
        case 'price-desc':
            $orderByClause .= "p.prijs DESC";
            break;
        case 'name-asc':
            $orderByClause .= "p.naam ASC";
            break;
        case 'name-desc':
            $orderByClause .= "p.naam DESC";
            break;
        case 'newest':
        default:
            $orderByClause .= "p.id DESC"; // Aanname: hogere ID is nieuwer
            break;
    }
    $sql .= $orderByClause;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verwerk afbeeldingen en voeg de volledige URL toe
        foreach ($products as &$product) {
            $images = !empty($product['image_filenames']) ? explode(',', $product['image_filenames']) : [];
            $product['images'] = $images;
            // Voeg een 'mainImageUrl' toe voor gemak in JavaScript
            $product['mainImageUrl'] = getAfbeeldingUrl($images[0] ?? 'default_image.jpg');
            unset($product['image_filenames']);
        }

        return $products;

    } catch (PDOException $e) {
        error_log("Database error in getFilteredProducten: " . $e->getMessage());
        return [];
    }
}
?>