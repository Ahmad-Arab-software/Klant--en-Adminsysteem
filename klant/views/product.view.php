<?php
// ... (bovenkant van je bestand, error_reporting etc. blijft hetzelfde)
error_reporting(E_ALL);
ini_set('display_errors', 1);

function limitBeschrijving($text, $limit = 20) {
    // ... (deze functie blijft hetzelfde)
    $woorden = explode(' ', $text);
    if (count($woorden) > $limit) {
        return implode(' ', array_slice($woorden, 0, $limit)) . '...';
    }
    return $text;
}

// Haal de data op voor de eerste laadbeurt van de pagina
require_once __DIR__ . '/../logic/product.logic.php';
$producten = getFilteredProducten();
$categorieen = getCategorieen();
$currentCategory = $_GET['categorie'] ?? '';
$currentSearch = $_GET['search'] ?? '';
$currentSortBy = $_GET['sort_by'] ?? 'newest';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <!--    MADE BY AHMAD-->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten Overzicht - GLR Webshop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="../media/logo.png">
    <!-- Heroicons (voor moderne icons) -->
    <script src="https://unpkg.com/heroicons@2.0.18/24/outline/esm.js"></script>
    <!-- Font Awesome voor extra icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'glr-groen': '#8fe507',
                        'glr-sign': '#5b4687',
                        'glr-mediamaker': '#b297c7',
                        'custom-green': '#8fe507',
                        'custom-purple': '#5b4687',
                        'custom-lavender': '#b297c7'
                    },
                    animation: {
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'slide-in': 'slideIn 0.5s ease-out forwards',
                        'fade-up': 'fadeUp 0.6s ease-out forwards'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        glow: {
                            '0%': { boxShadow: '0 0 20px rgba(143, 229, 7, 0.5)' },
                            '100%': { boxShadow: '0 0 30px rgba(143, 229, 7, 0.8)' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' }
                        },
                        fadeUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        }
                    },
                    backdropBlur: {
                        xs: '2px',
                    }
                }
            }
        }
    </script>
    <style>
        .loaded {
            opacity: 1;
            transition: opacity 0.3s ease;
        }



        img.loaded {
            opacity: 1;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (prefers-reduced-motion: reduce) {
            .animate-bounce,
            .animate-pulse,
            .animate-float,
            .animate-fade-up {
                animation: none;
            }
        }
    </style>
</head>
<body class="bg-white">
<?php include 'navbar.php'; ?>


<div class="relative bg-gray-900 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-gray-900 transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
            </svg>
            <div class="pt-10 px-4 sm:pt-12 sm:px-6 lg:px-8">
                <!-- Hier zou je logo kunnen staan -->
            </div>
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Ontdek onze</span>
                        <span class="block text-glr-groen xl:inline"> fantastische producten</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Bekijk ons uitgebreide assortiment van hoogwaardige producten en vind precies wat je nodig hebt.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="#producten" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-glr-groen hover:bg-opacity-90 md:py-4 md:text-lg md:px-10">
                                <i class="fas fa-shopping-cart mr-2"></i> Bekijk producten
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="#filter-sort-section" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-glr-groen bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                <i class="fas fa-filter mr-2"></i> Filter & Sorteer
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://vistacollege.efe74.upcloudobjects.com/opleidingen/_header/Vista-LR-387.jpg" alt="">
    </div>
</div>

<section class="py-12 px-4 mx-auto max-w-7xl lg:px-8" id="producten">
    <!-- Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-12 border border-gray-200 rounded-lg p-6 bg-white shadow">
        <div class="text-center">
            <span class="block text-3xl font-bold text-glr-groen">
                <i class="fas fa-box animate-bounce-slow"></i>
            </span>
            <span class="block text-2xl font-semibold text-gray-900"><?= count($producten) ?></span>
            <span class="text-gray-500">Producten</span>
        </div>
        <div class="text-center">
            <span class="block text-3xl font-bold text-glr-sign">
                <i class="fas fa-tags animate-pulse-slow"></i>
            </span>
            <span class="block text-2xl font-semibold text-gray-900"><?= count($categorieen) ?></span>
            <span class="text-gray-500">Categorieën</span>
        </div><div class="text-center">
    <span class="block text-3xl font-bold text-glr-mediamaker">
        <i class="fas fa-graduation-cap animate-pulse-slow"></i>
    </span>
            <span class="block text-2xl font-semibold text-gray-900">100%</span>
            <span class="text-gray-500">Student Project</span>
        </div>

        <div class="text-center">
<span class="block text-3xl font-bold text-glr-groen">
    <i class="fas fa-mobile-screen-button animate-bounce-slow"></i>
</span>
            <span class="block text-2xl font-semibold text-gray-900">100%</span>
            <span class="text-gray-500">Responsief</span>
        </div>

    </div>

    <div class="mx-auto max-w-2xl text-center mb-10">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
            <i class="fas fa-store text-glr-groen mr-2"></i> Ontdek onze producten
        </h1>
        <p class="mt-4 text-lg font-medium text-gray-600">
            Hier vind je een overzicht van al onze producten, gefilterd per categorie.
        </p>
    </div>

    <!-- Filter, Search, and Sort Section -->
    <div class="mb-8 flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4" id="filter-sort-section">
        <!-- ** BELANGRIJKE WIJZIGING: Geef het formulier een ID en verwijder onchange events ** -->
        <form id="filter-form" class="w-full flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
            <!-- Categorie filter -->
            <div class="relative inline-block w-full sm:w-64">
                <label for="categorie" class="sr-only">Filter op categorie:</label>
                <div class="relative">
                    <select id="categorie" name="categorie"
                            class="block w-full p-3 pl-10 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-glr-groen focus:border-glr-groen appearance-none"
                    <!-- GEEN onchange="this.form.submit()" meer -->
                    <option value="">Alle categorieën</option>
                    <?php foreach ($categorieen as $categorie): ?>
                        <option value="<?= htmlspecialchars($categorie['id']) ?>" <?= ($currentCategory == $categorie['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categorie['naam']) ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <!-- Zoekbalk -->
            <div class="relative w-full sm:max-w-md">
                <label for="search-products" class="sr-only">Zoek producten:</label>
                <!-- ** WIJZIGING: type="search" is beter voor semantiek en geeft vaak een 'x' om te wissen ** -->
                <input type="search" id="search-products" name="search" placeholder="Zoek producten..."
                       value="<?= htmlspecialchars($currentSearch) ?>"
                       class="w-full p-3 pl-10 pr-10 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-glr-groen focus:border-glr-groen">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                    <i class="fas fa-search"></i>
                </div>
                <!-- Knop is niet meer nodig om te submitten, maar kan blijven voor UX -->
                <button type="button" aria-label="Voer zoekopdracht uit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-glr-groen hover:text-opacity-80 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                </button>

            </div>

            <!-- Sorteeropties -->
            <div class="inline-flex items-center w-full sm:w-auto">
                <label for="sort-by" class="sr-only">Sorteren op:</label>
                <span class="mr-2 text-gray-600 hidden sm:inline"><i class="fas fa-sort mr-1"></i> Sorteren op:</span>
                <select id="sort-by" name="sort_by"
                        class="text-sm  border border-gray-300  rounded-md text-gray-900 bg-white focus:ring-glr-groen focus:border-glr-groen p-3">
                    <!-- GEEN onchange="this.form.submit()" meer -->
                    <option value="newest" <?= ($currentSortBy == 'newest') ? 'selected' : '' ?>>Nieuwste eerst</option>
                    <option value="price-asc" <?= ($currentSortBy == 'price-asc') ? 'selected' : '' ?>>Prijs (laag-hoog)</option>
                    <option value="price-desc" <?= ($currentSortBy == 'price-desc') ? 'selected' : '' ?>>Prijs (hoog-laag)</option>
                    <option value="name-asc" <?= ($currentSortBy == 'name-asc') ? 'selected' : '' ?>>Naam (A-Z)</option>
                    <option value="name-desc" <?= ($currentSortBy == 'name-desc') ? 'selected' : '' ?>>Naam (Z-A)</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="products-grid">
        <!-- De initiële producten worden hier door PHP gerenderd -->
        <?php foreach ($producten as $product): ?>
            <div class="group bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative">
                    <a href="product_detail.view.php?id=<?= htmlspecialchars($product['id']) ?>" class="block overflow-hidden">
                        <?php
                        // Gebruik de URL uit de PHP-functie
                        $imageUrl = getAfbeeldingUrl(isset($product['images'][0]) ? $product['images'][0] : 'default_image.jpg');
                        ?>
                        <div class="relative h-80 overflow-hidden bg-gray-200">
                            <img class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                 src="<?= htmlspecialchars($imageUrl) ?>"
                                 alt="<?= htmlspecialchars($product['naam']) ?>" />
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <span class="bg-gradient-to-r from-custom-green to-custom-lavender text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                    <i class="fas fa-fire mr-1"></i> Nieuw
                                </span>
                            </div>
                            <!-- Quick View Button -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <button type="button" aria-label="Bekijk productdetails" class="bg-white/90 backdrop-blur-sm text-custom-purple rounded-full p-4 transform scale-0 group-hover:scale-100 transition-all duration-300 hover:bg-custom-green hover:text-white shadow-xl">
                                    <i class="fas fa-eye text-xl"></i>
                                </button>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="p-6">
                    <a href="product_detail.view.php?id=<?= htmlspecialchars($product['id']) ?>">
                        <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-glr-groen transition-colors duration-200">
                            <?= htmlspecialchars($product['naam']) ?>
                        </h2>
                    </a>
                    <p class="text-gray-600 mb-4 min-h-[4rem]">
                        <?= htmlspecialchars(limitBeschrijving($product['beschrijving'], 20)) ?>
                    </p>
                    <div class="flex items-center justify-between mt-6">
                        <div>
                            <span class="text-3xl font-extrabold text-gray-900">
                                <?php
                                // *** FIX 1: PHP PRIJS CONTROLE ***
                                // Controleer of de prijs een getal is. Zo ja, formatteer het. Zo nee, toon de tekst.
                                if (is_numeric($product['prijs'])) {
                                    echo '€' . number_format($product['prijs'], 2, ',', '.');
                                } else {
                                    echo htmlspecialchars($product['prijs']);
                                }
                                ?>
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="product_detail.view.php?id=<?= htmlspecialchars($product['id']) ?>"
                               class="inline-flex items-center justify-center px-5 py-3 rounded-lg font-medium text-white bg-glr-groen hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glr-groen transition-all duration-200">
                                <span>Details</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty state (nu ook beheerd door JavaScript) -->
    <!-- ** WIJZIGING: display: none; toevoegen, JS zal dit tonen/verbergen ** -->
    <div id="empty-state" class="text-center py-16 px-4 bg-white rounded-xl shadow-md" style="<?= !empty($producten) ? 'display: none;' : '' ?>">
        <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Geen producten gevonden</h3>
        <p class="mt-2 text-sm text-gray-500">Er zijn geen producten gevonden die aan je zoekcriteria voldoen.</p>
        <a href="product.view.php" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-glr-groen hover:bg-opacity-90">
            <i class="fas fa-sync-alt mr-2"></i> Toon alle producten
        </a>
    </div>

</section>
<?php include 'footer.php'; ?>

<button id="backToTop" class="fixed bottom-8 left-8 w-12 h-12 bg-gray-900 hover:bg-custom-purple text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 flex items-center justify-center z-40">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- ================================================================= -->
<!-- NIEUWE JAVASCRIPT VOOR DYNAMISCH FILTEREN EN SORTEREN            -->
<!-- ================================================================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Jouw bestaande scripts
        // Back to top
        const backToTopButton = document.getElementById('backToTop');
        window.addEventListener('scroll', () => { /* ... jouw code ... */ });
        backToTopButton.addEventListener('click', () => { /* ... jouw code ... */ });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => { /* ... jouw code ... */ });

        // --- START NIEUWE FILTER/SORT LOGICA ---

        const form = document.getElementById('filter-form');
        const searchInput = document.getElementById('search-products');
        const categorySelect = document.getElementById('categorie');
        const sortSelect = document.getElementById('sort-by');
        const productsGrid = document.getElementById('products-grid');
        const emptyState = document.getElementById('empty-state');

        // Functie om de HTML voor één productkaart te genereren
        function createProductCardHTML(product) {
            // Functie om beschrijving in te korten (JS versie)
            const limitDescription = (text, limit = 20) => {
                if (!text) return '';
                const words = text.split(' ');
                if (words.length > limit) {
                    return words.slice(0, limit).join(' ') + '...';
                }
                return text;
            };

            // *** FIX 2: JAVASCRIPT PRIJS CONTROLE ***
            // Controleer of de prijs een getal is. Zo ja, formatteer het. Zo nee, toon de tekst.
            const price = product.prijs;
            const formattedPrice = !isNaN(parseFloat(price)) && isFinite(price)
                ? new Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(price)
                : price;

            return `
            <div class="group bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-up">
                <div class="relative">
                    <a href="product_detail.view.php?id=${product.id}" class="block overflow-hidden">
                        <div class="relative h-80 overflow-hidden bg-gray-200">
                            <img class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                 src="${product.mainImageUrl}"
                                 alt="${product.naam}" />
                            <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <button type="button" class="bg-white text-gray-900 rounded-full p-3 transform -translate-y-4 group-hover:translate-y-0 transition-all duration-300 hover:bg-glr-groen hover:text-white">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                    <div class="absolute top-4 left-4">
                        <span class="bg-glr-groen text-white text-xs font-bold px-3 py-1 rounded-full">
                            <i class="fas fa-fire mr-1"></i> Nieuw
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <a href="product_detail.view.php?id=${product.id}">
                        <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-glr-groen transition-colors duration-200">
                            ${product.naam}
                        </h2>
                    </a>
                    <p class="text-gray-600 mb-4 min-h-[4rem]">
                        ${limitDescription(product.beschrijving)}
                    </p>
                    <div class="flex items-center justify-between mt-6">
                        <div>
                            <span class="text-3xl font-extrabold text-gray-900">
                                ${formattedPrice}
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="product_detail.view.php?id=${product.id}"
                               class="inline-flex items-center justify-center px-5 py-3 rounded-lg font-medium text-white bg-glr-groen hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glr-groen transition-all duration-200">
                                <span>Details</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        // Functie om de producten op het scherm te renderen
        function renderProducts(products) {
            productsGrid.innerHTML = ''; // Maak de grid leeg

            if (products.length === 0) {
                productsGrid.style.display = 'none';
                emptyState.style.display = 'block';
            } else {
                productsGrid.style.display = 'grid';
                emptyState.style.display = 'none';
                products.forEach(product => {
                    productsGrid.innerHTML += createProductCardHTML(product);
                });
            }
        }

        // Functie die de producten ophaalt van de API
        async function fetchAndUpdateProducts() {
            // Voeg een 'loading' class toe voor visuele feedback
            productsGrid.classList.add('loading');

            // Verzamel de formulier data
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            // Update de URL in de browserbalk zonder te herladen
            history.pushState(null, '', `?${params}`);

            try {
                // Roep onze nieuwe API aan
                const response = await fetch(`../logic/api_products.php?${params}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const products = await response.json();

                // Render de nieuwe producten
                renderProducts(products);

            } catch (error) {
                console.error("Fout bij het ophalen van producten:", error);
                // Optioneel: toon een foutmelding aan de gebruiker
                productsGrid.innerHTML = '<p class="text-red-500 col-span-full text-center">Oeps, er ging iets mis. Probeer het later opnieuw.</p>';
            } finally {
                // Verwijder de 'loading' class
                productsGrid.classList.remove('loading');
            }
        }

        // Voeg event listeners toe aan de input velden
        // 'input' voor de zoekbalk reageert direct op typen
        // 'change' voor dropdowns reageert na een keuze
        searchInput.addEventListener('input', fetchAndUpdateProducts);
        categorySelect.addEventListener('change', fetchAndUpdateProducts);
        sortSelect.addEventListener('change', fetchAndUpdateProducts);

        // Voorkom dat het formulier daadwerkelijk verzendt bij enter in de zoekbalk
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            fetchAndUpdateProducts();
        });
    });

    // Back to top functionality
    const backToTopButton = document.getElementById('backToTop');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.remove('opacity-0', 'invisible');
            backToTopButton.classList.add('opacity-100', 'visible');
        } else {
            backToTopButton.classList.add('opacity-0', 'invisible');
            backToTopButton.classList.remove('opacity-100', 'visible');
        }
    });

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>

</body>
</html>