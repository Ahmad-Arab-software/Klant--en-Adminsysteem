<?php include 'header.view.php'; ?>
<!--    MADE BY AHMAD-->

<div class="flex flex-col md:flex-row">
    <?php include 'sidebar.view.php'; ?>
    <div class="flex-1 p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-bold text-green-700 mb-6 flex items-center">
            <!-- Green icon -->
            <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 010 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4l4 4m-4-4l-4 4" />
            </svg>
            Producten
        </h1>
        <?php include 'add_product.view.php'; ?>

        <!-- Overview of existing products -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-purple-700 mb-4 flex items-center">
                <i class="fas fa-box-open fa-lg mr-2 text-purple-700"></i> <!-- Font Awesome Icon -->
                Bestaande Producten
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($producten as $product): ?>
                    <?php include __DIR__ . '/product_card.view.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Include de modals voor bewerken en verwijderen -->
        <?php include 'modals_producten.view.php'; ?>
        <!-- JavaScript -->
        <script src="./js/script.js" defer></script>
        <script src="./js/product_options.js" defer></script>
        <script src="./js/modals_producten.js" defer></script>
        <script type="text/javascript">
            const categorieenData = <?php echo json_encode($categorieen);?>;
            const videoOptionsData = <?php echo json_encode($videos);?>;
        </script>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-xl shadow-lg z-50 w-11/12 md:w-4/5 lg:w-1/2">
        <div class="px-6 py-4 border-b border-gray-200 bg-red-50 rounded-t-xl">
            <h3 class="text-xl font-semibold text-red-700 flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.876c1.541 0 2.502-1.867 1.732-3V9.57c.77-.867-.192-3-1.732-3h-6.575M6 12a1 1 0 11-2 0 1 1 0 01 2 0z" />
                </svg>
                Verwijderen bevestigen
            </h3>
        </div>
        <div class="p-6">
            <p class="text-gray-700">
                Weet je zeker dat je dit product wilt verwijderen? Dit kan niet ongedaan gemaakt worden.
            </p>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-xl">
            <button type="button" id="cancelDelete" class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Annuleren
            </button>
            <form id="deleteForm" action="index.php?page=producten" method="POST" class="inline-block">
                <input type="hidden" name="delete_product" value="1">
                <input type="hidden" id="deleteProductId" name="product_id">
                <button type="submit" id="confirmDelete" class="ml-3 inline-flex justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Verwijderen
                </button>
            </form>
        </div>
    </div>
</div>