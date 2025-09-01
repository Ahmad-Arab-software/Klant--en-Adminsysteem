<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <!-- BELANGRIJKE TOEVOEGING: Viewport meta tag om correcte schaling en zoom-gedrag op mobiel te garanderen -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GLR Webshop - Inloggen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="./klant/media/logo.png">
    <!--    MADE BY AHMAD-->

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Nimbus Sans', 'system-ui', 'sans-serif'],
                    },
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
                        'fade-up': 'fadeUp 0.6s ease-out forwards',
                        'slide-right': 'slideRight 0.6s ease-out forwards'
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
                        slideRight: {
                            '0%': { transform: 'translateX(100%)', opacity: '0' },
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
        @import url('https://fonts.googleapis.com/css2?family=Nimbus+Sans:wght@400;500;600;700&display=swap');

        /* AANPASSING: De 'overflow: hidden' is hier weggehaald.
           Dit is een betere praktijk om onverwacht afgesneden content op kleine schermen te voorkomen. */
        * {
            font-family: 'Nimbus Sans', system-ui, sans-serif;
        }

        body {
            font-family: 'Nimbus Sans', system-ui, sans-serif;
            /* Voorkomt horizontaal scrollen, maar staat verticaal scrollen toe indien nodig */
            overflow-x: hidden;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-white via-green-50 to-glr-groen/20 flex font-sans">
<!-- Left side - Process Steps (blijft verborgen op mobiel) -->
<div class="hidden lg:flex lg:w-1/2 bg-white shadow-2xl flex-col justify-center p-12 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 bg-gradient-to-br from-glr-groen/5 to-transparent"></div>
    <div class="absolute top-10 right-10 w-32 h-32 bg-glr-groen/10 rounded-full animate-float"></div>
    <div class="absolute bottom-20 left-10 w-24 h-24 bg-glr-groen/5 rounded-lg rotate-12 animate-pulse-slow"></div>

    <div class="relative z-10">
        <!-- GLR Webshop Header -->
        <div class="mb-12 animate-slide-in">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-glr-groen rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">GLR Webshop</h1>
                    <p class="text-sm text-gray-600">Grafisch Lyceum Rotterdam</p>
                </div>
            </div>
            <p class="text-gray-700 text-lg leading-relaxed">
                Van ontwerp tot eindproduct in <span class="text-glr-groen font-semibold">4 eenvoudige stappen</span>
            </p>
        </div>

        <!-- Process Steps -->
        <div class="space-y-8">
            <!-- Step 1 -->
            <div class="flex items-start group animate-fade-up" style="animation-delay: 0.1s;">
                <div class="flex-shrink-0 w-12 h-12 bg-glr-groen rounded-full flex items-center justify-center text-white font-bold text-lg mr-4 group-hover:scale-110 transition-transform duration-300">
                    01
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Categorie Kiezen</h3>
                    <p class="text-gray-600">Browse door onze categorieën en vind het perfecte product voor jouw project.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex items-start group animate-fade-up" style="animation-delay: 0.2s;">
                <div class="flex-shrink-0 w-12 h-12 bg-glr-groen rounded-full flex items-center justify-center text-white font-bold text-lg mr-4 group-hover:scale-110 transition-transform duration-300">
                    02
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Bestand Uploaden</h3>
                    <p class="text-gray-600">Upload je ontwerp en wij zorgen voor de professionele productie ervan.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex items-start group animate-fade-up" style="animation-delay: 0.3s;">
                <div class="flex-shrink-0 w-12 h-12 bg-glr-groen rounded-full flex items-center justify-center text-white font-bold text-lg mr-4 group-hover:scale-110 transition-transform duration-300">
                    03
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Afrekenen</h3>
                    <p class="text-gray-600">Reken je producten op bij het Productiehuis.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex items-start group animate-fade-up" style="animation-delay: 0.4s;">
                <div class="flex-shrink-0 w-12 h-12 bg-glr-groen rounded-full flex items-center justify-center text-white font-bold text-lg mr-4 group-hover:scale-110 transition-transform duration-300">
                    04
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ophalen</h3>
                    <p class="text-gray-600">Haal je product op bij het Productiehuis en bewonder het eindresultaat!</p>
                </div>
            </div>
        </div>

        <!-- Bottom decoration -->
        <div class="mt-12 pt-8 border-t border-gray-200 animate-fade-up" style="animation-delay: 0.5s;">
            <p class="text-sm text-gray-500 flex items-center">
                <svg class="w-4 h-4 text-glr-groen mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Professionele kwaliteit, student-vriendelijke prijzen
            </p>
        </div>
    </div>
</div>

<!-- Right side - Login Form -->
<div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 lg:p-12">
    <div class="w-full max-w-md">
        <!-- Mobile header (alleen zichtbaar op kleine schermen) -->
        <div class="lg:hidden text-center mb-8 animate-slide-right">
            <div class="w-16 h-16 bg-glr-groen rounded-2xl mx-auto mb-4 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">GLR Webshop</h1>
            <p class="text-xl text-gray-600">Grafisch Lyceum Rotterdam</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-6 sm:p-8 animate-slide-right w-full" style="animation-delay: 0.2s;">
            <!-- Login Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-glr-groen to-green-400 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg shadow-glr-groen/25">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Welkom terug!</h2>
                <p class="text-gray-600 text-base">Log in om te beginnen met bestellen</p>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="space-y-6">
                <!-- Username Field -->
                <div class="space-y-2">
                    <label class="block text-lg font-medium text-gray-700">
                        Studentennummer
                        <span class="text-sm text-gray-500 normal-font">(zonder </span>
                        <span class="text-sm text-gray-500">@glr.nl-adres)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input
                                type="text"
                                name="username"
                                placeholder="Je GLR studentennummer"
                                required
                        class="w-full text-lg pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-glr-groen focus:border-transparent transition-all duration-300 text-gray-900 placeholder-gray-500 hover:border-gray-300"
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label class="block text-lg font-medium text-gray-700">Wachtwoord
                    <span class="text-sm text-gray-500 normal-font">(log in met </span>
                    <span class="text-sm text-gray-500">GLR-wachtwoord)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input
                                type="password"
                                name="password"
                                id="passwordField"
                                placeholder="Je wachtwoord"
                                required
                        class="w-full text-lg pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-glr-groen focus:border-transparent transition-all duration-300 text-gray-900 placeholder-gray-500 hover:border-gray-300"
                        >
                        <button
                                type="button"
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                        >
                            <svg id="eyeIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="eyeOffIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                        type="submit"
                class="w-full py-4 text-lg bg-gradient-to-r from-glr-groen to-green-400 text-white font-semibold rounded-xl shadow-lg shadow-glr-groen/25 hover:shadow-xl hover:shadow-glr-groen/30 transform transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-glr-groen/30"
                >
                <span class="flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Inloggen
                        </span>
                </button>
            </form>

            <!-- Error Message -->
            <div class="mt-6">
                <p id="error" class="text-red-600 text-base text-center min-h-[1.25rem] bg-red-50 rounded-lg p-3 border border-red-200 hidden"></p>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-gray-500 text-base mb-4">
                    Gebruik je school-inloggegevens
                </p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4 text-sm text-gray-400">
                        <span class="flex items-center">
                            <div class="w-2 h-2 bg-glr-groen rounded-full mr-2"></div>
                            Veilig
                        </span>
                    <span class="flex items-center">
                            <div class="w-2 h-2 bg-glr-groen rounded-full mr-2"></div>
                            Betrouwbaar
                        </span>
                    <span class="flex items-center">
                            <div class="w-2 h-2 bg-glr-groen rounded-full mr-2"></div>
                            Student-vriendelijk
                        </span>
                </div>
            </div>
        </div>

        <!-- Bottom text -->
        <div class="text-center mt-6 animate-fade-up" style="animation-delay: 0.4s;">
            <p class="text-gray-500 text-base">
                Hulp nodig? Bezoek het <span class="text-glr-groen font-medium">Productiehuis</span>
            </p>
        </div>
    </div>
</div>

<script src="js/login.js"></script>
</body>
</html>