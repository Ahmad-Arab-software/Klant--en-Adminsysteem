ik wil dat je de zoekbalk werkend maakt en sorteren ook
write me full code
i use the view and logic methode that means that the view is apart from the logic of the page
maak dat met javascript
verander de functions niet in mijn logic side pas alleen de dingen voor de zoekbalk en voor het sorteren maar de rest moet het zelfde blijven

dit is de view

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function limitBeschrijving($text, $limit = 20) {
    $woorden = explode(' ', $text);
    if (count($woorden) > $limit) {
        return implode(' ', array_slice($woorden, 0, $limit)) . '...';
    }
    return $text;
}

?>

<!DOCTYPE html>

<html lang="nl">
<head>
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

        Generated code
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

<?php
require_once __DIR__ . '/../logic/product.logic.php';

// Haal de producten op met de nieuwe gefilterde en gesorteerde functie
$producten = getFilteredProducten();
$categorieen = getCategorieen();

// Haal de huidige filter- en sorteerwaarden op voor het behouden van de staat in de formulieren
$currentCategory = $_GET['categorie'] ?? '';
$currentSearch = $_GET['search'] ?? '';
$currentSortBy = $_GET['sort_by'] ?? 'newest'; // Standaardwaarde voor sorteren
?>

<!-- Hero section met animatie -->

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

        Generated code
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
        <!-- Gebruik één formulier voor alle filters en sortering -->
        <form action="product.view.php" method="GET" class="w-full flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
            <!-- Categorie filter -->
            <div class="relative inline-block w-full sm:w-64">
                <label for="categorie" class="sr-only">Filter op categorie:</label>
                <div class="relative">
                    <select id="categorie" name="categorie"
                            class="block w-full p-3 pl-10 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-glr-groen focus:border-glr-groen appearance-none"
                            onchange="this.form.submit()">
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
                <input type="text" id="search-products" name="search" placeholder="Zoek producten..."
                       value="<?= htmlspecialchars($currentSearch) ?>"
                       class="w-full p-3 pl-10 pr-10 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-glr-groen focus:border-glr-groen">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                    <i class="fas fa-search"></i>
                </div>
                <!-- De zoekknop submit nu het formulier -->
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-glr-groen hover:text-opacity-80 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

            <!-- Sorteeropties -->
            <div class="inline-flex items-center w-full sm:w-auto">
                <label for="sort-by" class="sr-only">Sorteren op:</label>
                <span class="mr-2 text-gray-600 hidden sm:inline"><i class="fas fa-sort mr-1"></i> Sorteren op:</span>
                <select id="sort-by" name="sort_by"
                        class="text-sm border-gray-300 rounded-md text-gray-900 bg-white focus:ring-glr-groen focus:border-glr-groen p-3"
                        onchange="this.form.submit()">
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
        <?php foreach ($producten as $product): ?>
            <div class="group bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative">
                    <a href="product_detail.view.php?id=<?= htmlspecialchars($product['id']) ?>" class="block overflow-hidden">
                        <?php
                        $mainImageFilename = isset($product['images'][0]) ? $product['images'][0] : 'default_image.jpg';
                        $imageUrl = getAfbeeldingUrl($mainImageFilename);
                        ?>
                        <div class="relative h-80 overflow-hidden bg-gray-200">
                            <img class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                 src="<?= htmlspecialchars($imageUrl) ?>"
                                 alt="<?= htmlspecialchars($product['naam']) ?>" />

                            <!-- Quick view button -->
                            <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <button type="button" class="bg-white text-gray-900 rounded-full p-3 transform -translate-y-4 group-hover:translate-y-0 transition-all duration-300 hover:bg-glr-groen hover:text-white">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </a>

                    <!-- Badge -->
                    <div class="absolute top-4 left-4">
                    <span class="bg-glr-groen text-white text-xs font-bold px-3 py-1 rounded-full">
                        <i class="fas fa-fire mr-1"></i> Nieuw
                    </span>
                    </div>
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
                            €<?= number_format($product['prijs'], 2, ',', '.') ?>
                        </span>
                            <?php if (rand(0, 1) == 1): // Willekeurig tonen van "oude prijs" voor demo ?>
                                <span class="ml-2 text-sm line-through text-gray-500">
                            €<?= number_format($product['prijs'] * 1.2, 2, ',', '.') ?>
                        </span>
                            <?php endif; ?>
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

    <!-- Empty state (shown when no products match the filter) -->
    <?php if (empty($producten)): ?>
        <div class="text-center py-16 px-4 bg-white rounded-xl shadow-md">
            <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Geen producten gevonden</h3>
            <p class="mt-2 text-sm text-gray-500">Er zijn geen producten gevonden die aan je zoekcriteria voldoen.</p>
            <a href="product.view.php" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-glr-groen hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glr-groen">
                <i class="fas fa-sync-alt mr-2"></i> Toon alle producten
            </a>
        </div>
    <?php endif; ?>
    IGNORE_WHEN_COPYING_START
    content_copy
    download
    Use code with caution.
    IGNORE_WHEN_COPYING_END
</section>
<?php include 'footer.php'; ?>

<!-- Back to Top Button -->

<button id="backToTop" class="fixed bottom-8 left-8 w-12 h-12 bg-gray-900 hover:bg-custom-purple text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 flex items-center justify-center z-40">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Scripts -->

<script>
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

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-up');
            }
        });
    }, observerOptions);

    // Observe all product cards
    document.querySelectorAll('#products-grid > div').forEach(card => {
        observer.observe(card);
    });

    // Add loading animation for images
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('load', function() {
            this.classList.add('loaded');
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // De categorie- en sorteerdropdowns submiten nu het formulier bij wijziging.
        // De zoekbalk submit ook het formulier via de knop.
        // Geen extra JS nodig voor deze functionaliteiten behalve de `onchange="this.form.submit()"`
        // en de `type="submit"` op de zoekknop.

        // Optioneel: Als je wilt dat de zoekbalk ook submit bij het indrukken van de Enter-toets:
        const searchInput = document.getElementById('search-products');
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Voorkom standaard formulier indiening om het te controleren
                this.form.submit(); // Submit het formulier
            }
        });

        // De "View toggle" functionaliteit was niet volledig geïmplementeerd en is hier verwijderd.
        // Als je dit opnieuw wilt implementeren, vereist het meer complexe JS of server-side state management.
    });
</script>

</body>
</html>


dit is de logic

<?php

require_once __DIR__ . '/../../config/database.php'; // Correct path to database.php

function getAlleProducten() {
    global $pdo;
    try {
        $stmt = $pdo->query("
            SELECT p.*,
                   GROUP_CONCAT(pi.filename) AS image_filenames
            FROM producten p
            LEFT JOIN product_images pi ON p.id = pi.product_id
            GROUP BY p.id
        ");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Process image filenames into array
        foreach ($products as &$product) {
            $product['images'] = !empty($product['image_filenames']) ? explode(',', $product['image_filenames']) : [];
            unset($product['image_filenames']); // Clean up temporary field
        }
        return $products;
    } catch (PDOException $e) {
        error_log("Database error in getAlleProducten: " . $e->getMessage());
        return [];
    }
}

function getCategorieen() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM categorieen");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getCategorieen: " . $e->getMessage());
        return [];
    }
}

function getProductenPerCategorie($categorie_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT p.*,
                   GROUP_CONCAT(pi.filename) AS image_filenames
            FROM producten p
            LEFT JOIN product_images pi ON p.id = pi.product_id
            WHERE p.categorie_id = ?
            GROUP BY p.id
        ");
        $stmt->execute([$categorie_id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Process image filenames into array
        foreach ($products as &$product) {
            $product['images'] = !empty($product['image_filenames']) ? explode(',', $product['image_filenames']) : [];
            unset($product['image_filenames']); // Clean up temporary field
        }
        return $products;
    } catch (PDOException $e) {
        error_log("Database error in getProductenPerCategorie: " . $e->getMessage());
        return [];
    }
}

// Function to generate the full URL to the image
function getAfbeeldingUrl($filename) {
    // Base URL should be set to the root of your project
    $base_url = '/test_ph/'; // Adjust this if necessary
    $upload_dir = 'uploads/'; // Directory where media files are stored

    // Check if $filename is not null or empty
    if (!empty($filename)) {
        return $base_url . $upload_dir . ltrim($filename, '/'); // Construct full URL
    }

    // Return a default image URL or handle the case where $filename is null
    return $base_url . $upload_dir . 'default_image.jpg'; // Default image path
}

// Function to get filtered products based on category
function getFilteredProducten() {
    if (isset($_GET['categorie']) && $_GET['categorie'] !== '') {
        $categorie_id = $_GET['categorie'];
        return getProductenPerCategorie($categorie_id);
    }
    return getAlleProducten();
}
function getTechniekVideosForProduct($product_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT v.id, v.name, v.link
            FROM videos v
            INNER JOIN product_videos pv ON v.id = pv.video_id
            WHERE pv.product_id = ?
        ");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getTechniekVideosForProduct: " . $e->getMessage());
        return [];
    }
}
?>
