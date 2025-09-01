<?php
// /test_PH/klant/views/bestelling_details.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../../config/database.php';

// Initialiseer variabelen
$order_details = null;
$order_items = [];
$option_names_map = [];
$choice_names_map = [];
$error_message = '';

// Check of gebruiker is ingelogd
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: ../views/index.php');
    exit();
}

// Valideer het order ID uit de URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $error_message = "Geen geldige bestelling opgegeven.";
} else {
    $order_id = intval($_GET['id']);
    $klantEmail = $_SESSION['gebruikersnaam'] . '@glr.nl';

    try {
        // ==================================================================
        // STAP 1: Haal de hoofdorder op en verifieer eigendom
        // ==================================================================
        $sql_order = "SELECT * FROM orders WHERE id = ? AND klant_email = ?";
        $stmt_order = $pdo->prepare($sql_order);
        $stmt_order->execute([$order_id, $klantEmail]);
        $order_details = $stmt_order->fetch();

        if (!$order_details) {
            $error_message = "Bestelling niet gevonden of u heeft geen toegang tot deze bestelling.";
        } else {
            // ==================================================================
            // STAP 2: Haal alle producten (orderregels) voor deze order op
            // ==================================================================
            $sql_items = "SELECT r.*, p.naam AS product_naam, p.prijs AS product_prijs
                          FROM order_regels AS r
                          JOIN producten AS p ON r.product_id = p.id
                          WHERE r.order_id = ?";
            $stmt_items = $pdo->prepare($sql_items);
            $stmt_items->execute([$order_id]);
            $order_items = $stmt_items->fetchAll();

            // ==================================================================
            // STAP 3: Verzamel alle optie- en keuze-ID's van ALLE producten
            // ==================================================================
            $all_option_ids = [];
            $all_choice_ids = [];
            foreach ($order_items as $item) {
                if (!empty($item['gekozen_opties'])) {
                    $gekozen_opties_array = json_decode($item['gekozen_opties'], true);
                    if (is_array($gekozen_opties_array)) {
                        $all_option_ids = array_merge($all_option_ids, array_keys($gekozen_opties_array));
                        foreach ($gekozen_opties_array as $value) {
                            if (is_array($value)) {
                                $all_choice_ids = array_merge($all_choice_ids, array_filter($value, 'is_numeric'));
                            } elseif (is_numeric($value)) {
                                $all_choice_ids[] = $value;
                            }
                        }
                    }
                }
            }
            $all_option_ids = array_unique($all_option_ids);
            $all_choice_ids = array_unique($all_choice_ids);

            // ==================================================================
            // STAP 4: Haal alle benodigde namen op in twee efficiënte queries
            // ==================================================================
            if (!empty($all_option_ids)) {
                $in_clause_options = implode(',', array_fill(0, count($all_option_ids), '?'));
                $stmt_options = $pdo->prepare("SELECT id, optie_naam FROM product_opties WHERE id IN ($in_clause_options)");
                $stmt_options->execute($all_option_ids);
                $option_names_map = $stmt_options->fetchAll(PDO::FETCH_KEY_PAIR);
            }
            if (!empty($all_choice_ids)) {
                $in_clause_choices = implode(',', array_fill(0, count($all_choice_ids), '?'));
                $stmt_choices = $pdo->prepare("SELECT id, keuze_naam FROM product_opties_keuzes WHERE id IN ($in_clause_choices)");
                $stmt_choices->execute($all_choice_ids);
                $choice_names_map = $stmt_choices->fetchAll(PDO::FETCH_KEY_PAIR);
            }
        }
    } catch (PDOException $e) {
        $error_message = "Er is een technisch probleem opgetreden bij het ophalen van de details.";
        error_log("Databasefout in bestelling_details.php: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details van Bestelling #<?php echo htmlspecialchars($order_id ?? ''); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../media/logo.png">
    <link rel="stylesheet" href="../css/status.css">
</head>
<body class="font-sans antialiased">
<?php include 'navbar.php'; ?>

<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        <div class="mb-6">
            <a href="status_view.php" class="text-brand-700 hover:text-brand-900 font-semibold inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Terug naar overzicht
            </a>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Fout</p>
                <p><?php echo htmlspecialchars($error_message); ?></p>
            </div>
        <?php elseif ($order_details): ?>
            <div class="glass-card-strong rounded-3xl overflow-hidden">
                <div class="brand-gradient p-6 sm:p-8">
                    <h1 class="text-3xl font-bold text-white">Details van Bestelling #<?php echo htmlspecialchars($order_details['id']); ?></h1>
                    <p class="text-white/80 mt-2">Besteld op: <?php echo (new DateTime($order_details['besteld_op']))->format('d F Y \o\m H:i'); ?></p>
                </div>

                <div class="p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Producten in deze bestelling</h2>
                    <div class="space-y-6">

                        <!-- ================================================================== -->
                        <!-- HIER START DE LOOP VOOR ELK PRODUCT IN DE BESTELLING -->
                        <!-- ================================================================== -->
                        <?php foreach ($order_items as $item): ?>
                            <div class="bg-white/50 p-4 rounded-xl border border-gray-200">
                                <!-- Product Informatie -->
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box-open text-3xl text-gray-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xl font-semibold text-gray-900 truncate"><?php echo htmlspecialchars($item['product_naam']); ?></p>
                                        <p class="text-lg text-gray-600">Aantal: <?php echo htmlspecialchars($item['aantal']); ?></p>
                                    </div>
                                </div>

                                <!-- Gekozen Opties voor dit specifieke product -->
                                <?php
                                $gekozen_opties_array = json_decode($item['gekozen_opties'], true);
                                if (!empty($gekozen_opties_array) && is_array($gekozen_opties_array)):
                                    ?>
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Specificaties</h3>
                                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                            <?php foreach ($gekozen_opties_array as $optie_id => $waarde): ?>
                                                <div class="flex flex-col">
                                                    <dt class="text-md font-medium text-gray-800">
                                                        <?php
                                                        echo isset($option_names_map[$optie_id])
                                                            ? htmlspecialchars($option_names_map[$optie_id])
                                                            : htmlspecialchars(ucfirst(str_replace('_', ' ', $optie_id)));
                                                        ?>
                                                    </dt>
                                                    <dd class="text-sm font-semibold text-gray-500">
                                                        <?php
                                                        if (is_array($waarde)) {
                                                            $keuze_namen = [];
                                                            foreach ($waarde as $keuze_id) {
                                                                $keuze_namen[] = $choice_names_map[$keuze_id] ?? $keuze_id;
                                                            }
                                                            echo htmlspecialchars(implode(', ', $keuze_namen));
                                                        } else {
                                                            echo htmlspecialchars($choice_names_map[$waarde] ?? $waarde);
                                                        }
                                                        ?>
                                                    </dd>
                                                </div>
                                            <?php endforeach; ?>
                                        </dl>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <!-- ================================================================== -->
                        <!-- HIER EINDIGT DE LOOP -->
                        <!-- ================================================================== -->

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>