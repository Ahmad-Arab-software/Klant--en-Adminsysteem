<!--    MADE BY AHMAD-->
<?php
// index.php - Frontcontroller

// Zet foutmeldingen aan voor debugdoeleinden (uitschakelen in productie!)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Controleer of de gebruiker is ingelogd als STUDENT
if (!isset($_SESSION['login']) || $_SESSION['ingelogdAls'] !== 'STUDENT') {
    header('Location: ../../index.php?page=login');
    exit;
}

// Haal de pagina uit de querystring, standaard naar 'home' als niet gezet
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Routing voor de verschillende pagina's
switch ($page) {
    case 'producten':
        require_once '../logic/product.logic.php';
        require_once './product.view.php';
        break;

    case 'product_detail':
        require_once '../logic/product_detail.logic.php';
        require_once './product_detail.view.php';
        break;

    case 'winkelwagen':
        require_once '../logic/winkelwagen.logic.php';
        require_once './winkelwagen.view.php';
        break;

    case 'machine':
        require_once '../logic/machine.logic.php';
        require_once './machine.view.php';
        break;

    case 'techniek':
        require_once '../logic/techniek.logic.php';
        require_once './techniek.view.php';
        break;

    case 'home':
    default:
        require_once '../logic/home.logic.php';
        require_once './home.view.php';
        break;
}
