
<!--    MADE BY AHMAD-->
<!-- Edit Modal -->
<div id="editProductModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-xl shadow-lg z-50 w-11/12 md:w-4/5 lg:w-3/4 overflow-y-auto max-h-screen">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-green-700 rounded-t-xl flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-pencil-alt fa-lg mr-2"></i>
                <h3 class="text-xl font-semibold text-white">Product Bewerken</h3>
            </div>
            <button id="closeEditModal" type="button" class="text-white hover:text-gray-100 focus:outline-none">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="edit-product-form" action="index.php?page=producten" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            <input type="hidden" name="product_id" id="edit_product_id">

            <!-- Categorie Selectie -->
            <div>
                <label for="edit_categorie_id" class="block text-sm font-medium text-gray-700"><i class="fas fa-folder-open mr-2"></i>Categorie:</label>
                <select id="edit_categorie_id" name="categorie_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                    <?php foreach ($categorieen as $categorie): ?>
                        <option value="<?php echo htmlspecialchars($categorie['id']); ?>">
                            <?php echo htmlspecialchars($categorie['naam']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Naam Input -->
            <div>
                <label for="edit_naam" class="block text-sm font-medium text-gray-700"><i class="fas fa-signature mr-2"></i>Naam:</label>
                <input type="text" name="naam" id="edit_naam" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <!-- Beschrijving Textarea -->
            <div>
                <label for="edit_beschrijving" class="block text-sm font-medium text-gray-700"><i class="fas fa-file-alt mr-2"></i>Beschrijving:</label>
                <textarea id="edit_beschrijving" name="beschrijving" rows="3" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>

            <!-- Prijs Input -->
            <div>
                <label for="edit_prijs" class="block text-sm font-medium text-gray-700"><i class="fas fa-euro-sign mr-2"></i>Prijs:</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                        <span class="text-gray-500 sm:text-sm">€</span>
                    </div>
                    <input type="text" name="prijs" id="edit_prijs" class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="bv. 10.00 of 'Op aanvraag'" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">EUR</span>
                    </div>
                </div>
            </div>

            <!-- Producteisen in Edit Modal -->
            <div>
                <label for="edit_requirements" class="block text-sm font-medium text-gray-700"><i class="fas fa-clipboard-list mr-2"></i>Producteisen:</label>
                <textarea id="edit_requirements" name="requirements" rows="3" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Specificeer hier de eisen voor het aan te leveren bestand (bijv. minimale resolutie, kleurmodus, etc.)."></textarea>
            </div>

            <!-- File Types Checkboxes in Edit Modal -->
            <div>
                <label class="block text-sm font-medium text-gray-700"><i class="fas fa-file-upload mr-2"></i>Toegestane Bestandstypen:</label>
                <p class="text-gray-500 text-xs italic mt-1">Selecteer de toegestane bestandstypen.</p>
                <div id="edit_file_types_checkboxes" class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                    <?php
                    $fileTypes = ['PDF', 'EPS', 'AI', 'JPG', 'PNG', 'SVG', 'TIFF', 'GIF'];
                    foreach ($fileTypes as $fileType): ?>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="edit_file_type_<?php echo strtolower($fileType); ?>" name="allowed_file_types[]" value="<?php echo htmlspecialchars($fileType); ?>" type="checkbox" class="file-type-checkbox focus:ring-purple-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="edit_file_type_<?php echo strtolower($fileType); ?>" class="font-medium text-gray-700"><?php echo htmlspecialchars($fileType); ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Techniek Video's Checkboxes in Edit Modal -->
            <div>
                <label class="block text-sm font-medium text-gray-700"><i class="fas fa-video mr-2"></i>Techniek Video's:</label>
                <div id="edit_video-checkboxes" class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                    <!-- Video checkboxes will be dynamically added here by JavaScript -->
                </div>
            </div>

            <!-- Current Media Preview -->
            <div>
                <label class="block text-sm font-medium text-gray-700"><i class="fas fa-photo-video mr-2"></i>Huidige Media:</label>
                <div id="currentMediaPreview" class="mt-2 flex flex-wrap gap-3">
                    <!-- Media items will be loaded here by JavaScript -->
                </div>
            </div>

            <!-- Media Upload Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700"><i class="fas fa-plus-circle mr-2"></i>Nieuwe Media Toevoegen:</label>
                <input type="file" name="media[]" id="edit_media-upload" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" multiple accept="image/*,video/mp4">
                <div id="edit_preview-container" class="mt-2 flex flex-wrap gap-3"></div>
            </div>

            <!-- Productopties in de edit modal -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-list-alt mr-2"></i>Productopties:</label>
                <div id="edit_product-opties" class="space-y-4">
                    <!-- Option groups will be added dynamically by JavaScript -->
                </div>
                <button type="button" id="edit_add-optie" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>Optie Toevoegen
                </button>
            </div>

            <!-- Modal Actions -->
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-xl">
                <button type="button" id="cancelEdit" class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Annuleren
                </button>
                <button type="submit" name="edit_product" class="ml-3 inline-flex justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="./js/modals_producten.js" defer></script>