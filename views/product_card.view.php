<?php /** @var array $product */ ?>
<div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
    <!-- Media preview header -->
    <!--    MADE BY AHMAD-->

    <div class="relative h-48 md:h-56 lg:h-64 bg-gray-100 overflow-hidden">
        <?php if (!empty($product['media'])): ?>
            <?php
            $media = $product['media'][0]; // First media item as header
            $file_extension = pathinfo($media, PATHINFO_EXTENSION);
            $file_path = 'uploads/' . htmlspecialchars($media);
            ?>
            <?php if (in_array($file_extension, ['mp4', 'webm', 'ogg'])): ?>
                <div class="absolute inset-0 flex items-center justify-center">
                    <video class="w-full h-full object-cover" loop muted>
                        <source src="<?= $file_path ?>" type="video/<?= $file_extension ?>">
                    </video>
                    <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white opacity-75 hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            <?php else: ?>
                <img src="<?= $file_path ?>" alt="<?= htmlspecialchars($product['naam']) ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
            <?php endif; ?>
        <?php else: ?>
            <!-- Placeholder if no media -->
            <div class="flex items-center justify-center h-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        <?php endif; ?>

        <!-- Category badge -->
        <div class="absolute top-4 left-4">
            <span class="bg-purple-600 bg-opacity-90 text-white text-xs font-medium px-3 py-1.5 rounded-full flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <?php echo htmlspecialchars($product['categorie_naam']); ?>
            </span>
        </div>

        <!-- Price badge -->
        <div class="absolute top-4 right-4">
            <span class="bg-black bg-opacity-90 text-white font-bold px-3 py-1.5 rounded-full flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <?php
                // Check if price is a number. If so, format it. Otherwise, display the text.
                if (is_numeric($product['prijs'])) {
                    echo '€' . number_format($product['prijs'], 2, ',', '.');
                } else {
                    echo htmlspecialchars($product['prijs']);
                }
                ?>
            </span>
        </div>
    </div>

    <!-- Content section -->
    <div class="p-5 lg:p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-purple-700 transition-colors duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <?php echo htmlspecialchars($product['naam']); ?>
        </h3>

        <!-- Product description -->
        <?php if (!empty($product['beschrijving'])): ?>
            <div class="mb-5">
                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Beschrijving
                </h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    <?php echo htmlspecialchars($product['beschrijving']); ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (!empty($product['opties'])): ?>
            <div class="mb-5">
                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 00-2 2h2a2 2 0 002-2m0 4a2 2 0 012-2h2a2 2 0 012 2m0 4h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Opties
                </h4>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($product['opties'] as $optie): ?>
                        <div class="bg-gray-100 rounded-lg px-3 py-1.5 text-xs flex items-center">
                            <span class="font-medium"><?php echo htmlspecialchars($optie['optie_naam']); ?>:</span>
                            <span class="ml-1"><?php echo htmlspecialchars(implode(', ', $optie['keuzes'])); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($product['media']) && count($product['media']) > 1): ?>
            <div class="mb-5">
                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Media gallerij
                </h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    <?php
                    $galleryItems = array_slice($product['media'], 1, 3); // Show next 3 media items
                    foreach ($galleryItems as $index => $mediaItem): ?>
                        <?php
                        $file_extension = pathinfo($mediaItem, PATHINFO_EXTENSION);
                        $file_path = 'uploads/' . htmlspecialchars($mediaItem);
                        ?>
                        <?php if (in_array($file_extension, ['mp4', 'webm', 'ogg'])): ?>
                            <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="absolute inset-0 group-hover:bg-black group-hover:bg-opacity-20 transition-colors duration-300"></div>
                            </div>
                        <?php else: ?>
                            <div class="relative aspect-square rounded-lg overflow-hidden group">
                                <img src="<?= $file_path ?>" alt="Media <?= $index + 2 ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 group-hover:bg-black group-hover:bg-opacity-20 transition-colors duration-300"></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if (count($product['media']) > 4): ?>
                        <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center group">
                            <span class="text-gray-500 text-sm font-medium flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                +<?= count($product['media']) - 4 ?> meer
                            </span>
                            <div class="absolute inset-0 group-hover:bg-black group-hover:bg-opacity-10 transition-colors duration-300"></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Display allowed file types -->
        <?php if (!empty($product['allowed_file_types'])): ?>
            <div class="mb-5">
                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Toegestane Bestandstypen
                </h4>
                <div class="flex flex-wrap gap-2">
                    <?php
                    $allowedFileTypes = explode(',', $product['allowed_file_types']);
                    foreach ($allowedFileTypes as $fileType): ?>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded-full flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <?= trim(htmlspecialchars($fileType)); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Display technical videos -->
        <?php if (!empty($product['videos'])): ?>
            <div class="mb-5">
                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 10.5v3a1 1 0 01-.447.894L16 18l-4-4-4 4-4-4v-2.5a1 1 0 01.553-.894L8 8.5V6a1 1 0 011-1h2a1 1 0 011 1v2.5" />
                    </svg>
                    Techniek Video's
                </h4>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($product['videos'] as $videoId): ?>
                        <?php
                        require_once __DIR__ . '/../logic/video.logic.php';
                        $videoDetails = getVideoDetails($videoId);
                        if ($videoDetails): ?>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <?= htmlspecialchars($videoDetails['name']); ?>
                            </span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer actions -->
    <div class="border-t border-gray-100 p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-sm text-gray-500 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            Product #<?= $product['id'] ?>
        </span>
        <div class="flex space-x-2 w-full sm:w-auto">
            <button type="button"
                    class="edit-btn bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 flex items-center justify-center transition-colors duration-300 text-sm flex-1 sm:flex-auto"
                    data-id="<?= $product['id'] ?>"
                    data-categorie="<?= $product['categorie_id'] ?>"
                    data-naam="<?= htmlspecialchars($product['naam']) ?>"
                    data-beschrijving="<?= htmlspecialchars($product['beschrijving']) ?>"
                    data-prijs="<?= htmlspecialchars($product['prijs']) ?>"
                    data-file_types="<?= htmlspecialchars($product['file_types'] ?? '') ?>"
                    data-requirements="<?= htmlspecialchars($product['requirements'] ?? '') ?>"
                    data-allowed_file_types="<?= htmlspecialchars($product['allowed_file_types'] ?? '') ?>"
                    data-videos="<?= htmlspecialchars(json_encode($product['videos'] ?? [])) ?>"
                    data-opties="<?= htmlspecialchars(json_encode($product['opties'] ?? [])) ?>"
                    data-media="<?= htmlspecialchars(json_encode($product['media'] ?? [])) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Bewerken
            </button>
            <button type="button"
                    class="delete-btn bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center justify-center transition-colors duration-300 text-sm flex-1 sm:flex-auto"
                    data-id="<?= $product['id'] ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m6-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Verwijderen
            </button>
        </div>
    </div>
</div>