<?php
// ==================================================================
// AANGEPASTE LOGICA: Haal het ENKELE order ID op uit de URL
// ==================================================================
// De URL is nu: bestelling_bevestiging.view.php?id=123
$order_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Als er geen geldig ID is, is er iets mis.
if (!$order_id) {
    // Optioneel: stuur de gebruiker weg of toon een foutmelding.
    // Voor nu tonen we de pagina met een foutmelding.
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <!--    MADE BY AHMAD-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Bevestigd - Bedankt voor je bestelling</title>
    <meta name="description" content="Je bestelling is succesvol ontvangen en wordt verwerkt.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="../media/logo.png">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#8fe507',
                        'primary-hover': '#7bc906',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white font-sans text-gray-800 min-h-screen">

<?php include 'navbar.php'; ?>

<main class="container mx-auto mt-8 p-4 md:p-8">
    <div class="bg-white rounded-xl shadow-lg p-8 md:p-10 max-w-2xl mx-auto text-center border border-gray-200">

        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-20 w-20 rounded-full bg-[#8fe507] bg-opacity-20 mb-8 animate-pulse">
            <i class="fas fa-check-circle fa-4x text-[#8fe507]"></i>
        </div>

        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Bedankt voor je bestelling!
        </h1>
        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
            Je bestelling is succesvol ontvangen en wordt zo spoedig mogelijk verwerkt.
        </p>

        <!-- ================================================================== -->
        <!-- AANGEPASTE HTML: Toon het ENKELE order ID -->
        <!-- ================================================================== -->
        <?php if ($order_id): ?>
            <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-[#8fe507] mb-8">
                <div class="flex items-center justify-center mb-3">
                    <i class="fas fa-receipt text-[#8fe507] mr-2"></i>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Je bestelnummer:
                    </h2>
                </div>

                <div class="space-y-2 mb-6">
                    <div class="inline-block bg-white px-4 py-2 rounded-md border border-gray-200 mx-1 my-1">
                        <span class="text-xl font-bold text-[#8fe507]">#<?php echo htmlspecialchars($order_id); ?></span>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-md border border-gray-200">
                    <p class="text-sm text-gray-700 flex items-center justify-center">
                        <i class="fas fa-info-circle text-[#8fe507] mr-2"></i>
                        Je kunt de status van je bestelling volgen via onze
                        <a href="status_view.php"
                           class="text-[#8fe507] hover:text-[#7bc906] font-semibold underline decoration-2 underline-offset-2 ml-1 transition-colors duration-200"
                           aria-label="Ga naar bestelstatus pagina">
                            Bestelstatus pagina
                        </a>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-red-500 mb-8">
                <div class="flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                    <p class="text-red-700 font-medium">
                        Kon bestelnummer niet weergeven. Mogelijk is de link onjuist of beschadigd.
                    </p>
                </div>
                <p class="text-sm text-red-600 mt-2">
                    Neem contact met ons op als dit probleem aanhoudt.
                </p>
            </div>
        <?php endif; ?>
        <!-- ================================================================== -->

        <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
            <a href="status_view.php"
               class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-800 font-semibold rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#8fe507] transition duration-200 ease-in-out"
               aria-label="Bekijk bestelstatus">
                <i class="fas fa-search mr-2"></i>
                Bestelstatus bekijken
            </a>

            <a href="index.php"
               class="inline-flex items-center px-8 py-3 bg-[#8fe507] text-white font-semibold rounded-lg hover:bg-[#7bc906] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#8fe507] transition duration-200 ease-in-out shadow-md hover:shadow-lg"
               aria-label="Terug naar homepage">
                <i class="fas fa-home mr-2"></i>
                Terug naar home
            </a>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('h1').focus();
    });
</script>

</body>
</html>