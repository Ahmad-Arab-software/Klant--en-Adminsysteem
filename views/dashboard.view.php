<?php include __DIR__ . '/header.view.php'; ?>
<div class="flex flex-col md:flex-row">
    <?php include __DIR__ . '/sidebar.view.php'; ?>

    <div class="flex-1 p-4 sm:p-6 bg-gray-100 min-h-screen">
        <h1 class="text-2xl sm:text-3xl font-bold text-green-700 mb-4 sm:mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 sm:h-6 w-5 sm:w-5 mr-2 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Dashboard
        </h1>

        <!-- Filter en Zoekbalk -->
        <div class="bg-white p-4 shadow-lg rounded-lg mb-6">
            <h2 class="text-lg sm:text-xl font-semibold text-purple-700 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 sm:h-5 w-4 sm:w-5 mr-2 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h16a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM16 9l2 2-2 2M12 9l2 2-2 2M8 9l2 2-2 2" /></svg>
                Filter en Zoeken
            </h2>
            <form action="index.php" method="GET" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <input type="hidden" name="page" value="dashboard">
                <div class="flex-1 w-full sm:w-auto">
                    <label for="status_filter" class="block text-gray-700 font-medium text-sm sm:text-base">Filter op Status:</label>
                    <select id="status_filter" name="status_filter" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500">
                        <option value="">Alle Actieve</option>
                        <option value="nieuw" <?php echo ($_GET['status_filter'] ?? '') === 'nieuw' ? 'selected' : ''; ?>>Nieuw</option>
                        <option value="in_behandeling" <?php echo ($_GET['status_filter'] ?? '') === 'in_behandeling' ? 'selected' : ''; ?>>In Behandeling</option>
                        <option value="klaar" <?php echo ($_GET['status_filter'] ?? '') === 'klaar' ? 'selected' : ''; ?>>Klaar</option>
                        <option value="opgehaald" <?php echo ($_GET['status_filter'] ?? '') === 'opgehaald' ? 'selected' : ''; ?>>Opgehaald</option>
                    </select>
                </div>
                <div class="flex-1 w-full sm:w-auto">
                    <label for="category_filter" class="block text-gray-700 font-medium text-sm sm:text-base">Filter op Categorie:</label>
                    <select id="category_filter" name="category_filter" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500">
                        <option value="">Alle Categorieën</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo ($_GET['category_filter'] ?? '') == $category['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['naam']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex-1 w-full sm:w-auto">
                    <label for="search" class="block text-gray-700 font-medium text-sm sm:text-base">Zoek:</label>
                    <input type="text" id="search" name="search" placeholder="Zoeken..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" class="border rounded w-full p-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex items-end w-full sm:w-auto">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center justify-center w-full sm:w-auto focus:outline-none focus:ring-2 focus:ring-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 sm:h-5 w-4 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Toepassen
                    </button>
                </div>
            </form>
        </div>

        <!-- Meldingen -->
        <?php if (!empty($errorMessage)): ?>
            <p class="text-red-600 bg-red-100 p-3 rounded-lg mb-4"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="text-green-600 bg-green-100 p-3 rounded-lg mb-4"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <p class="text-red-600 bg-red-100 p-3 rounded-lg mb-4"><?= htmlspecialchars($_SESSION['error_message']) ?></p>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Orders Cards -->
        <?php if (empty($bestellingen)): ?>
            <p class="text-gray-700">Er zijn momenteel geen orders om weer te geven met de geselecteerde filters.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($bestellingen as $bestelling): ?>
                    <div class="w-full bg-white p-4 rounded-lg shadow-lg border border-gray-200 flex flex-col justify-between">
                        <div>
                            <!-- Overzicht Informatie -->
                            <div class="mb-2">
                                <dt class="text-sm font-medium text-gray-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.628m7.32-7.32a2.25 2.25 0 013.182 3.182C21 9.525 22.5 13.5 22.5 18a2.25 2.25 0 01-2.25 2.25H15m.021-2.273 2.536-2.536M3 18V2.25a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 2.25v18m-18 0v-2.25a2.25 2.25 0 012.25-2.25h.937m7.637 2.289-2.549-2.549m-1.026-2.472a2.25 2.25 0 012.91-3.093c.867 1.1.928 2.34.377 3.644Z" /></svg>Order ID:</dt>
                                <dd class="mt-1 text-base font-semibold text-gray-900 break-words"><?php echo htmlspecialchars($bestelling['id']); ?></dd>
                            </div>
                            <div class="mb-2">
                                <dt class="text-sm font-medium text-gray-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.589-7.499-1.632z" /></svg>Klant E-mail:</dt>
                                <dd class="mt-1 text-base font-semibold text-gray-900 break-words"><?php echo htmlspecialchars($bestelling['klant_email']); ?></dd>
                            </div>
                            <div class="mb-2">
                                <dt class="text-sm font-medium text-gray-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V8.25a1.5 1.5 0 011.5-1.5h13.5a1.5 1.5 0 011.5 1.5v10.5a1.5 1.5 0 01-1.5 1.5H4.5a1.5 1.5 0 01-1.5-1.5z" /></svg>Besteld Op:</dt>
                                <dd class="mt-1 text-base font-semibold text-gray-900 break-words"><?php echo date('d-m-Y H:i', strtotime($bestelling['besteld_op'])); ?></dd>
                            </div>
                            <div class="mb-2">
                                <dt class="text-sm font-medium text-gray-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.307 4.308a3 3 0 004.212-4.212l-4.5-4.5" /></svg>Producten:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-700 break-words"><?php echo htmlspecialchars($bestelling['product_namen'] ?? 'Geen producten gevonden'); ?> (<?php echo $bestelling['aantal_items']; ?> items)</dd>
                            </div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.628m7.32-7.32a2.25 2.25 0 013.182 3.182C21 9.525 22.5 13.5 22.5 18a2.25 2.25 0 01-2.25 2.25H15m.021-2.273 2.536-2.536M3 18V2.25a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 2.25v18m-18 0v-2.25a2.25 2.25 0 012.25-2.25h.937m7.637 2.289-2.549-2.549m-1.026-2.472a2.25 2.25 0 012.91-3.093c.867 1.1.928 2.34.377 3.644Z" /></svg>Categorieën:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-700 break-words"><?php echo htmlspecialchars($bestelling['categorie_namen'] ?? 'Geen categorie'); ?></dd>
                            </div>
                            <!-- Status Voortgang -->
                            <div class="mb-4 w-full">
                                <dt class="text-sm font-medium text-gray-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Status Voortgang:</dt>
                                <dd class="mt-2 w-full">
                                    <div class="flex items-center relative w-full justify-between px-1">
                                        <div class="flex flex-col items-center z-10 text-center px-1"><div class="w-11 h-11 <?php echo $bestelling['status'] == 'nieuw' ? 'bg-green-500' : 'bg-gray-300' ?> text-white flex items-center justify-center rounded-full"><img src="https://icon-library.com/images/order-icon/order-icon-28.jpg" alt="Nieuw" class="w-5 h-5"/></div><p class="text-gray-600 mt-2 text-xs md:text-sm">Nieuw</p></div>
                                        <div class="absolute top-[18px] left-[10%] w-[20%] h-0.5 <?php echo in_array($bestelling['status'], ['in_behandeling', 'klaar', 'opgehaald']) ? 'bg-green-500' : 'bg-gray-300' ?>"></div>
                                        <div class="flex flex-col items-center z-10 text-center px-1"><div class="w-11 h-11 <?php echo in_array($bestelling['status'], ['in_behandeling']) ? 'bg-yellow-400' : 'bg-gray-300' ?> text-white flex items-center justify-center rounded-full"><img src="https://static.thenounproject.com/png/2931154-200.png" alt="In Behandeling" class="w-5 h-5"/></div><p class="text-gray-600 mt-2 text-xs md:text-sm leading-tight">Behandeling</p></div>
                                        <div class="absolute top-[18px] left-[40%] w-[20%] h-0.5 <?php echo in_array($bestelling['status'], ['klaar', 'opgehaald']) ? 'bg-green-500' : 'bg-gray-300' ?>"></div>
                                        <div class="flex flex-col items-center z-10 text-center px-1"><div class="w-11 h-11 <?php echo $bestelling['status'] == 'klaar' ? 'bg-green-400' : 'bg-gray-300' ?> flex items-center justify-center rounded-full"><img src="https://static.thenounproject.com/png/4927873-200.png" alt="Klaar" class="w-5 h-5"/></div><p class="text-gray-600 mt-2 text-xs md:text-sm">Klaar</p></div>
                                        <div class="absolute top-[18px] left-[70%] w-[20%] h-0.5 <?php echo $bestelling['status'] == 'opgehaald' ? 'bg-green-600' : 'bg-gray-300' ?>"></div>
                                        <div class="flex flex-col items-center z-10 text-center px-1"><div class="w-11 h-11 <?php echo $bestelling['status'] == 'opgehaald' ? 'bg-green-600' : 'bg-gray-300' ?> text-white flex items-center justify-center rounded-full"><img src="https://static.thenounproject.com/png/4160044-200.png" alt="Opgehaald" class="w-5 h-5"/></div><p class="text-gray-600 mt-2 text-xs md:text-sm">Opgehaald</p></div>
                                    </div>
                                </dd>
                            </div>
                        </div>

                        <!-- Knoppen sectie -->
                        <div class="w-full flex flex-col gap-2 mt-auto pt-4 border-t border-gray-200">
                            <div class="w-full grid grid-cols-3 gap-2">
                                <button type="button" class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 text-sm w-full delete-order-button" data-order-id="<?= htmlspecialchars($bestelling['id']) ?>" data-csrf-token="<?= htmlspecialchars($csrfToken) ?>">
                                    Verwijderen
                                </button>
                                <button type="button" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 text-sm w-full print-order-button"
                                        data-order-id="<?= htmlspecialchars($bestelling['id']) ?>"
                                        data-klant-email="<?= htmlspecialchars($bestelling['klant_email']) ?>"
                                        data-besteld-op="<?= htmlspecialchars(date('d-m-Y H:i', strtotime($bestelling['besteld_op']))) ?>"
                                        data-print-details-json="<?= htmlspecialchars($bestelling['print_details_json'] ?? '[]') ?>">
                                    Print
                                </button>
                                <a href="index.php?page=order_details&id=<?php echo $bestelling['id']; ?>" class="inline-flex justify-center items-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-purple-700 w-full">
                                    Details
                                </a>
                            </div>
                            <form action="index.php?page=dashboard&<?= http_build_query($_GET) ?>" method="POST" class="flex flex-col sm:flex-row gap-2 w-full">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($bestelling['id']); ?>">
                                <select name="status" class="border rounded p-2 text-sm w-full text-center">
                                    <option value="nieuw" <?php if ($bestelling['status'] == 'nieuw') echo 'selected'; ?>>Nieuw</option>
                                    <option value="in_behandeling" <?php if ($bestelling['status'] == 'in_behandeling') echo 'selected'; ?>>In Behandeling</option>
                                    <option value="klaar" <?php if ($bestelling['status'] == 'klaar') echo 'selected'; ?>>Klaar</option>
                                    <option value="opgehaald" <?php if ($bestelling['status'] == 'opgehaald') echo 'selected'; ?>>Opgehaald</option>
                                </select>
                                <button type="submit" name="update_status" class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm w-full sm:w-auto">Update</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL VOOR VERWIJDERBEVESTIGING -->
<div id="delete-confirm-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-11/12 max-w-sm mx-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Verwijderen</h3>
        <p class="text-sm text-gray-600 mb-6">Weet u zeker dat u order #<span id="modal-order-id" class="font-bold"></span> wilt verwijderen? Deze actie kan niet ongedaan gemaakt worden.</p>
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-2">
            <button type="button" id="cancel-delete-button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 w-full sm:w-auto">Annuleren</button>
            <form id="confirm-delete-form" action="index.php?page=dashboard&<?= http_build_query($_GET) ?>" method="POST" class="inline-block w-full sm:w-auto">
                <input type="hidden" name="order_id" id="modal-form-order-id" value="">
                <input type="hidden" name="delete_order" value="1">
                <input type="hidden" name="csrf_token" id="modal-form-csrf-token" value="">
                <button type="submit" id="confirm-delete-button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 w-full sm:w-auto">Verwijderen</button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="./js/dashboard.js"></script>
</body>
</html>