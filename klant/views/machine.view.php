<?php
// /test_PH/klant/views/machine.view.php
require_once __DIR__ . '/../logic/machine.logic.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machines Overzicht - GLR Webshop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="icon" type="image/x-icon" href="../media/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Jouw bestaande Tailwind config en custom CSS (onveranderd) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'glr-groen': '#8fe507', 'glr-sign': '#5b4687', 'glr-mediamaker': '#b297c7',
                        'custom-green': '#8fe507', 'custom-purple': '#5b4687', 'custom-lavender': '#b297c7'
                    },
                    animation: {
                        'bounce-slow': 'bounce 3s infinite', 'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite', 'glow': 'glow 2s ease-in-out infinite alternate',
                        'slide-in': 'slideIn 0.5s ease-out forwards', 'fade-up': 'fadeUp 0.6s ease-out forwards'
                    },
                    keyframes: {
                        float: { '0%, 100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-10px)' } },
                        glow: { '0%': { boxShadow: '0 0 20px rgba(143, 229, 7, 0.5)' }, '100%': { boxShadow: '0 0 30px rgba(143, 229, 7, 0.8)' } },
                        slideIn: { '0%': { transform: 'translateX(-100%)', opacity: '0' }, '100%': { transform: 'translateX(0)', opacity: '1' } },
                        fadeUp: { '0%': { transform: 'translateY(30px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } }
                    },
                    backdropBlur: { xs: '2px' }
                }
            }
        }
    </script>
    <style>
        .icon-animate { transition: transform 0.2s ease-in-out; }
        @media (max-width: 640px) {
            .text-responsive-xl { font-size: 1.875rem; line-height: 2.25rem; }
            .text-responsive-2xl { font-size: 2.25rem; line-height: 2.5rem; }
        }
        .glass-effect { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .gradient-border { background: linear-gradient(45deg, #8fe507, #b297c7, #5b4687); padding: 2px; border-radius: 16px; }
        .gradient-border-inner { background: white; border-radius: 14px; }
        .text-gradient { background: linear-gradient(135deg, #8fe507, #5b4687); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .scroll-smooth { scroll-behavior: smooth; }
        .loaded { opacity: 1; transition: opacity 0.3s ease; }
        img.loaded { opacity: 1; }
        .line-clamp-2, .line-clamp-3 { display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { -webkit-line-clamp: 2; }
        .line-clamp-3 { -webkit-line-clamp: 3; }
        @media (prefers-reduced-motion: reduce) {
            .animate-bounce, .animate-pulse, .animate-float, .animate-fade-up, .transition-transform, .transition-all { animation: none !important; transition: none !important; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-green-50 font-sans antialiased text-gray-800 min-h-screen">
<?php include 'navbar.php'; ?>

<!-- Hero Section -->
<div class="bg-white py-6 sm:py-8 md:py-10 mb-6 sm:mb-8 md:mb-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3 sm:mb-4 leading-tight">Ontdek Onze Machines</h1>
        <p class="text-md sm:text-lg text-gray-700 max-w-xs sm:max-w-md md:max-w-2xl lg:max-w-4xl mx-auto px-4">Bekijk onze collectie van hoogwaardige machines en apparatuur</p>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-8 sm:pb-12 md:pb-16">
    <?php if ($error_message): ?>
        <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-4 sm:p-6 mb-6 sm:mb-8 shadow-sm mx-2 sm:mx-0">
            <div class="flex items-start">
                <div class="flex-shrink-0"><i data-lucide="alert-circle" class="h-5 w-5 sm:h-6 sm:w-6 text-red-400 mt-0.5"></i></div>
                <div class="ml-3 flex-1">
                    <h3 class="text-base sm:text-lg font-medium text-red-800">Er is een fout opgetreden</h3>
                    <p class="text-red-700 mt-1 text-sm sm:text-base break-words"><?php echo htmlspecialchars($error_message); ?></p>
                    <p class="text-xs sm:text-sm text-red-600 mt-2">Probeer de pagina te vernieuwen of neem contact op met de beheerder.</p>
                </div>
            </div>
        </div>
    <?php elseif (empty($items)): ?>
        <div class="text-center py-8 sm:py-12 md:py-16 px-4">
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-6 sm:p-8 md:p-12 max-w-sm sm:max-w-md mx-auto">
                <div class="flex justify-center mb-4 sm:mb-6"><div class="bg-yellow-100 p-3 sm:p-4 rounded-full"><i data-lucide="search" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-yellow-600"></i></div></div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-4">Geen machines gevonden</h3>
                <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">Er zijn momenteel geen machines beschikbaar om weer te geven.</p>
                <div class="flex justify-center"><button onclick="window.location.reload()" class="bg-green-500 hover:bg-green-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-medium transition-colors duration-200 flex items-center text-sm sm:text-base"><i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>Pagina vernieuwen</button></div>
            </div>
        </div>
    <?php else: ?>
        <!-- =================================================================== -->
        <!-- DE FIX: Statistics Section is teruggeplaatst                      -->
        <!-- =================================================================== -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8 md:mb-12 mx-2 sm:mx-0">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex items-center">
                    <div class="bg-green-100 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 flex-shrink-0">
                        <img src="https://cdn-icons-png.freepik.com/512/30/30203.png" alt="Machine icoon" class="w-8 h-8 sm:w-10 sm:h-10">
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate">Beschikbare Machines</h3>
                        <p class="text-gray-600 text-sm sm:text-base">Totaal aantal machines in ons systeem</p>
                    </div>
                </div>
                <div class="text-left sm:text-right flex-shrink-0">
                    <span class="text-2xl sm:text-3xl font-bold text-green-500"><?php echo count($items); ?></span>
                    <p class="text-sm text-gray-500">machines</p>
                </div>
            </div>
        </div>

        <!-- Machines List -->
        <div class="space-y-4 sm:space-y-6">
            <?php foreach ($items as $item): ?>
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg overflow-hidden transition-shadow duration-300 mx-2 sm:mx-0">
                    <div class="flex flex-col md:flex-row">
                        <!-- Image Section -->
                        <div class="relative w-full md:w-64 lg:w-80 h-48 sm:h-56 md:h-48 lg:h-56 flex-shrink-0 overflow-hidden">
                            <img src="../../uploads/<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-full h-full object-cover transition-transform duration-500">
                        </div>

                        <!-- Content Section -->
                        <div class="flex-1 p-4 sm:p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-2 sm:mb-3 leading-tight"><?php echo htmlspecialchars($item['title']); ?></h2>
                                <p class="text-gray-600 mb-4 sm:mb-6 leading-relaxed text-sm sm:text-base lg:text-lg line-clamp-3 sm:line-clamp-none"><?php echo htmlspecialchars($item['description']); ?></p>
                            </div>

                            <!-- Footer -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-3 sm:pt-4 border-t border-gray-100 space-y-3 sm:space-y-0">
                                <div class="flex items-center text-gray-500 text-xs sm:text-sm lg:text-base">
                                    <i data-lucide="calendar" class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0"></i>
                                    <span class="font-medium">
                                        <span class="hidden sm:inline">Toegevoegd: </span><span class="sm:hidden">Toegev.: </span>
                                        <?php echo date('d-m-Y', strtotime($item['created_at'])); ?>
                                    </span>
                                </div>
                                <div class="flex items-center justify-start sm:justify-end">
                                    <?php if ($item['is_available']): ?>
                                        <!-- Status: Beschikbaar -->
                                        <div class="bg-green-100 text-green-600 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full font-medium flex items-center text-xs sm:text-sm">
                                            <i data-lucide="check-circle" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2"></i>
                                            Beschikbaar
                                        </div>
                                    <?php else: ?>
                                        <!-- Status: Niet Beschikbaar -->
                                        <div class="bg-red-100 text-red-600 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full font-medium flex items-center text-xs sm:text-sm">
                                            <i data-lucide="x-circle" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2"></i>
                                            Niet beschikbaar
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-8 left-8 w-12 h-12 bg-gray-900 hover:bg-custom-purple text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 flex items-center justify-center z-40">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
    // Jouw bestaande Javascript (onveranderd)
    lucide.createIcons();
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
    backToTopButton.addEventListener('click', () => { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const animatedScrollObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    document.querySelectorAll('.space-y-6 > div').forEach(card => { if (card) { animatedScrollObserver.observe(card); } });
    document.querySelectorAll('#products-grid > div').forEach(card => { if (card) { animatedScrollObserver.observe(card); } });
    document.querySelectorAll('img').forEach(img => {
        if (img.complete) { img.classList.add('loaded'); } else { img.addEventListener('load', function() { this.classList.add('loaded'); }); }
    });
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            try {
                const targetElement = document.querySelector(targetId);
                if (targetElement) { targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
            } catch (error) { console.error("Error scrolling to anchor:", error); }
        });
    });
</script>
</body>
</html>