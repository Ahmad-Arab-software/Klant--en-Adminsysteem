<?php
// Assuming product_detail.logic.php is included before this view file
require_once __DIR__ . '/../../klant/logic/product_detail.logic.php';

// Haal de techniekvideo's op voor het product (Assuming this is done in logic)
// Mock data if function doesn't exist yet for testing purposes
if (!function_exists('getTechniekVideosForProduct')) {
    function getTechniekVideosForProduct($productId) {
        return []; // Return empty array if no videos or function not ready
    }
}
$techniek_videos = getTechniekVideosForProduct($product['id']);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['naam'] ?? 'Product Details') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="..//media/logo.png">
    <!--    MADE BY AHMAD-->

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Optional: Define custom colors if needed, or use Tailwind's default palettes
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-green': '#8fe507', // Your specific green
                        'custom-green-darker': '#7bc906',
                        'custom-purple': '#7e22ce', // Example purple (Tailwind purple-600)
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar styles with purple accent */
        .thumbnails::-webkit-scrollbar {
            height: 8px;
        }
        .thumbnails::-webkit-scrollbar-thumb {
            background-color: #c4b5fd; /* purple-300 */
            border-radius: 10px;
        }
        /* Accordion styles */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .accordion-icon {
            transition: transform 0.3s ease;
        }
        .accordion-icon.rotate-180 {
            transform: rotate(180deg);
        }
        /* Ensure sufficient contrast for prose text on light background */
        .prose { color: #374151; /* gray-700 */ }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose strong { color: #111827; /* gray-900 */ }
        .prose a { color: #6b21a8; /* purple-700 */ } /* Example link color */
        .prose a:hover { color: #581c87; /* purple-800 */ }
    </style>
</head>
<body class="bg-white">
<?php include 'navbar.php'; // Assuming navbar exists and is styled appropriately ?>
<div class="bg-white min-h-screen">
    <!-- Breadcrumb Navigation -->
    <div class="container mx-auto px-4 py-3">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <!-- Use a purple hover for links -->
                    <a href="/test_ph/klant/views/index.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-purple-600">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <a href="/test_ph/klant/views/product.view.php" class="text-sm font-medium text-gray-700 hover:text-purple-600">
                            Categorieën
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">
                            <?= htmlspecialchars($product['categorie_naam'] ?? 'Categorie') ?>
                        </span>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">
                                <?= htmlspecialchars($product['naam'] ?? 'Product') ?>
                            </span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-wrap -mx-4">
            <!-- Product Images -->
            <div class="w-full md:w-1/2 px-4 mb-8">
                <?php
                $mainImageFilename = isset($product['images'][0]) ? $product['images'][0] : 'default_image.jpg';
                $mainImageUrl = getAfbeeldingUrl($mainImageFilename);
                ?>
                <!-- Use a very light gray background for image container to stand out slightly -->
                <div class="h-[450px] w-full rounded-lg shadow-md mb-4 overflow-hidden bg-gray-100 flex items-center justify-center">
                    <img src="<?= htmlspecialchars($mainImageUrl) ?>" alt="<?= htmlspecialchars($product['naam']) ?>"
                         class="max-w-full max-h-full object-contain" id="mainImage">
                </div>

                <!-- Thumbnails - Keep green accent for active/hover -->
                <div class="flex gap-3 py-4 justify-start overflow-x-auto px-2 thumbnails">
                    <?php if (!empty($product['images'])): ?>
                        <?php foreach ($product['images'] as $index => $imageFilename): ?>
                            <?php $thumbnailUrl = getAfbeeldingUrl($imageFilename); ?>
                            <div class="ring-0 hover:ring-2 hover:ring-[#8fe507]/50 rounded-md overflow-hidden flex-shrink-0 transition-all duration-200 <?= $index === 0 ? 'ring-2 ring-[#8fe507]' : '' ?>" id="thumb-container-<?= $index ?>">
                                <img src="<?= htmlspecialchars($thumbnailUrl) ?>"
                                     alt="Thumbnail <?= $index + 1 ?> van <?= htmlspecialchars($product['naam']) ?>"
                                     class="size-16 sm:size-20 object-cover cursor-pointer transition duration-300 opacity-70 hover:opacity-100 <?= $index === 0 ? 'opacity-100' : '' ?>"
                                     onclick="changeImage('<?= htmlspecialchars($thumbnailUrl) ?>', <?= $index ?>)"
                                     id="thumb-<?= $index ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php $defaultImageUrl = getAfbeeldingUrl('default_image.jpg'); ?>
                        <div class="ring-2 ring-[#8fe507] rounded-md overflow-hidden flex-shrink-0">
                            <img src="<?= htmlspecialchars($defaultImageUrl) ?>"
                                 alt="Standaard thumbnail"
                                 class="size-16 sm:size-20 object-cover cursor-pointer opacity-100 transition duration-300">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Details -->
            <div class="w-full md:w-1/2 px-4">
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4 mb-4">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($product['naam']) ?></h2>
                            <div class="flex items-center flex-wrap gap-2 mt-2">
                                <!-- Use purple accent for category tag -->
                                <span class="bg-purple-100 text-purple-700 text-xs font-medium px-2.5 py-0.5 rounded-full inline-flex items-center">
                                    <i class="fas fa-tag mr-1"></i><?= htmlspecialchars($product['categorie_naam']) ?>
                                </span>
                                <!-- Keep green accent for stock status -->
                                <span class="bg-[#8fe507]/20 text-[#7bc906] text-xs font-medium px-2.5 py-0.5 rounded-full inline-flex items-center">
                                    <i class="fas fa-check-circle mr-1"></i>Op voorraad
                                </span>
                            </div>
                        </div>
                        <!-- Keep green accent for price -->
                        <span class="text-2xl font-bold bg-[#8fe507] text-white px-4 py-2 rounded-lg self-start sm:self-auto mt-2 sm:mt-0">
                            €<?= number_format($product['prijs'] ?? 0, 2, ',', '.') ?>
                        </span>
                    </div>

                    <!-- Order Section -->
                    <div class="bg-white p-0 rounded-lg mb-6"> <!-- Removed padding from here -->
                        <div class="flex items-center mb-4 border-b border-gray-200 pb-4">
                            <i class="fas fa-shopping-cart text-[#8fe507] mr-3 text-xl"></i> <!-- Keep green icon -->
                            <h3 class="text-xl font-semibold text-gray-900">Bestellen</h3>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="mb-6">
                            <label for="quantityValue" class="block text-sm font-medium text-gray-700 mb-2">Aantal:</label>
                            <div class="inline-flex items-center border border-gray-300 bg-white rounded-md shadow-sm">
                                <button type="button"
                                        class="px-3 py-2 text-gray-700 hover:bg-gray-100 focus:outline-none rounded-l-md transition-colors"
                                        onclick="decreaseQuantity()">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span id="quantityValue" class="text-gray-800 font-medium px-4 py-2 select-none border-l border-r border-gray-300">1</span>
                                <input type="hidden" name="quantity" id="quantity" value="1"> <!-- Hidden input holds the value -->
                                <button type="button"
                                        class="px-3 py-2 text-gray-700 hover:bg-gray-100 focus:outline-none rounded-r-md transition-colors"
                                        onclick="increaseQuantity()">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Product Options Section -->
                        <?php if (!empty($product_opties)): ?>
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <i class="fas fa-list-check text-[#8fe507] mr-2"></i> <!-- Keep green icon -->
                                    Product Opties
                                </label>
                                <div class="space-y-4">
                                    <?php foreach ($product_opties as $optie): ?>
                                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50"> <!-- Light gray background for option group -->
                                            <h4 class="text-md font-semibold text-gray-900 mb-3">
                                                <?= htmlspecialchars($optie['optie_naam']) ?>
                                            </h4>
                                            <div class="flex flex-wrap gap-3">
                                                <?php foreach ($optie['keuzes'] as $keuze): ?>
                                                    <!-- Keep green accent for checked state -->
                                                    <label class="flex items-center bg-white p-2.5 rounded-lg border border-gray-300 cursor-pointer hover:bg-gray-100 transition-colors has-[:checked]:border-[#8fe507] has-[:checked]:bg-[#8fe507]/10">
                                                        <input type="checkbox" name="opties[<?= $optie['id'] ?>][]" value="<?= htmlspecialchars($keuze['keuze_naam']) ?>" class=" mr-2 h-4 w-4 rounded border-gray-300 text-[#8fe507] focus:ring-[#8fe507] bg-gray-100 focus:ring-offset-white">
                                                        <span class="text-sm text-gray-700">
                                                        <?= htmlspecialchars($keuze['keuze_naam']) ?>
                                                    </span>
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Accordion Sections (MOVED HERE) -->
                        <div class="mb-6">
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <!-- Beschrijving Section -->
                                <div>
                                    <button id="beschrijving-button" class="accordion-button w-full bg-white px-6 py-4 text-left focus:outline-none hover:bg-gray-50 transition-colors" type="button">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <i class="fas fa-info-circle text-[#8fe507] mr-3 text-lg"></i> <!-- Keep green icon -->
                                                <h3 class="text-lg font-semibold text-gray-900">Beschrijving</h3>
                                            </div>
                                            <i class="fas fa-chevron-down text-gray-400 transition-transform accordion-icon"></i>
                                        </div>
                                    </button>
                                    <div id="beschrijving-content" class="accordion-content bg-gray-50 border-t border-gray-200">
                                        <div class="px-6 py-4">
                                            <div class="prose max-w-none leading-relaxed"> <!-- Basic prose styles applied via <style> -->
                                                <?= nl2br(htmlspecialchars($product['beschrijving'] ?? 'Geen beschrijving beschikbaar.')) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Producteisen Section -->
                                <?php if (!empty($product['requirements'])): ?>
                                    <div class="border-t border-gray-200">
                                        <button id="requirements-button" class="accordion-button w-full bg-white px-6 py-4 text-left focus:outline-none hover:bg-gray-50 transition-colors" type="button">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <i class="fas fa-clipboard-list text-[#8fe507] mr-3 text-lg"></i> <!-- Keep green icon -->
                                                    <h3 class="text-lg font-semibold text-gray-900">Producteisen</h3>
                                                </div>
                                                <i class="fas fa-chevron-down text-gray-400 transition-transform accordion-icon"></i>
                                            </div>
                                        </button>
                                        <div id="requirements-content" class="accordion-content bg-gray-50 border-t border-gray-200">
                                            <div class="px-6 py-4">
                                                <div class="prose max-w-none leading-relaxed">
                                                    <?= nl2br(htmlspecialchars($product['requirements'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Verplichte bestandstypen Section -->
                                <?php if (!empty($product['allowed_file_types'])): ?>
                                    <div class="border-t border-gray-200">
                                        <button id="filetypes-button" class="accordion-button w-full bg-white px-6 py-4 text-left focus:outline-none hover:bg-gray-50 transition-colors" type="button">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <i class="fas fa-file-alt text-[#8fe507] mr-3 text-lg"></i> <!-- Keep green icon -->
                                                    <h3 class="text-lg font-semibold text-gray-900">Vereiste bestandstypen</h3>
                                                </div>
                                                <i class="fas fa-chevron-down text-gray-400 transition-transform accordion-icon"></i>
                                            </div>
                                        </button>
                                        <div id="filetypes-content" class="accordion-content bg-gray-50 border-t border-gray-200">
                                            <div class="px-6 py-4">
                                                <div class="flex flex-wrap gap-2">
                                                    <?php
                                                    $fileTypes = explode(',', $product['allowed_file_types']);
                                                    foreach ($fileTypes as $fileType) {
                                                        $fileType = trim($fileType);
                                                        if (!empty($fileType)) {
                                                            $iconClass = 'fa-file'; // Default icon
                                                            $lowerType = strtolower($fileType);
                                                            if (in_array($lowerType, ['png', 'jpg', 'jpeg', 'gif', 'webp', 'svg'])) $iconClass = 'fa-file-image';
                                                            else if ($lowerType == 'ai') $iconClass = 'fa-solid fa-pen-ruler'; // Specific AI icon
                                                            else if ($lowerType == 'pdf') $iconClass = 'fa-file-pdf';
                                                            else if (in_array($lowerType, ['zip', 'rar'])) $iconClass = 'fa-file-zipper';
                                                            else if (in_array($lowerType, ['doc', 'docx'])) $iconClass = 'fa-file-word';
                                                            else if (in_array($lowerType, ['xls', 'xlsx'])) $iconClass = 'fa-file-excel';

                                                            // Use purple accent for file type badges, but keep icon green
                                                            echo '<span class="bg-purple-100 text-purple-700 text-xs font-medium px-2.5 py-1.5 rounded inline-flex items-center gap-1.5">';
                                                            echo '<i class="fas ' . $iconClass . ' text-[#8fe507]"></i>'; // Keep icon green
                                                            echo htmlspecialchars(strtoupper($fileType)) . '</span>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- File Upload with Preview -->
                        <div class="mb-6">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-cloud-upload-alt text-[#8fe507] mr-2"></i> <!-- Keep green icon -->
                                Bestand uploaden
                                <?php if ($product['is_file_required'] ?? false): ?>
                                    <span class="text-red-500 ml-1">*</span>
                                <?php endif; ?>
                                <span class="text-xs text-gray-500 ml-2">(Zie vereiste types hieronder)</span>
                            </label>

                            <!-- Upload Area - Keep green hover border -->
                            <label id="fileUploadArea" for="bestand" require class="flex flex-col justify-center items-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50 hover:border-[#8fe507]">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                                    <i class="fas fa-file-upload text-gray-400 text-3xl mb-3"></i>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Klik om te uploaden</span> of sleep hier
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <?php
                                        $allowedTypes = !empty($product['allowed_file_types']) ? str_replace(',', ', ', strtoupper($product['allowed_file_types'])) : 'PNG, JPG, GIF, AI, PDF';
                                        echo htmlspecialchars($allowedTypes) . " (Max: 500MB)";
                                        ?>
                                    </p>
                                </div>
                                <input id="bestand" name="bestand" type="file" class="hidden " required
                                       accept="<?= !empty($product['allowed_file_types']) ? '.' . str_replace(',', ',.', $product['allowed_file_types']) : '.png,.jpg,.jpeg,.gif,.ai,.pdf' ?>"
                                       onchange="handleFileSelect(event)"
                                    <?= ($product['is_file_required'] ?? false) ? 'required' : '' ?>>
                            </label>

                            <!-- File Preview Area -->
                            <div id="filePreviewArea" class="hidden mt-3 p-3 bg-gray-100 rounded-lg border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3 overflow-hidden mr-2">
                                        <i class="fas fa-file-alt text-[#8fe507] text-lg flex-shrink-0"></i> <!-- Keep green icon -->
                                        <div class="flex flex-col overflow-hidden">
                                            <span id="fileName" class="text-sm font-medium text-gray-800 truncate"></span>
                                            <span id="fileSize" class="text-xs text-gray-500"></span>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800 flex-shrink-0 p-1 rounded-full hover:bg-red-100 transition-colors">
                                        <i class="fas fa-times text-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Validation message area -->
                            <p id="fileError" class="text-red-500 text-sm mt-1 hidden"></p>
                        </div>


                        <!-- Order Button - Keep green -->
                        <div class="flex space-x-4 mt-6 pt-6 border-t border-gray-200">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

                            <button type="button" onclick="addToCart()" id="addToCartButton"
                                    class="transition-all duration-300 bg-[#8fe507] hover:bg-[#7bc906] focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg px-5 py-3 text-center text-white flex-1 flex justify-center items-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Toevoegen aan winkelwagen</span>
                            </button>
                        </div>
                    </div> <!-- End Order Section -->
                </div><!-- End Main Product Details Box -->

            </div> <!-- End Product Details Column -->
        </div><!-- End Flex Wrap -->

        <!-- Techniek Video's Section -->
        <?php if (!empty($techniek_videos)): ?>
            <div class="container mx-auto px-4 py-6 mt-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-6 border-b border-gray-200 pb-4">
                        <!-- Keep green accent -->
                        <div class="bg-[#8fe507]/20 p-2 rounded-full mr-3 inline-flex items-center justify-center size-10">
                            <i class="fas fa-play-circle text-[#8fe507] text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Uitlegvideo's</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($techniek_videos as $video): ?>
                            <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm border border-gray-200">
                                <?php if (!empty($video['link']) && filter_var($video['link'], FILTER_VALIDATE_URL)): ?>
                                    <div class="relative pb-[56.25%] h-0 bg-black"> <!-- Aspect ratio container -->
                                        <iframe class="absolute top-0 left-0 w-full h-full"
                                                src="<?= htmlspecialchars($video['link']) ?>"
                                                title="<?= htmlspecialchars($video['name'] ?? 'Techniek Video') ?>"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                referrerpolicy="strict-origin-when-cross-origin"
                                                allowfullscreen></iframe>
                                    </div>
                                <?php else: ?>
                                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-video-slash text-gray-400 text-3xl"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="p-4">
                                    <h3 class="font-medium text-gray-900 mb-1 inline-flex items-center gap-2">
                                        <i class="fas fa-film text-[#8fe507]"></i> <!-- Keep green icon -->
                                        <?= htmlspecialchars($video['name'] ?? 'Video') ?>
                                    </h3>
                                    <!-- Optional: Add video description if available -->
                                    <!-- <p class="text-sm text-gray-600"><?= htmlspecialchars($video['description'] ?? '') ?></p> -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div> <!-- End Main Container -->

    <!-- Add to cart notification modal - Use purple accent -->
    <div id="cartNotificationModal" class="fixed bottom-4 right-4 z-[100] transition-all duration-300 ease-out transform translate-y-full opacity-0">
        <!-- Purple background, white text, white icon -->
        <div class="bg-purple-600 border border-purple-700 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3" role="alert">
            <i class="fas fa-check-circle text-white text-xl"></i> <!-- White icon for contrast -->
            <div>
                <strong class="font-bold block">Gelukt!</strong>
                <span class="block sm:inline">Product is toegevoegd aan de winkelwagen.</span>
            </div>
        </div>
    </div>

</div> <!-- End Outer Container -->

<!-- Ensure JS is loaded *after* the HTML elements -->
<script src="../js/product_detail.view.js" defer></script>

</body>
</html>