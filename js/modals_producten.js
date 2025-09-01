// js/modals_producten.js
function openEditModal(product, categorieen, videoOptions) {
    const editProductId = document.getElementById('edit_product_id');
    if (editProductId) {
        editProductId.value = product.id || '';
    }

    const editNaam = document.getElementById('edit_naam');
    if (editNaam) {
        editNaam.value = product.naam || '';
    }

    const editBeschrijving = document.getElementById('edit_beschrijving');
    if (editBeschrijving) {
        editBeschrijving.value = product.beschrijving || '';
    }

    const editPrijs = document.getElementById('edit_prijs');
    if (editPrijs) {
        editPrijs.value = product.prijs || '';
    }

    const editRequirements = document.getElementById('edit_requirements');
    if (editRequirements) {
        editRequirements.value = product.requirements || '';
    }

    // Categorie selectie vullen
    const categorieSelect = document.getElementById('edit_categorie_id');
    if (categorieSelect) {
        categorieSelect.innerHTML = '';
        categorieen.forEach(categorie => {
            const option = document.createElement('option');
            option.value = categorie.id;
            option.textContent = categorie.naam;
            if (categorie.id === product.categorie_id) {
                option.selected = true;
            }
            categorieSelect.appendChild(option);
        });
    }

    // Video checkboxes vullen
    const videoCheckboxesContainer = document.getElementById('edit_video-checkboxes');
    if (videoCheckboxesContainer) {
        videoCheckboxesContainer.innerHTML = ''; // Clear existing checkboxes
        videoOptions.forEach(video => {
            const checkboxDiv = document.createElement('div');
            checkboxDiv.className = 'flex items-center';
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.id = `edit_video_${video.id}`;
            checkbox.name = 'product_videos[]';
            checkbox.value = video.id;
            checkbox.className = 'h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded';
            if (product.videos && product.videos.includes(String(video.id))) {
                checkbox.checked = true;
            }
            const label = document.createElement('label');
            label.htmlFor = `edit_video_${video.id}`;
            label.className = 'ml-2 block text-sm text-gray-900';
            label.textContent = video.name;
            checkboxDiv.appendChild(checkbox);
            checkboxDiv.appendChild(label);
            videoCheckboxesContainer.appendChild(checkboxDiv);
        });
    }

    // Preview container legen voor edit modal
    const editPreviewContainer = document.getElementById('edit_preview-container');
    if (editPreviewContainer) {
        editPreviewContainer.innerHTML = '';
    }

    // Populate allowed file types
    if (product.allowed_file_types) {
        const fileTypes = product.allowed_file_types.split(',');
        const fileTypeCheckboxes = document.querySelectorAll('#edit_file_types_checkboxes input[type="checkbox"]');
        fileTypeCheckboxes.forEach(checkbox => {
            checkbox.checked = fileTypes.includes(checkbox.value);
        });
    }

    // Product opties vullen
    const editProductOptiesContainer = document.getElementById('edit_product-opties');
    if (editProductOptiesContainer) {
        editProductOptiesContainer.innerHTML = '';
        let editOptieIndexForModal = 0;

        if (product.opties && product.opties.length > 0) {
            product.opties.forEach((optie, index) => {
                const optieGroup = document.createElement('div');
                optieGroup.className = 'optie-group border p-4 rounded-lg';
                optieGroup.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium">Optie ${editOptieIndexForModal + 1}</span>
                        <button type="button" class="remove-optie text-red-500 hover:text-red-700">×</button>
                    </div>
                    <input type="text" name="optie_naam[]" class="border rounded w-full p-2 mb-2" placeholder="Optienaam (bijv. Papierkeuze)" value="${optie.optie_naam || ''}" required>
                    <div class="keuzes-container space-y-2">
                    </div>
                    <button type="button" class="add-keuze mt-2 text-blue-500 hover:text-blue-700">+ Keuze toevoegen</button>
                `;
                const keuzesContainer = optieGroup.querySelector('.keuzes-container');
                if (keuzesContainer) {
                    if (optie.keuzes && optie.keuzes.length > 0) {
                        optie.keuzes.forEach(keuze => {
                            const keuzeDiv = document.createElement('div');
                            keuzeDiv.className = 'keuze flex gap-2';
                            keuzeDiv.innerHTML = `
                                <input type="text" name="keuze[${editOptieIndexForModal}][]" class="border rounded flex-1 p-2" placeholder="Keuze (bijv. Mat papier)" value="${keuze || ''}" required>
                                <button type="button" class="remove-keuze text-red-500 hover:text-red-700">×</button>
                            `;
                            keuzeDiv.querySelector('.remove-keuze').addEventListener('click', () => keuzeDiv.remove());
                            keuzesContainer.appendChild(keuzeDiv);
                        });
                    } else {
                        const keuzeDiv = document.createElement('div');
                        keuzeDiv.className = 'keuze flex gap-2';
                        keuzeDiv.innerHTML = `
                            <input type="text" name="keuze[${editOptieIndexForModal}][]" class="border rounded flex-1 p-2" placeholder="Keuze (bijv. Mat papier)" required>
                            <button type="button" class="remove-keuze text-red-500 hover:text-red-700">×</button>
                        `;
                        keuzesContainer.appendChild(keuzeDiv);
                    }
                }

                optieGroup.querySelector('.remove-optie').addEventListener('click', () => optieGroup.remove());
                optieGroup.querySelector('.add-keuze').addEventListener('click', function() {
                    const newKeuzeDiv = document.createElement('div');
                    newKeuzeDiv.className = 'keuze flex gap-2';
                    newKeuzeDiv.innerHTML = `
                        <input type="text" name="keuze[${editOptieIndexForModal}][]" class="border rounded flex-1 p-2" placeholder="Keuze (bijv. Mat papier)" required>
                        <button type="button" class="remove-keuze text-red-500 hover:text-red-700">×</button>
                    `;
                    newKeuzeDiv.querySelector('.remove-keuze').addEventListener('click', () => newKeuzeDiv.remove());
                    if (keuzesContainer) {
                        keuzesContainer.appendChild(newKeuzeDiv);
                    }
                });

                if (editProductOptiesContainer) {
                    editProductOptiesContainer.appendChild(optieGroup);
                }
                editOptieIndexForModal++;
            });
        } else {
            // Voeg minstens één optie groep toe als er geen opties zijn
            const optieGroup = document.createElement('div');
            optieGroup.className = 'optie-group border p-4 rounded-lg';
            optieGroup.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium">Optie 1</span>
                        <button type="button" class="remove-optie text-red-500 hover:text-red-700">×</button>
                    </div>
                    <input type="text" name="optie_naam[]" class="border rounded w-full p-2 mb-2" placeholder="Optienaam (bijv. Papierkeuze)" required>
                    <div class="keuzes-container space-y-2">
                        <div class="keuze flex gap-2">
                            <input type="text" name="keuze[0][]" class="border rounded flex-1 p-2" placeholder="Keuze (bijv. Mat papier)" required>
                            <button type="button" class="remove-keuze text-red-500 hover:text-red-700">×</button>
                        </div>
                    </div>
                    <button type="button" class="add-keuze mt-2 text-blue-500 hover:text-blue-700">+ Keuze toevoegen</button>
                `;

            optieGroup.querySelector('.remove-optie').addEventListener('click', () => optieGroup.remove());
            optieGroup.querySelector('.add-keuze').addEventListener('click', function() {
                const keuzesContainer = this.previousElementSibling;
                const newKeuze = document.createElement('div');
                newKeuze.className = 'keuze flex gap-2';
                newKeuze.innerHTML = `
                            <input type="text" name="keuze[${editOptieIndexForModal}][]" class="border rounded flex-1 p-2" placeholder="Keuze (bijv. Mat papier)" required>
                            <button type="button" class="remove-keuze text-red-500 hover:text-red-700">×</button>
                        `;
                newKeuze.querySelector('.remove-keuze').addEventListener('click', () => newKeuze.remove());
                if (keuzesContainer) {
                    keuzesContainer.appendChild(newKeuze);
                }
            });
            if (editProductOptiesContainer) {
                editProductOptiesContainer.appendChild(optieGroup);
            }
        }
    }

    // Load current media preview with removal functionality
    if (product.media && product.media.length > 0) {
        const currentMediaPreview = document.getElementById('currentMediaPreview');
        if (currentMediaPreview) {
            currentMediaPreview.innerHTML = '';
            product.media.forEach(mediaItem => {
                const mediaDiv = document.createElement('div');
                mediaDiv.classList.add('relative', 'inline-block', 'mr-2', 'mb-2');

                // Determine media type based on file extension
                const fileExtension = mediaItem.split('.').pop().toLowerCase();
                let mediaType = 'image';
                if (['mp4', 'mov', 'webm', 'ogg'].includes(fileExtension)) {
                    mediaType = 'video';
                }

                let mediaElement;
                if (mediaType === 'image') {
                    mediaElement = document.createElement('img');
                    mediaElement.src = `uploads/${mediaItem}`;
                    mediaElement.alt = mediaItem;
                    mediaElement.classList.add('max-w-[100px]', 'max-h-[100px]');
                } else if (mediaType === 'video') {
                    mediaElement = document.createElement('video');
                    mediaElement.src = `uploads/${mediaItem}`;
                    mediaElement.controls = true;
                    mediaElement.classList.add('max-w-[100px]', 'max-h-[100px]');
                } else {
                    console.warn("Unknown media type for file:", mediaItem);
                    return;
                }

                if (mediaElement) {
                    const deleteMediaButton = document.createElement('button');
                    deleteMediaButton.type = 'button';
                    deleteMediaButton.innerHTML = '×';
                    deleteMediaButton.classList.add('absolute', 'top-0', 'right-0', 'text-white', 'bg-red-500', 'hover:bg-red-700', 'rounded-full', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center', 'text-xs');
                    deleteMediaButton.addEventListener('click', function() {
                        const deleteMediaInput = document.createElement('input');
                        deleteMediaInput.type = 'hidden';
                        deleteMediaInput.name = 'delete_media[]';
                        deleteMediaInput.value = mediaItem;
                        const form = document.querySelector('#editProductModal form');
                        if (form) {
                            form.appendChild(deleteMediaInput);
                        }
                        if (mediaDiv) {
                            mediaDiv.remove();
                        }
                    });

                    mediaDiv.appendChild(mediaElement);
                    mediaDiv.appendChild(deleteMediaButton);
                    currentMediaPreview.appendChild(mediaDiv);
                }
            });
        }
    }

    const editModalElement = document.getElementById('editProductModal');
    if (editModalElement) {
        editModalElement.classList.remove('hidden');
    }
}

function closeEditModal() {
    const editModalElement = document.getElementById('editProductModal');
    if (editModalElement) {
        editModalElement.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Function to disable background scroll
    function disableBackgroundScroll() {
        document.body.style.overflow = 'hidden';
    }

    // Function to enable background scroll
    function enableBackgroundScroll() {
        document.body.style.overflow = '';
    }

    // Event listeners for edit buttons
    document.querySelectorAll('.edit-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const categorieId = this.getAttribute('data-categorie');
            const naam = this.getAttribute('data-naam');
            const beschrijving = this.getAttribute('data-beschrijving');
            const prijs = this.getAttribute('data-prijs');
            const file_types = this.getAttribute('data-file_types');
            const requirements = this.getAttribute('data-requirements');
            const allowed_file_types = this.getAttribute('data-allowed_file_types');
            const videosData = this.getAttribute('data-videos');
            const optiesData = this.getAttribute('data-opties');
            const mediaData = this.getAttribute('data-media');

            let videos = [];
            let opties = [];
            let media = [];

            try {
                if (videosData) {
                    videos = JSON.parse(videosData);
                }
            } catch (e) {
                videos = [];
                console.error("Error parsing videosData:", e);
            }

            try {
                if (optiesData) {
                    opties = JSON.parse(optiesData);
                }
            } catch (e) {
                opties = [];
                console.error("Error parsing optiesData:", e);
            }

            try {
                if (mediaData) {
                    media = JSON.parse(mediaData);
                }
            } catch (e) {
                media = [];
                console.error("Error parsing mediaData:", e);
            }

            // Populate allowed file types
            if (allowed_file_types) {
                const fileTypes = allowed_file_types.split(',');
                const fileTypeCheckboxes = document.querySelectorAll('#edit_file_types_checkboxes input[type="checkbox"]');
                fileTypeCheckboxes.forEach(checkbox => {
                    checkbox.checked = fileTypes.includes(checkbox.value);
                });
            }

            openEditModal(
                {
                    id: productId,
                    categorie_id: categorieId,
                    naam: naam,
                    beschrijving: beschrijving,
                    prijs: prijs,
                    file_types: file_types,
                    requirements: requirements,
                    allowed_file_types: allowed_file_types,
                    videos: videos,
                    opties: opties,
                    media: media
                },
                categorieenData, // Assuming categorieenData is available here
                videoOptionsData
            );
            disableBackgroundScroll();
        });
    });

    // Event listeners for delete buttons
    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            document.getElementById('deleteProductId').value = productId;
            document.getElementById('deleteModal').classList.remove('hidden');
            disableBackgroundScroll();
        });
    });

    // Close modals and re-enable background scroll
    document.getElementById('closeEditModal').addEventListener('click', function() {
        closeEditModal();
        enableBackgroundScroll();
    });
    document.getElementById('cancelEdit').addEventListener('click', function() {
        closeEditModal();
        enableBackgroundScroll();
    });

    // Delete confirmation
    document.getElementById('confirmDelete').addEventListener('click', function() {
        document.getElementById('deleteForm').submit();
    });

    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteModal').classList.add('hidden');
        enableBackgroundScroll();
    });

    // Add functionality for the "Optie Toevoegen" button in the edit modal
    document.addEventListener('click', function(event) {
        if (event.target.id === 'edit_add-optie') {
            const editProductOptiesContainer = document.getElementById('edit_product-opties');
            if (editProductOptiesContainer) {
                const optieIndex = editProductOptiesContainer.querySelectorAll('.optie-group').length;

                const optieGroup = document.createElement('div');
                optieGroup.className = 'optie-group border p-4 rounded-lg';
                optieGroup.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium">Optie ${optieIndex + 1}</span>
                        <button type="button" class="remove-optie text-red-500 hover:text-red-700">×</button>
                    </div>
                    <input type="text" name="optie_naam[]" class="border rounded w-full p-2 mb-2" placeholder="Optienaam (bijv. Papierkeuze)" required>
                    <div class="keuzes-container space-y-2">
                        <div class="keuze flex gap-2">
                            <input type="text" name="keuze[${optieIndex}][]" class="border rounded flex-1 p-2" placeholder="Keuze (bijv. Mat papier)" required>
                            <button type="button" class="remove-keuze text-red-500 hover:text-red-700">×</button>
                        </div>
                    </div>
                    <button type="button" class="add-keuze mt-2 text-blue-500 hover:text-blue-700">+ Keuze toevoegen</button>
                `;

                optieGroup.querySelector('.remove-optie').addEventListener('click', () => optieGroup.remove());
                optieGroup.querySelector('.add-keuze').addEventListener('click', function() {
                    const keuzesContainer = this.previousElementSibling;
                    const newKeuze = document.createElement('div');
                    newKeuze.className = 'keuze flex gap-2';
                    newKeuze.innerHTML = `
                        <input type="text" name="keuze[${optieIndex}][]" class="border rounded flex-1 p-2" placeholder="Keuze (bijv. Mat papier)" required>
                        <button type="button" class="remove-keuze text-red-500 hover:text-red-700">×</button>
                    `;
                    newKeuze.querySelector('.remove-keuze').addEventListener('click', () => newKeuze.remove());
                    if (keuzesContainer) {
                        keuzesContainer.appendChild(newKeuze);
                    }
                });

                editProductOptiesContainer.appendChild(optieGroup);
            }
        }
    });
});