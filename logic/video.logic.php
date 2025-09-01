<?php
require_once __DIR__ . '/../config/database.php';

function getVideoDetails($videoId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->execute([$videoId]);
    return $stmt->fetch();
}