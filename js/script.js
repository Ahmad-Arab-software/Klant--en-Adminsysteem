function addMediaUploadListeners() {
    // Flag to track if listeners have been added
    if (this.listenersAdded) return;
    this.listenersAdded = true;

    const mediaUpload = document.getElementById('media-upload');
    if (mediaUpload) {
        mediaUpload.addEventListener('change', handleFileUpload);
    }

    const editMediaUpload = document.getElementById('edit_media-upload');
    if (editMediaUpload) {
        editMediaUpload.addEventListener('change', handleFileUpload);
    } else {
        // If the element doesn't exist yet, set up a mutation observer to watch for it
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (document.getElementById('edit_media-upload')) {
                    observer.disconnect();
                    addMediaUploadListeners();
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
}

function handleFileUpload(e) {
    const target = e.target;
    const previewContainerId = target.id === 'media-upload' ? 'preview-container' : 'edit_preview-container';
    const previewContainer = document.getElementById(previewContainerId);

    if (!previewContainer) return;

    previewContainer.innerHTML = '';

    Array.from(target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item relative group w-32 h-32';

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'object-cover w-full h-full rounded-lg';
                previewItem.appendChild(img);
            } else if (file.type.startsWith('video/')) {
                const video = document.createElement('video');
                video.controls = true;
                video.className = 'object-cover w-full h-full rounded-lg';
                const source = document.createElement('source');
                source.src = e.target.result;
                source.type = file.type;
                video.appendChild(source);
                previewItem.appendChild(video);
            }

            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '×';
            removeBtn.className = 'absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity';
            removeBtn.onclick = () => {
                previewItem.remove();
                const dataTransfer = new DataTransfer();
                Array.from(target.files).forEach(f => {
                    if (f !== file) dataTransfer.items.add(f);
                });
                target.files = dataTransfer.files;
            };

            previewItem.appendChild(removeBtn);
            previewContainer.appendChild(previewItem);
        };
        reader.readAsDataURL(file);
    });
}

// Initial call to add listeners
addMediaUploadListeners.call({ listenersAdded: false });