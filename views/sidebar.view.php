<?php
// views/sidebar.view.php
// Dit bestand levert de sidebar structuur en de wrapper voor de hoofdcontent.
// Het gaat ervan uit dat het wordt geïncludeerd binnen de <body> tag.
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<!--    MADE BY AHMAD-->

<div class="flex mt-16"> <!-- Added h-screen for consistent height across the layout -->
    <!-- Sidebar for larger screens -->
    <aside class="hidden md:flex fixed top-0 left-0 bottom-0 group flex-col items-center
            w-16 hover:w-48 h-screen py-8
            overflow-y-auto overflow-x-hidden
            dark:bg-gray-900 border-r dark:border-gray-700
            transition-all duration-300 ease-in-out
            z-40">
        <nav class="flex flex-col flex-1 space-y-6 w-full">
            <a href="index.php?page=dashboard" class="flex items-center space-x-4 p-2
                    dark:text-white hover:bg-green-500 dark:hover:bg-purple-600 rounded-lg
                    group-hover:justify-start justify-center">
                <img class="w-6 h-6" src="./uploads/logo.png" alt="PH Logo">
                <span class="hidden group-hover:inline ml-2 whitespace-nowrap">Productie-huis</span>
            </a>

            <a href="index.php?page=dashboard" class="flex items-center space-x-4 p-2
                    dark:text-white hover:bg-green-500 dark:hover:bg-purple-600 rounded-lg
                    group-hover:justify-start justify-center">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="hidden group-hover:inline ml-2 whitespace-nowrap">Dashboard</span>
            </a>

            <a href="index.php?page=producten" class="flex items-center space-x-4 p-2
                    dark:text-white hover:bg-green-500 dark:hover:bg-purple-600 rounded-lg
                    group-hover:justify-start justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 010 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4l4 4m-4-4l-4 4" />
                </svg>
                <span class="hidden group-hover:inline ml-2 whitespace-nowrap">Producten</span>
            </a>

            <!-- NIEUWE LINK: Nieuw Item Toevoegen -->
            <a href="index.php?page=add_item" class="flex items-center space-x-4 p-2
                    dark:text-white hover:bg-green-500 dark:hover:bg-purple-600 rounded-lg
                    group-hover:justify-start justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="hidden group-hover:inline ml-2 whitespace-nowrap">Nieuw Machine</span>
            </a>

            <!-- NIEUWE LINK: Nieuw Item Toevoegen -->
            <a href="index.php?page=videos" class="flex items-center space-x-4 p-2
        dark:text-white hover:bg-green-500 dark:hover:bg-purple-600 rounded-lg
        group-hover:justify-start justify-center">
                <!-- Video camera icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H4.5A2.25 2.25 0 002.25 5.25v13.5A2.25 2.25 0 004.5 21h9a2.25 2.25 0 002.25-2.25V15l5.036 3.354a.75.75 0 001.214-.618V6.264a.75.75 0 00-1.214-.618L15.75 9z" />
                </svg>
                <span class="hidden group-hover:inline ml-2 whitespace-nowrap">Nieuw uitlegvideo's</span>
            </a>

        </nav>

        <!-- Uitlog button onderaan de sidebar -->
        <div class="w-full mt-auto">
            <a href="./views/uitloggen.php" class="flex items-center space-x-4 p-3 mx-2 mb-4
                    dark:text-red-400 hover:bg-red-500 hover:text-white rounded-lg
                    group-hover:justify-start justify-center
                    transition-colors duration-200 ease-in-out
                    border border-red-500/30 hover:border-red-500"
               title="Uitloggen">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <span class="hidden group-hover:inline ml-2 whitespace-nowrap font-medium">Uitloggen</span>
            </a>
        </div>
    </aside>

    <!-- Main content area with left margin to accommodate sidebar -->
    <main class="md:ml-16 flex-1 transition-all duration-300 overflow-y-auto">
        <!-- De specifieke paginacontent (bijv. van add_item.view.php) zal hier worden ingevoegd -->
        <!-- Deze <main> tag wordt impliciet gesloten door het einde van de content van de view file -->
    </main>
</div>

<!-- Hamburger menu for smaller screens (still within body) -->
<nav class="md:hidden fixed top-0 left-0 right-0 px-4 py-4 flex justify-between items-center bg-white dark:bg-gray-900 z-50">
    <a class="text-3xl font-bold leading-none" href="index.php?page=dashboard">
        <img src="./uploads/logo.png" alt="logo" class="h-10">
    </a>

    <div>
        <button class="navbar-burger flex items-center text-green-600 p-3">
            <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Mobile menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg>
        </button>
    </div>
</nav>

<!-- Mobile menu, hidden by default -->
<div class="navbar-menu fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6
        dark:bg-gray-900 border-r dark:border-gray-700
        overflow-y-auto z-50 transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="flex items-center mb-8">
        <a class="mr-auto text-3xl font-bold leading-none" href="index.php?page=dashboard">
            <img src="./uploads/logo.png" alt="logo" class="h-12">
        </a>
        <button class="navbar-close">
            <svg class="h-6 w-6 text-gray-500 cursor-pointer hover:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <div class="flex-1">
        <ul>
            <li class="mb-1">
                <a href="index.php?page=dashboard" class="flex items-center space-x-4 p-2
                        dark:text-white hover:bg-green-500 dark:hover:bg-purple-600 rounded-lg">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="dark:text-white">Dashboard</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="index.php?page=producten" class="flex items-center space-x-4 p-2
                        dark:text-white hover:bg-green-500 dark:hover:bg-purple-600 rounded-lg">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    <span class="dark:text-white">Producten</span>
                </a>
            </li>
            <!-- NIEUWE LINK VOOR MOBIEL: Nieuw Item Toevoegen -->
            <li class="mb-1">
                <a href="index.php?page=add_item" class="flex items-center space-x-4 p-2
                        dark:text-white hover:bg-green-500 dark:hover:bg-purple-600 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="dark:text-white">Nieuw Machine</span>
                </a>
            </li>
            <li class="mb-1">
            <a href="#" class="flex items-center space-x-4 p-2
                        dark:text-white hover:bg-green-500 dark:hover:bg-purple-600 rounded-lgr">
                <!-- Video camera icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H4.5A2.25 2.25 0 002.25 5.25v13.5A2.25 2.25 0 004.5 21h9a2.25 2.25 0 002.25-2.25V15l5.036 3.354a.75.75 0 001.214-.618V6.264a.75.75 0 00-1.214-.618L15.75 9z" />
                </svg>
                <span class="dark:text-white">Nieuw uitlegvideo's</span>
            </a>
            </li>
        </ul>

    </div>

    <!-- Uitlog button onderaan mobiel menu -->
    <div class="mt-auto pt-4 border-t border-gray-700">
        <a href="./views/uitloggen.php" class="flex items-center space-x-4 p-3
                dark:text-red-400 hover:bg-red-500 hover:text-white rounded-lg
                transition-colors duration-200 ease-in-out
                border border-red-500/30 hover:border-red-500"
           title="Uitloggen">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            <span class="dark:text-white font-medium">Uitloggen</span>
        </a>
    </div>
</div>

<!-- Mobile menu backdrop -->
<div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-50 hidden z-40"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const burger = document.querySelector('.navbar-burger');
        const menu = document.querySelector('.navbar-menu');
        const close = document.querySelector('.navbar-close');
        const backdrop = document.querySelector('.navbar-backdrop');

        burger.addEventListener('click', function() {
            menu.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        });

        close.addEventListener('click', function() {
            menu.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        });

        backdrop.addEventListener('click', function() {
            menu.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        });
    });
</script>