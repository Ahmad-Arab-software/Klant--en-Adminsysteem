<?php
// Laad de header en sidebar
include __DIR__ . '/header.view.php';
include __DIR__ . '/sidebar.view.php';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machines Beheren</title>
    <style>
        /* Jouw bestaande, mooie CSS hier... (onveranderd) */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); color: #334155; line-height: 1.6; }
        .main-container { padding: 2rem; margin-left: 250px; max-width: 1400px; transition: margin-left 0.3s ease; }
        @media (max-width: 768px) { .main-container { margin-left: 0; padding: 1rem; } }
        h2 { font-size: 2.5rem; font-weight: 700; color: #1e293b; margin-bottom: 2rem; position: relative; }
        h2::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 60px; height: 4px; background: linear-gradient(90deg, #6366f1, #8b5cf6); border-radius: 2px; }
        h3 { font-size: 1.5rem; font-weight: 600; color: #475569; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
        h3::before { content: ''; width: 8px; height: 8px; background: #6366f1; border-radius: 50%; }
        .card { background: white; border-radius: 16px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid rgba(99, 102, 241, 0.1); transition: all 0.3s ease; }
        .card:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); transform: translateY(-2px); }
        .edit-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid rgba(99, 102, 241, 0.1); }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; }
        input[type="text"], textarea, input[type="file"] { width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s ease; background: #f9fafb; }
        input[type="file"] { padding: 0.5rem; }
        input[type="text"]:focus, textarea:focus, input[type="file"]:focus { outline: none; border-color: #6366f1; background: white; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1); }
        textarea { height: 120px; resize: vertical; }
        .checkbox-group { display: flex; align-items: center; gap: 0.5rem; }
        .checkbox-group input { width: 1rem; height: 1rem; accent-color: #6366f1; }
        .btn { padding: 0.75rem 1.5rem; border: none; cursor: pointer; border-radius: 12px; font-weight: 600; font-size: 0.875rem; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.05em; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-add { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.4); }
        .btn-add:hover { transform: translateY(-2px); box-shadow: 0 6px 20px 0 rgba(99, 102, 241, 0.5); }
        .btn-save { background: linear-gradient(135deg, #10b981, #059669); color: white; box-shadow: 0 2px 8px 0 rgba(16, 185, 129, 0.3); }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 4px 12px 0 rgba(16, 185, 129, 0.4); }
        .btn-delete { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; box-shadow: 0 2px 8px 0 rgba(239, 68, 68, 0.3); }
        .btn-delete:hover { transform: translateY(-1px); box-shadow: 0 4px 12px 0 rgba(239, 68, 68, 0.4); }
        .items-list { display: flex; flex-direction: column; gap: 2rem; }
        .item-content { display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; padding: 2rem; }
        .item-image { width: 100%; height: auto; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .item-actions { display: flex; gap: 1rem; padding: 1.5rem 2rem; background: #f9fafb; border-top: 1px solid #e5e7eb; justify-content: flex-end; }
        @media (max-width: 768px) { .item-content { grid-template-columns: 1fr; } .item-actions { flex-direction: column; } .btn { width: 100%; justify-content: center; } }
        .message-box { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; font-weight: 500; }
        .message-success { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534; border: 1px solid #86efac; }
        .message-error { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border: 1px solid #fca5a5; }
        .empty-state { text-align: center; padding: 3rem 2rem; color: #64748b; background: white; border-radius: 16px; }
        .empty-state-icon { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
    </style>
</head>
<body>

<div class="main-container">
    <h2>Machines Beheren</h2>

    <!-- Meldingen Box -->
    <?php if (!empty($view_data['message'])): ?>
        <div class="message-box <?php echo ($view_data['message_type'] === 'success') ? 'message-success' : 'message-error'; ?>">
            <?php echo htmlspecialchars($view_data['message']); ?>
        </div>
    <?php endif; ?>

    <!-- SECTIE 1: NIEUWE MACHINE TOEVOEGEN (Onveranderd) -->
    <div class="card">
        <h3>Nieuwe Machine Toevoegen</h3>
        <!-- Jouw bestaande formulier voor toevoegen... -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl overflow-hidden">
            <div class="p-8">
                <form action="/test_ph/index.php?page=add_item" method="POST" enctype="multipart/form-data" class="space-y-8">
                    <!-- Titel, Beschrijving, Afbeelding velden... (jouw code) -->
                    <div class="space-y-2">
                        <label for="title" class="flex items-center text-sm font-semibold text-gray-700"><svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/></svg>Titel</label>
                        <div class="relative">
                            <input type="text" id="title" name="title" required placeholder="Voer de titel in..." class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 text-gray-900 placeholder-gray-400 hover:border-purple-300 resize-none"/>
                            <svg class="absolute left-4 top-4 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="description" class="flex items-center text-sm font-semibold text-gray-700"><svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Beschrijving</label>
                        <div class="relative"><textarea id="description" name="description" rows="5" required placeholder="Voer een gedetailleerde beschrijving in..." class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 text-gray-900 placeholder-gray-400 hover:border-purple-300 resize-none"></textarea><svg class="absolute left-4 top-4 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                    </div>
                    <div class="space-y-2">
                        <label for="image" class="flex items-center text-sm font-semibold text-gray-700"><svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Afbeelding</label>
                        <div class="relative"><input type="file" id="image" name="image" accept="image/*" required class="hidden"><div id="uploadArea" class="border-2 border-dashed border-purple-300 rounded-xl p-8 text-center cursor-pointer hover:border-purple-400 hover:bg-purple-50 transition-all duration-200"><div class="flex flex-col items-center space-y-4"><div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center"><svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg></div><div><p class="text-lg font-semibold text-gray-700">Klik om een afbeelding te uploaden</p><p class="text-sm text-gray-500 mt-1">of sleep een bestand hierheen</p></div><div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg font-medium text-sm"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>Bestand Selecteren</div></div></div></div>
                        <p class="text-xs text-gray-500 flex items-center mt-2"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Ondersteunde formaten: JPG, JPEG, PNG, GIF (Max 5MB)</p>
                        <div id="fileDisplay" class="mt-4 hidden"><div class="bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-4"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center"><svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div><div><p id="fileName" class="font-medium text-gray-900"></p><p class="text-sm text-gray-500">Klaar om te uploaden</p></div></div><button type="button" id="removeFileBtn" class="p-2 text-red-500 hover:bg-red-100 rounded-lg transition-colors duration-200"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></div></div></div>
                    </div>
                    <div class="pt-6 border-t border-gray-100">
                        <button type="submit" name="add_item" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl hover:from-purple-700 hover:to-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-purple-300"><span class="flex items-center justify-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>Item Toevoegen</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SECTIE 2: BESTAANDE MACHINES BEHEREN (AANGEPAST) -->
    <div class="mt-16">
        <h3>Bestaande Machines</h3>
        <?php if (empty($items)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🖨️</div>
                <h4>Geen machines gevonden</h4>
                <p>Voeg je eerste machine toe om deze hier te beheren.</p>
            </div>
        <?php else: ?>
            <div class="items-list">
                <?php foreach ($items as $item): ?>
                    <div class="edit-card">
                        <!-- BELANGRIJK: enctype toevoegen voor file uploads -->
                        <form action="/test_ph/index.php?page=add_item" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <!-- NIEUW: Stuur de naam van de huidige afbeelding mee -->
                            <input type="hidden" name="current_image_path" value="<?php echo htmlspecialchars($item['image_path']); ?>">

                            <div class="item-content">
                                <img src="/test_ph/uploads/<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="item-image">

                                <div class="space-y-4">
                                    <div class="form-group">
                                        <label for="title_<?php echo $item['id']; ?>">Titel</label>
                                        <input type="text" id="title_<?php echo $item['id']; ?>" name="title" value="<?php echo htmlspecialchars($item['title']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description_<?php echo $item['id']; ?>">Beschrijving</label>
                                        <textarea id="description_<?php echo $item['id']; ?>" name="description" required><?php echo htmlspecialchars($item['description']); ?></textarea>
                                    </div>

                                    <!-- NIEUW: Veld om afbeelding te wijzigen -->
                                    <div class="form-group">
                                        <label for="new_image_<?php echo $item['id']; ?>">Afbeelding Wijzigen (Optioneel)</label>
                                        <input type="file" id="new_image_<?php echo $item['id']; ?>" name="new_image" accept="image/*">
                                    </div>

                                    <div class="checkbox-group">
                                        <input type="checkbox" id="is_available_<?php echo $item['id']; ?>" name="is_available" value="1" <?php echo $item['is_available'] ? 'checked' : ''; ?>>
                                        <label for="is_available_<?php echo $item['id']; ?>" style="margin-bottom: 0; text-transform: none; font-size: 1rem;">Beschikbaar</label>
                                    </div>
                                </div>
                            </div>

                            <div class="item-actions">
                                <button type="submit" name="delete_item" class="btn btn-delete" onclick="return confirm('Weet je ZEKER dat je dit item en de bijbehorende afbeelding permanent wilt verwijderen?');">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Verwijderen
                                </button>
                                <button type="submit" name="update_item" class="btn btn-save">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Wijzigingen Opslaan
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Jouw bestaande Javascript voor de file upload... (onveranderd)
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const uploadArea = document.getElementById('uploadArea');
        const fileDisplay = document.getElementById('fileDisplay');
        const fileNameSpan = document.getElementById('fileName');
        const removeFileBtn = document.getElementById('removeFileBtn');
        if(uploadArea) {
            uploadArea.addEventListener('click', function() { imageInput.click(); });
            uploadArea.addEventListener('dragover', function(e) { e.preventDefault(); uploadArea.classList.add('border-purple-500', 'bg-purple-100'); });
            uploadArea.addEventListener('dragleave', function(e) { e.preventDefault(); uploadArea.classList.remove('border-purple-500', 'bg-purple-100'); });
            uploadArea.addEventListener('drop', function(e) { e.preventDefault(); uploadArea.classList.remove('border-purple-500', 'bg-purple-100'); const files = e.dataTransfer.files; if (files.length > 0) { imageInput.files = files; showSelectedFile(files[0]); } });
            imageInput.addEventListener('change', function() { if (this.files.length > 0) { showSelectedFile(this.files[0]); } else { hideSelectedFile(); } });
            removeFileBtn.addEventListener('click', function() { imageInput.value = ''; hideSelectedFile(); });
        }
        function showSelectedFile(file) { fileNameSpan.textContent = file.name; fileDisplay.classList.remove('hidden'); uploadArea.style.display = 'none'; }
        function hideSelectedFile() { fileNameSpan.textContent = ''; fileDisplay.classList.add('hidden'); uploadArea.style.display = 'block'; }
    });
</script>

</body>
</html>