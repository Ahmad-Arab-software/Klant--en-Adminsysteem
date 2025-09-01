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

<?php
require_once __DIR__ . '/../logic/product.logic.php';
//var_dump($_SESSION);

// Haal de producten op
$alleProducten = getFilteredProducten();
$categorieen = getCategorieen();

// <<< WIJZIGING START >>>
// Zorg ervoor dat de product-array in een willekeurige volgorde staat
shuffle($alleProducten);

// Selecteer de eerste 3 producten om weer te geven op de homepage
$producten = array_slice($alleProducten, 0, 3);
// <<< WIJZIGING EINDE >>>


// Haal de huidige filter- en sorteerwaarden op (niet direct gebruikt op deze pagina, maar goede praktijk)
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
    <title>GLR Webshop - Professionele Drukwerk & Design</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="../media/logo.png">
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
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-border {
            background: linear-gradient(45deg, #8fe507, #b297c7, #5b4687);
            padding: 2px;
            border-radius: 16px;
        }

        .gradient-border-inner {
            background: white;
            border-radius: 14px;
        }

        .text-gradient {
            background: linear-gradient(135deg, #8fe507, #5b4687);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
        }

        .scroll-smooth {
            scroll-behavior: smooth;
        }
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
<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-sans scroll-smooth">
<?php include 'navbar.php'; ?>

<section class="hero relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Achtergrond container -->
    <div class="absolute inset-0 z-0">

        <video
                class="object-cover w-full h-full filter brightness-75 hidden md:block"
                src="../media/sign.mp4"
                autoplay
                loop
                muted
                playsinline></video>

        <img
                src="https://www.glr.nl/_next/image?url=%2Fassets%2Fassets%2Fimages%2F2021%2FCreatieve%2520Productie%2520Sign.jpg&w=1200&q=80"
                alt="Hero achtergrond afbeelding"
                class="object-cover w-full h-full filter brightness-75 block md:hidden"
        />
    </div>

    <!-- Gradient overlay voor betere leesbaarheid -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-black/70 z-10"></div>

    <!-- Hero content met verbeterde typografie en spacing -->
    <div class="container relative z-20 px-4 sm:px-6 mx-auto text-center max-w-4xl">
        <div class="space-y-6">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-[#8fe507] mb-4">
                GLR Webshop
            </h1>

            <p class="text-lg md:text-xl leading-relaxed text-white/90 mb-8 max-w-2xl mx-auto">
                Ons Productiehuis is dé plek waar jij als student je werk tot leven brengt!
                Of het nu gaat om posters, stickers, t-shirts, 3D-prints, tasjes of complete magazines.
                <span class="font-medium">Tastbaar is altijd leuker!</span>
            </p>

            <div class="flex justify-center gap-4">
                <a href="./product.view.php" class="bg-[#8fe507] hover:bg-[#a0ff08] text-gray-900 font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Shop Nu
                </a>
            </div>
        </div>
    </div>
</section>


<!-- How it Works Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-glr-groen to-glr-groen rounded-full mb-6">
                <i class="fas fa-cogs text-white text-2xl"></i>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gradient mb-4">Hoe het werkt</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Van idee tot eindproduct in 4 eenvoudige stappen</p>
        </div>

        <!-- Steps -->
        <div class="grid md:grid-cols-4 gap-8 mb-16">
            <!-- Stap 1 -->
            <div class="relative">
                <!-- Content container with z-index to stay on top of the line -->
                <div class="relative text-center group z-20">
                    <div class="mb-6">
                        <div class="gradient-border mx-auto w-24 h-24">
                            <div class="gradient-border-inner w-full h-full flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-custom-green to-custom-lavender rounded-full flex items-center justify-center mx-auto mb-2 group-hover:animate-bounce">
                                        <i class="fas fa-th-large text-white text-xl"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-custom-purple">01</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-custom-purple">Categorie Kiezen</h3>
                    <p class="text-gray-600">Browse door onze categorieën en vind het perfecte product voor jouw project.</p>
                </div>
                <!-- Connecting Line: Positioned relative to the column, behind the content -->
                <div class="hidden md:block absolute top-12 left-1/2 w-full h-0.5 bg-gradient-to-r from-custom-green to-custom-lavender z-10" style="width: calc(100% + 2rem);"></div>
            </div>

            <!-- Stap 2 -->
            <div class="relative">
                <div class="relative text-center group z-20">
                    <div class="mb-6">
                        <div class="gradient-border mx-auto w-24 h-24">
                            <div class="gradient-border-inner w-full h-full flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-custom-lavender to-custom-purple rounded-full flex items-center justify-center mx-auto mb-2 group-hover:animate-bounce">
                                        <i class="fas fa-upload text-white text-xl"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-custom-purple">02</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-custom-purple">Bestand Uploaden</h3>
                    <p class="text-gray-600">Upload je ontwerp en wij zorgen voor de professionele productie ervan.</p>
                </div>
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-12 left-1/2 w-full h-0.5 bg-gradient-to-r from-custom-lavender to-custom-purple z-10" style="width: calc(100% + 2rem);"></div>
            </div>

            <!-- Stap 3 -->
            <div class="relative">
                <div class="relative text-center group z-20">
                    <div class="mb-6">
                        <div class="gradient-border mx-auto w-24 h-24">
                            <div class="gradient-border-inner w-full h-full flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-custom-purple to-custom-green rounded-full flex items-center justify-center mx-auto mb-2 group-hover:animate-bounce">
                                        <i class="fas fa-credit-card text-white text-xl"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-custom-purple">03</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-custom-purple">Afrekenen</h3>
                    <p class="text-gray-600">Reken je producten op bij het Productiehuis.</p>
                </div>
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-12 left-1/2 w-full h-0.5 bg-gradient-to-r from-custom-purple to-custom-green z-10" style="width: calc(100% + 2rem);"></div>
            </div>

            <!-- Stap 4 -->
            <div class="relative">
                <!-- No connecting line needed for the last step -->
                <div class="relative text-center group z-20">
                    <div class="mb-6">
                        <div class="gradient-border mx-auto w-24 h-24">
                            <div class="gradient-border-inner w-full h-full flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-custom-green to-custom-lavender rounded-full flex items-center justify-center mx-auto mb-2 group-hover:animate-bounce">
                                        <i class="fas fa-hand-holding-heart text-white text-xl"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-custom-purple">04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-custom-purple">Ophalen</h3>
                    <p class="text-gray-600">Haal je product op bij het Productiehuis en bewonder het eindresultaat!</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center bg-gradient-to-r from-custom-green to-custom-purple rounded-3xl p-8 text-white">
            <h3 class="text-3xl font-bold mb-4">Klaar om te beginnen?</h3>
            <p class="text-xl mb-6 opacity-90">Bekijk hieronder onze populaire producten en start je project vandaag nog!</p>
            <div class="flex justify-center">
                <i class="fas fa-arrow-down text-4xl animate-bounce"></i>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-custom-green to-custom-purple rounded-full mb-6">
                <i class="fas fa-star text-white text-2xl"></i>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gradient mb-4">Onze Populaire Producten</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Ontdek onze meest geliefde producten, gekozen door studenten</p>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="products-grid">
            <?php foreach ($producten as $product): ?>
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover relative">
                    <!-- Gradient Border Effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-custom-green via-custom-lavender to-custom-purple opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl p-0.5">
                        <div class="bg-white rounded-2xl h-full w-full"></div>
                    </div>

                    <div class="relative z-10">
                        <div class="relative overflow-hidden">
                            <a href="product_detail.view.php?id=<?= htmlspecialchars($product['id']) ?>" class="block">
                                <?php
                                $mainImageFilename = isset($product['images'][0]) ? $product['images'][0] : 'default_image.jpg';
                                // Aanname: u heeft een functie getAfbeeldingUrl, zo niet, pas de paden aan.
                                // Bijvoorbeeld: $imageUrl = '../uploads/' . $mainImageFilename;
                                $imageUrl = '../../uploads/' . htmlspecialchars($mainImageFilename); // Aangepast voor veiligheid
                                ?>
                                <div class="relative h-80 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                    <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                         src="<?= htmlspecialchars($imageUrl) ?>"
                                         alt="<?= htmlspecialchars($product['naam']) ?>" />

                                    <!-- Overlay Effects -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                    <!-- Quick View Button -->
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                        <button type="button" class="bg-white/90 backdrop-blur-sm text-custom-purple rounded-full p-4 transform scale-0 group-hover:scale-100 transition-all duration-300 hover:bg-custom-green hover:text-white shadow-xl">
                                            <i class="fas fa-eye text-xl"></i>
                                        </button>
                                    </div>
                                </div>
                            </a>

                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <span class="bg-gradient-to-r from-custom-green to-custom-lavender text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                    <i class="fas fa-fire mr-1"></i> Nieuw
                                </span>
                            </div>

                        </div>

                        <div class="p-6">


                            <!-- Product Title -->
                            <a href="product_detail.view.php?id=<?= htmlspecialchars($product['id']) ?>">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-custom-purple transition-colors duration-200 line-clamp-2">
                                    <?= htmlspecialchars($product['naam']) ?>
                                </h3>
                            </a>

                            <!-- Description -->
                            <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                                <?= htmlspecialchars(limitBeschrijving($product['beschrijving'], 15)) ?>
                            </p>

                            <!-- Price and Action -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-bold text-gray-900">
                                        €<?= number_format($product['prijs'], 2, ',', '.') ?>
                                    </span>
                                    <?php if (rand(0, 3) == 1): ?>
                                        <span class="ml-2 text-sm line-through text-gray-400">
                                            €<?= number_format($product['prijs'] * 1.3, 2, ',', '.') ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <a href="product_detail.view.php?id=<?= htmlspecialchars($product['id']) ?>"
                                   class="group/btn inline-flex items-center justify-center px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-glr-groen to-glr-groen hover:from-custom-lavender hover:to-custom-purple transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <span class="mr-2">Bekijken</span>
                                    <i class="fas fa-arrow-right transition-transform group-hover/btn:translate-x-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- View All Products Button -->
        <div class="text-center mt-16">
            <a href="./product.view.php" class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-glr-groen to-glr-groen rounded-2xl hover:from-custom-green hover:to-custom-purple transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105">
                <i class="fas fa-th-large mr-3"></i>
                Bekijk alle producten
                <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-8 left-8 w-12 h-12 bg-gray-900 hover:bg-custom-purple text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 flex items-center justify-center z-40">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Scripts -->
<script src="../js/home.js" defer></script>


</body>
</html>