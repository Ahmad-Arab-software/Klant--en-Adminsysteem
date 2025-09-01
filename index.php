<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// De standaardpagina is 'dashboard', maar als er een 'page' parameter is, gebruik die.
$page = $_GET['page'] ?? 'dashboard';

// Pagina's die toegankelijk zijn zonder in te loggen.
$publicPages = ['login', 'logout', 'set-session'];
$ingelogdAls = $_SESSION['ingelogdAls'] ?? null;

// Als de gebruiker niet is ingelogd, stuur naar de loginpagina,
// tenzij ze al een openbare pagina proberen te bezoeken.
if (!isset($_SESSION['login']) && !in_array($page, $publicPages)) {
    header('Location: index.php?page=login');
    exit;
}

// Pagina's die niet toegankelijk zijn voor studenten.
// --- WIJZIGING: 'order_details' toegevoegd aan de beperkte pagina's ---
$studentRestricted = ['dashboard', 'producten', 'add_item', 'videos', 'order_details'];
if ($ingelogdAls === 'STUDENT' && in_array($page, $studentRestricted)) {
    // Studenten worden weggestuurd.
    header('Location: ../test_ph/klant/views/index.php');
    exit;
}

// Router: laad de juiste logica gebaseerd op de 'page' parameter.
switch ($page) {
    case 'dashboard':
        require_once './logic/dashboard.logic.php';
        break;
    case 'producten':
        require_once './logic/producten.logic.php';
        break;
    case 'videos':
        require_once './logic/videos.logic.php';
        break;

    // ==================================================================
    // NIEUWE CASE VOOR DE ORDER DETAILPAGINA
    // ==================================================================
    case 'order_details':
        require_once './logic/order_details.logic.php';
        break;
    // ==================================================================

    case 'add_item':
        require_once './logic/add_item.logic.php';
        break;
    case 'login':
        require_once './logic/login.logic.php';
        break;
    case 'set-session':
        require_once './logic/set-session.logic.php';
        break;
    case 'logout':
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    default:
        // Als de pagina niet bestaat, val terug op het dashboard.
        require_once './logic/dashboard.logic.php';
        break;
}