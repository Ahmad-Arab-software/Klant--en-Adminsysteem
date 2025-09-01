<!-- Basisinformatie -->
<div x-show="activeTab === 'basic'" class="bg-gray-50 p-6 rounded-lg border border-gray-100 shadow-inner transition-all duration-300">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Categorie -->
        <div class="relative group">
            <label class="block text-gray-700 font-medium mb-2 flex items-center">
                <span class="mr-2 transition-opacity duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                    </svg>
                </span>
                Categorie:
            </label>
            <div class="relative" x-data="{ open: false }">
                <div @click="open = !open" class="block appearance-none w-full bg-white border border-gray-300 hover:border-purple-500 px-4 py-3 pr-8 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200 cursor-pointer flex justify-between items-center">
                    <span x-text="formData.categorie || 'Selecteer categorie'"></span>
                    <svg class="fill-current h-4 w-4 text-purple-600 transition-transform" :class="{'transform rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
                <div x-show="open" @click.away="open = false" class="absolute z-50 w-full bg-white mt-1 border border-gray-300 rounded-lg shadow-lg">
                    <div class="py-1">
                        <?php foreach ($categorieen as $categorie): ?>
                            <div
                                    @click="document.querySelector('select[name=categorie_id]').value = '<?php echo $categorie['id']; ?>'; formData.categorie = '<?php echo addslashes($categorie['naam']); ?>'; open = false"
                                    class="px-4 py-2 hover:bg-purple-100 cursor-pointer flex items-center"
                            >
                                <?php echo htmlspecialchars($categorie['naam']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <select name="categorie_id" class="hidden">
                    <?php foreach ($categorieen as $categorie): ?>
                        <option value="<?php echo $categorie['id']; ?>"><?php echo htmlspecialchars($categorie['naam']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Prijs -->
        <div class="group relative">
            <label class="block text-gray-700 font-medium mb-2 flex items-center">
                <span class="mr-2 transition-opacity duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                    </svg>
                </span>
                Prijs:
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">€</span>
                <input
                        type="text"
                        name="prijs"
                        id="prijs"
                        x-model="formData.prijs"
                        class="border border-gray-300 rounded-lg w-full py-3 pl-8 pr-4 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200"
                        placeholder="bv. 10.00 of 'Op aanvraag'"
                        required
                >
            </div>
        </div>
    </div>

    <!-- Productnaam -->
    <div class="mt-6 group relative">
        <label class="block text-gray-700 font-medium mb-2 flex items-center">
            <span class="mr-2 transition-opacity duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-.092a4.535 4.535 0 00-1.676-.662C6.602 8.34 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                </svg>
            </span>
            Productnaam:
        </label>
        <input
                type="text"
                name="naam"
                x-model="formData.naam"
                class="border border-gray-300 rounded-lg w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200"
                placeholder="Bijv. Visitekaartje"
                required
        >
        <div class="mt-2">
            <div class="text-xs text-gray-500 mb-1">Suggesties:</div>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="text-xs bg-purple-100 hover:bg-purple-200 text-purple-800 px-2 py-1 rounded-full transition-colors duration-200 group" @click="formData.naam = 'Visitekaartje op premium papier'">
                    <span class="mr-1 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                    </span>
                    Visitekaartje op premium papier
                </button>
                <button type="button" class="text-xs bg-purple-100 hover:bg-purple-200 text-purple-800 px-2 py-1 rounded-full transition-colors duration-200 group" @click="formData.naam = 'T-shirt met bedrukking'">
                    <span class="mr-1 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                    </span>
                    T-shirt met bedrukking
                </button>
                <button type="button" class="text-xs bg-purple-100 hover:bg-purple-200 text-purple-800 px-2 py-1 rounded-full transition-colors duration-200 group" @click="formData.naam = '3D geprinte sleutelhanger'">
                    <span class="mr-1 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                    </span>
                    3D geprinte sleutelhanger
                </button>
            </div>
        </div>
    </div>

    <!-- Beschrijving -->
    <div class="mt-4 group relative">
        <label class="block text-gray-700 font-medium mb-2 flex items-center">
            <span class="mr-2 transition-opacity duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                </svg>
            </span>
            Beschrijving:
        </label>
        <div class="rounded-lg border border-gray-300 focus-within:ring-2 focus-within:ring-purple-500 focus-within:border-transparent overflow-hidden transition duration-200">
            <div class="flex items-center bg-gray-100 border-b border-gray-200 px-3 py-2">
                <button type="button" class="text-gray-600 hover:text-purple-700 mr-3 focus:outline-none transition-colors duration-200 group" title="Vet" @click="formData.beschrijving += ' **vet** '">
                    <span class="transition-opacity duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span class="ml-1">B</span>
                </button>
                <button type="button" class="text-gray-600 hover:text-purple-700 mr-3 focus:outline-none transition-colors duration-200 group" title="Cursief" @click="formData.beschrijving += ' *cursief* '">
                    <span class="transition-opacity duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span class="ml-1">I</span>
                </button>
            </div>
            <textarea
                    name="beschrijving"
                    x-model="formData.beschrijving"
                    rows="4"
                    class="w-full p-3 border-none focus:outline-none focus:ring-0"
                    placeholder="Geef een gedetailleerde beschrijving van het product..."
            ></textarea>
        </div>
    </div>
</div>