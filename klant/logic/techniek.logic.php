<?php
require_once __DIR__ . '/../../../config/database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
    $stmt = $pdo->query("SELECT * FROM videos");
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $videos = []; // Return empty array if query fails
}