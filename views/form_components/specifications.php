<!-- Specificaties -->
<div x-show="activeTab === 'specs'" class="bg-gray-50 p-6 rounded-lg border border-gray-100 shadow-inner transition-all duration-300">
    <!-- Producteisen -->
    <div class="mt-6">
        <label class="block text-gray-700 font-medium mb-2 flex items-center">
            <span class="mr-2 transition-opacity duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6M9 3h6a2 2 0 012 2v2H7V5a2 2 0 012-2zM9 12h6M9 16h6M9 20h6" />
                </svg>
            </span>
            Producteisen:
        </label>
        <textarea
                name="requirements"
                x-model="formData.requirements"
                rows="3"
                class="border border-gray-300 rounded-lg w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200"
                placeholder="Specificeer hier de eisen voor het aan te leveren bestand (bijv. minimale resolutie, kleurmodus, etc.)."
        ></textarea>
    </div>

    <!-- Toegestane bestandstypen -->
    <div class="mt-6">
        <label class="block text-gray-700 font-medium mb-2 flex items-center">
            <span class="mr-2 transition-opacity duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h10M5 5v14a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2z" />
                </svg>
            </span>
            Toegestane bestandstypen:
        </label>
        <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
            <?php $allowedFileTypes = ['PDF', 'EPS', 'AI', 'JPG', 'PNG', 'SVG', 'TIFF', 'GIF', 'STL', 'OBJ']; ?>
            <?php foreach ($allowedFileTypes as $fileType): ?>
                <div class="relative flex items-center">
                    <input
                            id="allowed_file_type_<?php echo strtolower($fileType); ?>"
                            name="allowed_file_types[]"
                            value="<?php echo htmlspecialchars($fileType); ?>"
                            type="checkbox"
                            x-model="formData.allowed_file_types"
                            class="focus:ring-purple-500 h-4 w-4 text-purple-600 border-gray-300 rounded transition duration-200"
                    >
                    <label for="allowed_file_type_<?php echo strtolower($fileType); ?>" class="ml-2 text-gray-700 font-medium">
                        <?php echo htmlspecialchars($fileType); ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Techniek Video's -->
    <div class="mt-6">
        <label class="block text-gray-700 font-medium mb-2 flex items-center">
            <span class="mr-2 transition-opacity duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6h8a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
                </svg>
            </span>
            Techniek Video's:
        </label>
        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
            <?php foreach ($videos as $video): ?>
                <div class="relative flex items-center">
                    <input
                            id="video_<?php echo $video['id']; ?>"
                            name="product_videos[]"
                            value="<?php echo $video['id']; ?>"
                            type="checkbox"
                            x-model="formData.product_videos"
                            class="focus:ring-purple-500 h-4 w-4 text-purple-600 border-gray-300 rounded transition duration-200"
                    >
                    <label for="video_<?php echo $video['id']; ?>" class="ml-2 text-gray-700 font-medium"><?php echo htmlspecialchars($video['name']); ?></label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>