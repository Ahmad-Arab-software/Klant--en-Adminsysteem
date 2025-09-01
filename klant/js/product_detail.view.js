// File: js/product_detail.view.js

// --- Global State & Element Variables ---
// Declare variables in the global scope so functions can access them
let fileInput, fileUploadArea, filePreviewArea, fileNameSpan, fileSizeSpan, fileErrorP, addToCartButton, quantitySpan, quantityInput, mainImage, thumbnailContainers, cartNotificationModal, productIdInput, productTitleElement, priceElement;
let uploadedFile = null;
let isFileRequired = false;
let isUploading = false;

// --- Utility Functions ---
const getCartFromLocalStorage = () => {
    try {
        const cartString = localStorage.getItem('winkelwagen');
        return cartString ? JSON.parse(cartString) : {};
    } catch {
        return {};
    }
};

const saveCartToLocalStorage = (cart) => {
    try {
        localStorage.setItem('winkelwagen', JSON.stringify(cart));
    } catch (e) {
        console.error('Error saving cart:', e);
    }
};

const serializeOptionsForCartKey = (options) => {
    if (!options || Object.keys(options).length === 0) return 'no-options';
    const sortedOptionNames = Object.keys(options).sort();
    return sortedOptionNames
        .map((name) => {
            const values = Array.isArray(options[name]) ? [...options[name]].sort().join(',') : options[name];
            return `${name}:${values}`;
        })
        .join(';');
};

// --- UI Update Helpers ---
const showFileError = (message) => {
    if (!fileErrorP) return;
    fileErrorP.textContent = message;
    fileErrorP.classList.remove('hidden');
};

const clearFileError = () => {
    if (!fileErrorP) return;
    fileErrorP.textContent = '';
    fileErrorP.classList.add('hidden');
};

const resetFileInput = () => {
    if (fileInput) fileInput.value = '';
};

const updateFilePreview = (file) => {
    if (!fileNameSpan || !fileSizeSpan || !filePreviewArea || !fileUploadArea) return;
    fileNameSpan.textContent = file.name;
    fileSizeSpan.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
    filePreviewArea.classList.remove('hidden');
    fileUploadArea.classList.add('hidden');
};

const clearFilePreview = () => {
    if (!fileNameSpan || !fileSizeSpan || !filePreviewArea || !fileUploadArea) return;
    fileNameSpan.textContent = '';
    fileSizeSpan.textContent = '';
    filePreviewArea.classList.add('hidden');
    fileUploadArea.classList.remove('hidden');
};

const validateAddToCartButton = () => {
    if (!addToCartButton) return;
    const fileValid = !isFileRequired || (isFileRequired && uploadedFile !== null);
    addToCartButton.disabled = !fileValid || isUploading;
};

const setButtonLoadingState = (loading, text = 'Toevoegen aan winkelwagen') => {
    if (!addToCartButton) return;
    const icon = addToCartButton.querySelector('i');
    const span = addToCartButton.querySelector('span');
    addToCartButton.disabled = loading;
    if (icon) icon.className = loading ? 'fas fa-spinner fa-spin' : 'fas fa-shopping-cart';
    if (span) span.textContent = text;
    if (!loading) validateAddToCartButton();
};

const showCartNotification = () => {
    if (!cartNotificationModal) return;
    cartNotificationModal.classList.remove('opacity-0', 'translate-y-full');
    setTimeout(() => {
        cartNotificationModal.classList.add('opacity-0', 'translate-y-full');
    }, 3000);
};

// --- File Handling ---
const handleFileSelect = (event) => {
    clearFileError();
    const file = event.target.files[0];
    if (!file) {
        if (uploadedFile) removeFile();
        return;
    }

    const allowedTypesString = fileInput?.accept || '';
    const allowedTypes = allowedTypesString
        .split(',')
        .map((t) => t.trim().toLowerCase())
        .filter(Boolean);

    const fileExtension = '.' + file.name.split('.').pop()?.toLowerCase();
    const fileType = file.type.toLowerCase();

    const isValidType =
        allowedTypes.length === 0 ||
        allowedTypes.some((allowed) => {
            if (allowed.startsWith('.')) {
                if (allowed === fileExtension) return true;
                if (allowed === '.jpg' && fileExtension === '.jpeg') return true;
                if (allowed === '.jpeg' && fileExtension === '.jpg') return true;
                return false;
            }
            return fileType.includes(allowed);
        });

    if (!isValidType) {
        showFileError('Ongeldig bestandstype.');
        resetFileInput();
        uploadedFile = null;
        validateAddToCartButton();
        return;
    }

    if (file.size > 500 * 1024 * 1024) {
        showFileError('Bestand te groot (max 500 MB).');
        resetFileInput();
        uploadedFile = null;
        validateAddToCartButton();
        return;
    }

    uploadedFile = file;
    updateFilePreview(file);
    validateAddToCartButton();
};

const removeFile = () => {
    uploadedFile = null;
    resetFileInput();
    clearFileError();
    clearFilePreview();
    validateAddToCartButton();
};

// --- Quantity Controls ---
const increaseQuantity = () => {
    if (!quantityInput || !quantitySpan) return;
    let qty = parseInt(quantityInput.value, 10);
    qty++;
    quantityInput.value = qty;
    quantitySpan.textContent = qty;
};

const decreaseQuantity = () => {
    if (!quantityInput || !quantitySpan) return;
    let qty = parseInt(quantityInput.value, 10);
    if (qty > 1) {
        qty--;
        quantityInput.value = qty;
        quantitySpan.textContent = qty;
    }
};

const resetQuantity = () => {
    if (!quantityInput || !quantitySpan) return;
    quantityInput.value = '1';
    quantitySpan.textContent = '1';
};

// --- Image Thumbnails ---
const changeImage = (src, index) => {
    if (!mainImage || !thumbnailContainers) return;
    mainImage.src = src;
    thumbnailContainers.forEach((container, i) => {
        container.classList.toggle('ring-2', i === index);
        container.classList.toggle('ring-[#8fe507]', i === index); // Ensure the green ring is applied
        const thumbImg = container.querySelector('img');
        if (thumbImg) {
            thumbImg.classList.toggle('opacity-100', i === index);
            thumbImg.classList.toggle('opacity-70', i !== index);
        }
    });
};


// --- Accordion Initialization ---
const initAccordion = () => {
    document.querySelectorAll('.accordion-button').forEach((button) => {
        const contentId = button.id.replace('-button', '-content');
        const content = document.getElementById(contentId);
        const icon = button.querySelector('.accordion-icon');
        if (!content) return;
        content.style.maxHeight = '0'; // Initialize as closed

        button.addEventListener('click', () => {
            const isOpen = content.style.maxHeight !== '0px';
            content.style.maxHeight = isOpen ? '0' : content.scrollHeight + 'px';
            icon?.classList.toggle('rotate-180', !isOpen);
        });
    });
};

// --- Add To Cart (with file upload) ---
const addToCart = async () => {
    if (isUploading || addToCartButton?.disabled) return;

    let tempFilePath = null;
    let originalFileName = null;

    if (uploadedFile) {
        isUploading = true;
        setButtonLoadingState(true, 'Bestand uploaden...');
        const formData = new FormData();
        formData.append('product_file', uploadedFile);

        try {
            const response = await fetch('/test_ph/klant/logic/upload_temp_file.logic.php', {
                method: 'POST',
                body: formData,
            });
            const result = await response.json();

            if (result.status !== 'success') {
                throw new Error(result.message || 'Uploadfout.');
            }

            tempFilePath = result.temp_file_path;
            originalFileName = result.original_filename;
        } catch (error) {
            alert(`Fout bij uploaden: ${error.message}`);
            setButtonLoadingState(false);
            isUploading = false;
            return;
        }
    }

    setButtonLoadingState(false);
    isUploading = false;

    const productId = productIdInput?.value || '';
    const quantity = parseInt(quantityInput?.value, 10) || 1;

    const selectedOptions = {};
    document.querySelectorAll('input[type="checkbox"][name^="opties"]:checked').forEach((checkbox) => {
        const container = checkbox.closest('.border.border-gray-200');
        const optionNameElement = container?.querySelector('h4');
        if (optionNameElement) {
            const optionName = optionNameElement.textContent.trim();
            if (!selectedOptions[optionName]) selectedOptions[optionName] = [];
            selectedOptions[optionName].push(checkbox.value);
        }
    });

    let fileInfoForLocalStorage = null;
    if (tempFilePath && uploadedFile) {
        fileInfoForLocalStorage = {
            name: originalFileName,
            size: uploadedFile.size,
            type: uploadedFile.type,
            temp_file_path: tempFilePath,
        };
    }

    const cartItem = {
        product_id: productId,
        quantity,
        options: selectedOptions,
        file: fileInfoForLocalStorage,
        display_details: {
            name: productTitleElement?.textContent.trim() || '',
            price_text: priceElement?.textContent.trim() || '',
            image_url: mainImage?.src || '',
        },
    };

    const cart = getCartFromLocalStorage();
    const cartKey = `${productId}_${serializeOptionsForCartKey(selectedOptions)}`;

    if (cart[cartKey]) {
        cart[cartKey].quantity += quantity;
        if(fileInfoForLocalStorage) { // If a new file was uploaded, replace the old one
            cart[cartKey].file = fileInfoForLocalStorage;
        }
    } else {
        cart[cartKey] = cartItem;
    }

    saveCartToLocalStorage(cart);
    if (window.updateCartCount) {
        window.updateCartCount();
    }
    showCartNotification();
    resetQuantity();
    removeFile();
};

// --- Wait for the DOM to be fully loaded before trying to find elements ---
document.addEventListener('DOMContentLoaded', () => {
    // --- Assign DOM Elements ---
    fileInput = document.getElementById('bestand');
    fileUploadArea = document.getElementById('fileUploadArea');
    filePreviewArea = document.getElementById('filePreviewArea');
    fileNameSpan = document.getElementById('fileName');
    fileSizeSpan = document.getElementById('fileSize');
    fileErrorP = document.getElementById('fileError');
    addToCartButton = document.getElementById('addToCartButton');
    quantitySpan = document.getElementById('quantityValue');
    quantityInput = document.getElementById('quantity');
    mainImage = document.getElementById('mainImage');
    thumbnailContainers = document.querySelectorAll('.thumbnails > div[id^="thumb-container-"]');
    cartNotificationModal = document.getElementById('cartNotificationModal');
    productIdInput = document.querySelector('input[name="product_id"]');
    productTitleElement = document.querySelector('h2.text-3xl.font-bold');
    priceElement = document.querySelector('span.text-2xl.font-bold');

    // --- Initial State Setup ---
    isFileRequired = fileInput?.hasAttribute('required') || false;

    // --- Initialization Calls ---
    initAccordion();
    validateAddToCartButton();

    // No need for event listeners here anymore as they are handled by onclick attributes in the HTML
});