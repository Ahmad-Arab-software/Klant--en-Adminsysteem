<?php

// klant/views/techniek.view.php

// Database configuration
require_once __DIR__ . '/../../config/database.php';

// Use the variables defined in database.php: $host, $db, $user, $pass
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT name, link FROM videos");
    $stmt->execute();
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // Consider better error handling in production
    $videos = [];
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uitlegvideo's Overzicht - GLR Webshop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../media/logo.png">
    <!--    MADE BY AHMAD-->

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
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .stagger-delay:nth-child(1) { transition-delay: 0.1s; }
        .stagger-delay:nth-child(2) { transition-delay: 0.2s; }
        .stagger-delay:nth-child(3) { transition-delay: 0.3s; }
        .stagger-delay:nth-child(4) { transition-delay: 0.4s; }
        .stagger-delay:nth-child(5) { transition-delay: 0.5s; }
        .stagger-delay:nth-child(n+6) { transition-delay: 0.6s; }

        .video-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #f8f8f8 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }

        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
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
<body class="bg-white min-h-screen font-sans">
<?php include 'navbar.php'; ?>

<main class="container mx-auto px-4 py-8">
    <section class="content max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 fade-in">Uitlegvideo's </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($videos)): ?>
                <p class="col-span-full text-gray-500 text-center py-8 fade-in">Geen video's beschikbaar.</p>
            <?php else: ?>
                <?php foreach ($videos as $index => $video): ?>
                    <div class="video-item bg-white rounded-lg shadow-md overflow-hidden fade-in stagger-delay" data-index="<?php echo $index; ?>">
                        <div class="p-4 border-b">
                            <h3 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($video['name']); ?></h3>
                        </div>
                        <?php if ($video['link'] !== 'Geen video beschikbaar' && !empty($video['link'])): ?>
                            <div class="video-container relative pt-[56.25%]">
                                <div class="video-skeleton absolute inset-0"></div>
                                <iframe
                                        class="absolute inset-0 w-full h-full opacity-0 transition-opacity duration-500"
                                        src="<?php echo htmlspecialchars($video['link']); ?>"
                                        frameborder="0"
                                        allowfullscreen
                                        onload="this.classList.add('opacity-100'); this.previousElementSibling.classList.add('hidden');">
                                </iframe>
                            </div>
                        <?php else: ?>
                            <div class="p-8 text-center bg-gray-50">
                                <i class="fas fa-film text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500">Geen video beschikbaar</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-8 left-8 w-12 h-12 bg-gray-900 hover:bg-custom-purple text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 flex items-center justify-center z-40">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth fade-in animation for page elements
        const fadeElements = document.querySelectorAll('.fade-in');

        // Create an intersection observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        });

        // Observe all fade elements
        fadeElements.forEach(el => {
            observer.observe(el);
        });

        // Add click effect to video items
        const videoItems = document.querySelectorAll('.video-item');
        videoItems.forEach(item => {
            item.addEventListener('click', function() {
                this.classList.add('scale-[0.98]');
                setTimeout(() => {
                    this.classList.remove('scale-[0.98]');
                }, 200);
            });
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
</script>


<script src="../../js/script.js"></script>
</body>
</html>