<?php
// /test_PH/klant/views/status_view.php

require_once '../logic/status_logic.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Besteloverzicht</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../media/logo.png">
    <link rel="stylesheet" href="../css/status.css">

    <!-- Tailwind config (AANGEPAST VOOR BETERE PRESTATIES) -->
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
                        'custom-lavender': '#b297c7',
                        'brand': {
                            50: '#f7ffe6',
                            100: '#ecffc4',
                            200: '#dcff8f',
                            300: '#c7ff4f',
                            400: '#b4ff1a',
                            500: '#8fe507',
                            600: '#6ec000',
                            700: '#549204',
                            800: '#45720a',
                            900: '#3a600e',
                        },
                        'purple': {
                            500: '#5b4687',
                            600: '#4d3a73',
                            700: '#402e5f',
                        },
                        'lavender': {
                            400: '#b297c7',
                            500: '#9d7fb8',
                            600: '#8967a9',
                        }
                    },
                    animation: {
                        'slide-up': 'slideUp 0.6s ease-out forwards',
                        'slide-in-right': 'slideInRight 0.7s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
                        // GEFIXED: pulse-glow animeert niet langer de zware box-shadow
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'scale-in': 'scaleIn 0.5s ease-out forwards',
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-in': 'slideIn 0.5s ease-out forwards',
                        'fade-up': 'fadeUp 0.6s ease-out forwards'
                    },
                    keyframes: {
                        slideUp: {
                            '0%': { transform: 'translateY(50px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        slideInRight: {
                            '0%': { transform: 'translateX(30px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        // GEFIXED: box-shadow animatie verwijderd voor betere prestaties.
                        pulseGlow: {
                            '0%, 100%': {
                                transform: 'scale(1)'
                            },
                            '50%': {
                                transform: 'scale(1.03)'
                            }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.95)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        },
                        // VERWIJDERD: 'glow' keyframe was ongebruikt en zwaar.
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' }
                        },
                        fadeUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        }
                    },
                    // VERWIJDERD: backdropBlur is niet meer nodig.
                }
            }
        }
    </script>

</head>
<body class="font-sans antialiased">
<?php include 'navbar.php'; ?>

<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Hero Header -->
        <div class="glass-card-strong rounded-3xl p-6 sm:p-8 lg:p-12 mb-10 animate-slide-up">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                <div class="flex items-start space-x-4 sm:space-x-6">
                    <div class="icon-wrapper p-4 sm:p-5 rounded-2xl animate-float"><i class="fas fa-clipboard-list text-2xl sm:text-3xl text-white"></i></div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-2 sm:mb-3">Mijn Besteloverzicht</h1>
                        <p class="text-base sm:text-lg text-gray-600 max-w-lg">Volg de status van al uw bestellingen in real-time.</p>
                    </div>
                </div>
                <div class="flex flex-col items-start sm:items-end space-y-3">
                    <div class="modern-badge px-4 py-2 rounded-full flex items-center space-x-2">
                        <div class="w-2 h-2 bg-brand-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-700">Live Status</span>
                    </div>
                    <div class="text-sm text-gray-500">Laatst bijgewerkt: <?php echo date('d-m-Y H:i'); ?></div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <?php if (!empty($error_message)): ?>
            <div class="glass-card rounded-2xl p-4 sm:p-6 mb-8 border-l-4 border-red-400 animate-slide-in-right">
                <div class="flex items-start space-x-4">
                    <div class="bg-red-100 p-3 rounded-xl flex-shrink-0"><i class="fas fa-exclamation-triangle text-red-600 text-lg sm:text-xl"></i></div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-semibold text-red-800 mb-2">Er is een fout opgetreden</h3>
                        <p class="text-red-700 text-sm sm:text-base"><?php echo htmlspecialchars($error_message); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($error_message)): ?>
            <!-- Status Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <?php
                $statusCount = array_count_values(array_column($bestellingen, 'status'));
                $totalOrders = count($bestellingen);
                ?>
                <div class="glass-card rounded-2xl p-5 sm:p-6 animate-scale-in" style="animation-delay: 0.1s">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm font-medium text-gray-600">Totaal Bestellingen</p><p class="text-3xl font-bold text-gray-900"><?php echo $totalOrders; ?></p></div>
                        <div class="icon-wrapper p-3 rounded-xl"><i class="fas fa-shopping-cart text-white text-xl"></i></div>
                    </div>
                </div>
                <div class="glass-card rounded-2xl p-5 sm:p-6 animate-scale-in" style="animation-delay: 0.2s">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm font-medium text-gray-600">In Behandeling</p><p class="text-3xl font-bold text-yellow-600"><?php echo ($statusCount['in_behandeling'] ?? 0) + ($statusCount['print'] ?? 0); ?></p></div>
                        <div class="bg-yellow-100 p-3 rounded-xl"><i class="fas fa-cog text-yellow-600 text-xl animate-spin [animation-duration:3s]"></i></div>
                    </div>
                </div>
                <div class="glass-card rounded-2xl p-5 sm:p-6 animate-scale-in" style="animation-delay: 0.3s">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm font-medium text-gray-600">Klaar voor ophalen</p><p class="text-3xl font-bold text-green-600"><?php echo $statusCount['klaar'] ?? 0; ?></p></div>
                        <div class="bg-green-100 p-3 rounded-xl"><i class="fas fa-check-circle text-green-600 text-xl"></i></div>
                    </div>
                </div>
                <div class="glass-card rounded-2xl p-5 sm:p-6 animate-scale-in" style="animation-delay: 0.4s">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm font-medium text-gray-600">Reeds Opgehaald</p><p class="text-3xl font-bold text-gray-600"><?php echo $statusCount['opgehaald'] ?? 0; ?></p></div>
                        <div class="bg-gray-100 p-3 rounded-xl"><i class="fas fa-flag-checkered text-gray-600 text-xl"></i></div>
                    </div>
                </div>
            </div>

            <?php if (empty($bestellingen)): ?>
                <!-- Empty State: als er helemaal geen bestellingen zijn -->
                <div class="glass-card-strong rounded-3xl p-8 sm:p-12 lg:p-16 text-center animate-scale-in">
                    <div class="max-w-md mx-auto">
                        <div class="icon-wrapper p-6 sm:p-8 rounded-full w-24 h-24 sm:w-32 sm:h-32 mx-auto mb-8 flex items-center justify-center animate-pulse-glow"><i class="fas fa-shopping-cart text-4xl sm:text-5xl text-white"></i></div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Nog geen bestellingen</h3>
                        <p class="text-base sm:text-lg text-gray-600 mb-10 leading-relaxed">U heeft nog geen bestellingen geplaatst. Plaats uw eerste bestelling om de status hier te kunnen volgen.</p>
                        <a href="product.view.php" class="nav-indicator brand-gradient text-white px-8 py-3 sm:px-10 sm:py-4 rounded-2xl font-semibold text-base sm:text-lg brand-glow hover:shadow-xl transform hover:scale-105 transition-all duration-300 inline-block"><i class="fas fa-plus mr-3"></i> Nieuwe Bestelling Plaatsen</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Actieve Bestellingen -->
                <?php if (!empty($actieve_bestellingen)): ?>
                    <div class="glass-card-strong rounded-3xl overflow-hidden animate-fade-in mb-10" style="animation-delay: 0.5s">
                        <div class="brand-gradient p-6 sm:p-8">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                                <div><h2 class="text-2xl font-bold text-white mb-1 sm:mb-2">Actieve Bestellingen</h2><p class="text-white/80">Gedetailleerd overzicht van uw lopende bestellingen.</p></div>
                                <div class="modern-badge px-5 py-2 sm:px-6 sm:py-3 rounded-full self-start sm:self-center"><span class="text-brand-700 font-semibold"><?php echo count($actieve_bestellingen); ?> actieve bestellingen</span></div>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 lg:p-8">
                            <div class="space-y-6">
                                <?php foreach ($actieve_bestellingen as $index => $bestelling): ?>
                                    <div class="status-card glass-card rounded-2xl p-4 sm:p-6 animate-slide-in-right" style="animation-delay: <?php echo 0.1 + ($index * 0.1); ?>s">
                                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                                            <div class="flex items-center space-x-4 flex-grow">
                                                <div class="icon-wrapper p-4 rounded-2xl flex-shrink-0"><i class="fas fa-receipt text-white text-xl"></i></div>
                                                <div>
                                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">Bestelling #<?php echo htmlspecialchars($bestelling['id']); ?></h3>
                                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-600">
                                                        <div class="flex items-center space-x-1.5"><i class="fas fa-calendar-alt"></i><span><?php echo (new DateTime($bestelling['besteld_op']))->format('d-m-Y'); ?></span></div>
                                                        <div class="flex items-center space-x-1.5"><i class="fas fa-clock"></i><span><?php echo (new DateTime($bestelling['besteld_op']))->format('H:i'); ?></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ml-4">
                                                <a href="bestelling_details.php?id=<?php echo htmlspecialchars($bestelling['id']); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-sm inline-flex items-center">
                                                    <i class="fas fa-eye mr-2"></i> Bekijk Details
                                                </a>
                                            </div>
                                        </div>
                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                            <div class="flex items-center justify-between">
                                                <div class="nav-indicator overflow-hidden rounded-2xl w-full">
                                                    <span class="inline-flex items-center justify-center w-full px-4 py-3 rounded-2xl text-sm font-semibold border-2 transition-all duration-300 <?php echo getStatusColor($bestelling['status']); ?>">
                                                        <span class="mr-3 flex-shrink-0"><?php echo getStatusIcon($bestelling['status']); ?></span>
                                                        <span class="text-center sm:whitespace-nowrap"><?php echo vertaalStatus($bestelling['status']); ?></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 mt-4">
                                                <?php
                                                $progress = 0;
                                                switch($bestelling['status']) {
                                                    case 'nieuw': $progress = 15; break;
                                                    case 'sign': $progress = 30; break;
                                                    case 'in_behandeling': $progress = 50; break;
                                                    case 'wacht': $progress = 40; break;
                                                    case 'print': $progress = 75; break;
                                                    case 'klaar': $progress = 90; break;
                                                }
                                                ?>
                                                <div class="progress-bar h-2 rounded-full transition-all duration-500" style="width: <?php echo $progress; ?>%"></div>
                                            </div>
                                            <div class="flex justify-between text-xs text-gray-500 mt-1.5">
                                                <span>Bestelling geplaatst</span>
                                                <span><?php echo $progress; ?>% voltooid</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="glass-card-strong rounded-3xl p-8 sm:p-12 lg:p-16 text-center animate-scale-in mb-10">
                        <div class="max-w-md mx-auto">
                            <div class="icon-wrapper p-6 sm:p-8 rounded-full w-24 h-24 sm:w-32 sm:h-32 mx-auto mb-8 flex items-center justify-center animate-pulse-glow">
                                <i class="fas fa-shopping-cart text-4xl sm:text-5xl text-white"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Nog geen bestellingen</h3>
                            <p class="text-base sm:text-lg text-gray-600 mb-10 leading-relaxed">
                                U heeft nog geen bestellingen geplaatst. Plaats uw eerste bestelling om de status hier te kunnen volgen.
                            </p>
                            <a href="product.view.php" class="nav-indicator brand-gradient text-white px-8 py-3 sm:px-10 sm:py-4 rounded-2xl font-semibold text-base sm:text-lg brand-glow hover:shadow-xl transform hover:scale-105 transition-all duration-300 inline-block">
                                <i class="fas fa-plus mr-3"></i>
                                Nieuwe Bestelling Plaatsen
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Bestelgeschiedenis -->
                <?php if (!empty($opgehaalde_bestellingen)): ?>
                    <div class="glass-card-strong rounded-3xl overflow-hidden animate-fade-in" style="animation-delay: 0.7s">
                        <div class="brand-gradient p-6 sm:p-8">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                                <div><h2 class="text-2xl font-bold text-white mb-1 sm:mb-2">Bestelgeschiedenis</h2><p class="text-white/80">Overzicht van uw voltooide bestellingen.</p></div>
                                <div class="modern-badge px-5 py-2 sm:px-6 sm:py-3 rounded-full self-start sm:self-center"><span class="text-brand-700 font-semibold"><?php echo count($opgehaalde_bestellingen); ?> voltooide bestellingen</span></div>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 lg:p-8">
                            <div class="space-y-6">
                                <?php foreach ($opgehaalde_bestellingen as $bestelling): ?>
                                    <div class="status-card glass-card rounded-2xl p-4 sm:p-6 animate-slide-in-right opacity-90 hover:opacity-100 transition-opacity">
                                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                                            <div class="flex items-center space-x-4 flex-grow">
                                                <div class="icon-wrapper p-4 rounded-2xl flex-shrink-0 bg-gray-500"><i class="fas fa-history text-white text-xl"></i></div>
                                                <div>
                                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">Bestelling #<?php echo htmlspecialchars($bestelling['id']); ?></h3>
                                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-600">
                                                        <div class="flex items-center space-x-1.5"><i class="fas fa-calendar-check"></i><span>Voltooid op: <?php echo (new DateTime($bestelling['besteld_op']))->format('d-m-Y'); ?></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ml-4">
                                                <a href="bestelling_details.php?id=<?php echo htmlspecialchars($bestelling['id']); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-sm inline-flex items-center">
                                                    <i class="fas fa-eye mr-2"></i> Bekijk Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Status Legend -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 mt-10 animate-fade-in" style="animation-delay: 0.8s">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center space-x-3">
                <div class="icon-wrapper p-2 rounded-lg"><i class="fas fa-info-circle text-white"></i></div>
                <span>Status Uitleg</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="glass-card rounded-xl p-4 flex items-center space-x-3 hover:scale-105 transition-transform duration-300"><div class="text-blue-600 bg-blue-100 p-2 rounded-lg"><?php echo getStatusIcon('nieuw'); ?></div><div><p class="font-semibold text-blue-800">Nieuw</p><p class="text-xs text-blue-600">In afwachting</p></div></div>
                <div class="glass-card rounded-xl p-4 flex items-center space-x-3 hover:scale-105 transition-transform duration-300"><div class="text-yellow-600 bg-yellow-100 p-2 rounded-lg"><?php echo getStatusIcon('in_behandeling'); ?></div><div><p class="font-semibold text-yellow-800">In Behandeling</p><p class="text-xs text-yellow-600">Wordt verwerkt</p></div></div>
                <div class="glass-card rounded-xl p-4 flex items-center space-x-3 hover:scale-105 transition-transform duration-300"><div class="text-green-600 bg-green-100 p-2 rounded-lg"><?php echo getStatusIcon('klaar'); ?></div><div><p class="font-semibold text-green-800">Klaar</p><p class="text-xs text-green-600">Kan opgehaald worden</p></div></div>
                <div class="glass-card rounded-xl p-4 flex items-center space-x-3 hover:scale-105 transition-transform duration-300"><div class="text-gray-600 bg-gray-100 p-2 rounded-lg"><?php echo getStatusIcon('opgehaald'); ?></div><div><p class="font-semibold text-gray-800">Opgehaald</p><p class="text-xs text-gray-600">Bestelling voltooid</p></div></div>
            </div>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>