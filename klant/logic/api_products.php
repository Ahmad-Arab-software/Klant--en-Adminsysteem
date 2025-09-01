<?php
// Stel in dat de output JSON is
header('Content-Type: application/json');

// Laad de benodigde logica
require_once __DIR__ . '/product.logic.php';

// Roep de (aangepaste) functie aan die $_GET gebruikt
$producten = getFilteredProducten();

// Geef de resultaten terug als JSON
echo json_encode($producten);
?>