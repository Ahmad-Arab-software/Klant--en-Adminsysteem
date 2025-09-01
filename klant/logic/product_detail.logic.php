<?php
require_once __DIR__ . '/../../config/database.php'; // Adjust path to database.php
require_once __DIR__ . '/product.logic.php'; // Include product.logic.php to access getAfbeeldingUrl()

function getProductDetail($product_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT p.*, c.naam AS categorie_naam
            FROM producten p
            LEFT JOIN categorieen c ON p.categorie_id = c.id
            WHERE p.id = ?
        ");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return null;
        }

        $stmt_images = $pdo->prepare("
            SELECT filename FROM product_images WHERE product_id = ?
        ");
        $stmt_images->execute([$product_id]);
        $product['images'] = $stmt_images->fetchAll(PDO::FETCH_COLUMN);

        return $product;

    } catch (PDOException $e) {
        error_log("Database error in getProductDetail: " . $e->getMessage());
        return null;
    }
}

function getProductOptiesDetail($product_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM product_opties WHERE product_id = ?");
    $stmt->execute([$product_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOptieKeuzesDetail($optie_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM product_opties_keuzes WHERE optie_id = ?");
    $stmt->execute([$optie_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// getAfbeeldingUrl function is in product.logic.php, no need to redefine here.

// You would typically fetch data and prepare it here.
// For example, getting product, options, and option choices based on product ID.
$product_id = $_GET['id'] ?? null; // Haal product ID uit de URL
if (!$product_id) {
    die("Product ID niet gespecificeerd."); // In real app, redirect to error page
}

$product = getProductDetail($product_id);
if (!$product) {
    die("Product niet gevonden.");  // In real app, redirect to 404 page
}

$product_opties = getProductOptiesDetail($product_id);
foreach ($product_opties as &$optie) {
    $optie['keuzes'] = getOptieKeuzesDetail($optie['id']);
}
unset($optie); // Clean up reference
