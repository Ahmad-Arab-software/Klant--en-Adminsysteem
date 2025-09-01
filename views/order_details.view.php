<?php include __DIR__ . '/header.view.php'; ?>
<div class="flex flex-col md:flex-row">
    <?php include __DIR__ . '/sidebar.view.php'; ?>

    <div class="flex-1 p-4 sm:p-6 bg-gray-100 min-h-screen">
        <div class="mb-6">
            <a href="index.php?page=dashboard" class="text-green-700 hover:text-green-900 font-semibold inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Terug naar Dashboard
            </a>
        </div>

        <?php if (!empty($errorMessage)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Fout</p>
                <p><?php echo htmlspecialchars($errorMessage); ?></p>
            </div>
        <?php elseif ($order_details): ?>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header van de order -->
                <div class="bg-purple-700 p-6 text-white">
                    <h1 class="text-3xl font-bold">Details van Order #<?php echo htmlspecialchars($order_details['id']); ?></h1>
                    <div class="flex flex-wrap gap-x-6 gap-y-2 mt-2 text-purple-200">
                        <span class="flex items-center"><i class="fas fa-user mr-2"></i> <?php echo htmlspecialchars($order_details['klant_email']); ?></span>
                        <span class="flex items-center"><i class="fas fa-calendar-alt mr-2"></i> <?php echo (new DateTime($order_details['besteld_op']))->format('d-m-Y H:i'); ?></span>
                    </div>
                </div>

                <div class="p-6 space-y-8">

                    <!-- Producten in de order -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">Producten</h2>
                        <div class="space-y-4">
                            <?php foreach ($order_items as $item): ?>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <p class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($item['product_naam']); ?></p>
                                    <p class="text-sm text-gray-600 mb-3">Aantal: <?php echo htmlspecialchars($item['aantal']); ?></p>

                                    <!-- Gekozen Opties -->
                                    <?php
                                    $gekozen_opties_array = json_decode($item['gekozen_opties'], true);
                                    if (!empty($gekozen_opties_array) && is_array($gekozen_opties_array)):
                                        ?>
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <h4 class="text-md font-semibold text-gray-700 mb-2">Specificaties:</h4>
                                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                                <?php foreach ($gekozen_opties_array as $optie_id => $waarde): ?>
                                                    <div class="flex flex-col">
                                                        <dt class="font-medium text-gray-500">
                                                            <?php echo isset($option_names_map[$optie_id]) ? htmlspecialchars($option_names_map[$optie_id]) : htmlspecialchars(ucfirst(str_replace('_', ' ', $optie_id))); ?>
                                                        </dt>
                                                        <dd class="text-gray-900">
                                                            <?php
                                                            if (is_array($waarde)) {
                                                                $keuze_namen = array_map(fn($id) => $choice_names_map[$id] ?? $id, $waarde);
                                                                echo htmlspecialchars(implode(', ', $keuze_namen));
                                                            } else {
                                                                echo htmlspecialchars($choice_names_map[$waarde] ?? $waarde);
                                                            }
                                                            ?>
                                                        </dd>
                                                    </div>
                                                <?php endforeach; ?>
                                            </dl>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Bestand -->
                                    <?php if (!empty($item['bestandspad'])): ?>
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <h4 class="text-md font-semibold text-gray-700 mb-2">Bestand:</h4>
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm text-gray-800 truncate"><?= htmlspecialchars($item['bestand_originele_naam'] ?? 'Bestand') ?></span>
                                                <a href="download.php?regel_id=<?= htmlspecialchars($item['id']) ?>" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 shrink-0">
                                                    <i class="fas fa-download mr-2"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>