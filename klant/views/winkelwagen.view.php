<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="../media/logo.png">
    <!--    MADE BY AHMAD-->

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        accentGreen: '#34D399', // Tailwind green-400
                        accentPurple: '#A78BFA', // Tailwind purple-400
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
                    }
                }
            }
        }
    </script>

    <style>
        .spinner {
            border: 3px solid rgba(167, 139, 250, 0.2);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border-left-color: #A78BFA;
            animation: spin 1s ease infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseSoft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-modern {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-modern:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .modal-backdrop {
            backdrop-filter: blur(8px);
            background: rgba(0, 0, 0, 0.4);
        }

        .loading-gradient {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>

<body class="gradient-bg min-h-screen text-gray-900 font-sans">
<?php include 'navbar.php'; ?>

<div class="container mx-auto mt-8 p-4 md:p-8 max-w-6xl" id="winkelwagen-app">


    <!-- Main Content -->
    <div id="winkelwagen-container" class="animate-fade-in">
        <!-- Loading State -->
        <div class="glass-effect rounded-2xl p-12 text-center shadow-xl">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-accentPurple/10 to-purple-600/10 mb-6">
                <div class="spinner"></div>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Winkelwagen laden...</h3>
            <p class="text-gray-600">Even geduld terwijl we uw producten ophalen</p>

            <!-- Loading skeleton -->
            <div class="mt-8 space-y-4">
                <div class="loading-gradient h-20 rounded-xl"></div>
                <div class="loading-gradient h-20 rounded-xl"></div>
                <div class="loading-gradient h-16 rounded-xl"></div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="cartErrorModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/50">
        <div class="glass-effect rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-slide-up bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <i class="fas fa-exclamation-circle fa-2x text-red-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Oops, er ging iets mis!</h3>
                <p class="text-gray-600 mb-8" id="cartErrorModalText"></p>
                <button type="button" onclick="document.getElementById('cartErrorModal').classList.add('hidden')"
                        class="btn-modern w-full py-3 px-6 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-semibold hover:from-red-600 hover:to-red-700">
                    <i class="fas fa-times mr-2"></i>Sluiten
                </button>
            </div>
        </div>
    </div>


    <!-- Success Modal -->
    <div id="cartSuccessModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center modal-backdrop">
        <!-- De 'flex' class is hierboven toegevoegd -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 max-w-md mx-4 text-center animate-slide-up">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                <i class="fas fa-check-circle fa-2x text-accentGreen"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Perfect!</h3>
            <p class="text-gray-600 mb-8" id="cartSuccessModalText"></p>
            <div class="spinner mx-auto"></div>
        </div>
    </div>


</div>
<!-- Remove Confirmation Modal -->
<div id="removeConfirmationModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center modal-backdrop">
    <!--                                                                ^^^^  <-- DEZE TOEGEVOEGD -->
    <div class="glass-effect rounded-2xl shadow-2xl p-8 max-w-lg mx-4 animate-slide-up">
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-amber-100 mr-4">
                <i class="fas fa-exclamation-triangle fa-xl text-amber-600"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    Product verwijderen?
                </h3>
                <p class="text-gray-600">
                    Dit product wordt permanent uit uw winkelwagen verwijderd.
                </p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="button"
                    class="remove-confirm-button btn-modern flex-1 py-3 px-6 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-semibold hover:from-red-600 hover:to-red-700">
                <i class="fas fa-trash mr-2"></i>Ja, verwijderen
            </button>
            <button type="button"
                    class="remove-cancel-button btn-modern flex-1 py-3 px-6 bg-gradient-to-r from-accentPurple to-purple-600 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-purple-700">
                <i class="fas fa-arrow-left mr-2"></i>Annuleren
            </button>
        </div>
    </div>
</div>
<script src="../js/winkelwagen.js" defer></script>
</body>
</html>