<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navbar</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../css/navbar.css">
    <!--    MADE BY AHMAD-->
    <link rel="icon" type="image/x-icon" href="../../media/logo.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>
<body class="text-white">
<!-- Navbar -->
<nav class="bg-white shadow-md">
    <input type="checkbox" id="nav-toggle" class="hidden" />
    <div class="logo flex items-center px-6 py-4">
        <a href="index.php">
            <img class="logo-img" src="../media/logo.png" alt="logo" />
        </a>
    </div>
    <ul class="links flex space-x-6 px-6 py-3 items-center">
        <li><a href="index.php" class="text-gray-700 hover:text-green-500">Home</a></li>
        <li><a href="product.view.php" class="text-gray-700 hover:text-green-500">Producten</a></li>
        <li><a href="machine.view.php" class="text-gray-700 hover:text-green-500">Machines</a></li>
        <li><a href="techniek.view.php" class="text-gray-700 hover:text-green-500">Uitlegvideo's</a></li>
        <li><a href="status_view.php" class="text-gray-700 hover:text-green-500">Bestelstatus</a></li>
        <li class="relative">
            <a href="winkelwagen.view.php" class="text-white">
                <span class="fa-solid fa-cart-shopping text-xl text-[#8FE507] hover:text-[#8b5cf6]"></span>
                <span id="cart-count" class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold text-white bg-purple-500 rounded-full -mt-1 -mr-1">
                    0
                </span>
            </a>
        </li>
        <li>
            <a href="uitloggen.php" class="text-gray-700 hover:text-red-500" title="Logout">
                <span class="fa-solid fa-right-from-bracket logout-icon"></span>
            </a>
        </li>
    </ul>

    <label for="nav-toggle" class="icon-burger cursor-pointer">
        <div class="line bg-gray-700"></div>
        <div class="line bg-gray-700"></div>
        <div class="line bg-gray-700"></div>
    </label>
</nav>


<!-- 👇 HIER IS DE WIJZIGING 👇 -->
<script>
    // Maak de updateCartCount functie globaal beschikbaar
    window.updateCartCount = function() {
        function getCartFromLocalStorage() {
            const cartString = localStorage.getItem('winkelwagen');
            return cartString ? JSON.parse(cartString) : {};
        }

        const cart = getCartFromLocalStorage();
        let totalItems = 0;
        for (const itemKey in cart) {
            // Zorg ervoor dat quantity als een getal wordt behandeld
            totalItems += parseInt(cart[itemKey].quantity) || 0;
        }
        document.getElementById('cart-count').textContent = totalItems;
    }

    // Voer de functie uit wanneer de pagina laadt
    document.addEventListener('DOMContentLoaded', function() {
        window.updateCartCount();
    });

    // NIEUW: Luister naar wijzigingen in localStorage vanuit andere tabs/vensters
    window.addEventListener('storage', function(event) {
        // Controleer of de 'winkelwagen' key is gewijzigd
        if (event.key === 'winkelwagen') {
            window.updateCartCount();
        }
    });
</script>
</body>
</html>