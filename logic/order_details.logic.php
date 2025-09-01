<?php
// logic/order_details.logic.php

require_once __DIR__ . '/../config/database.php';

// Initialiseer variabelen
$order_details = null;
$order_items = [];
$option_names_map = [];
$choice_names_map = [];
$errorMessage = '';
$order_id = null;

// Valideer het order ID uit de URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $errorMessage = "Geen geldige order ID opgegeven.";
} else {
    $order_id = intval($_GET['id']);

    try {
        // Stap 1: Haal de hoofdorder op. Geen klant-check, want admin mag alles zien.
        $sql_order = "SELECT * FROM orders WHERE id = ?";
        $stmt_order = $pdo->prepare($sql_order);
        $stmt_order->execute([$order_id]);
        $order_details = $stmt_order->fetch();

        if (!$order_details) {
            $errorMessage = "Order met ID #" . htmlspecialchars($order_id) . " niet gevonden.";
        } else {
            // Stap 2: Haal alle producten (orderregels) voor deze order op
            $sql_items = "SELECT r.*, p.naam AS product_naam, p.prijs AS product_prijs
                          FROM order_regels AS r
                          JOIN producten AS p ON r.product_id = p.id
                          WHERE r.order_id = ?";
            $stmt_items = $pdo->prepare($sql_items);
            $stmt_items->execute([$order_id]);
            $order_items = $stmt_items->fetchAll();

            // Stap 3: Verzamel alle optie- en keuze-ID's van ALLE producten
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

            // Stap 4: Haal alle benodigde namen op in twee efficiënte queries
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
        $errorMessage = "Er is een technisch probleem opgetreden bij het ophalen van de orderdetails.";
        error_log("Databasefout in order_details.logic.php: " . $e->getMessage());
    }
}

// Laad de view aan het einde
include __DIR__ . '/../views/order_details.view.php';