// File: js/winkelwagen.js

document.addEventListener('DOMContentLoaded', () => {
    // --- DOM Elementen & State ---
    const winkelwagenContainer = document.getElementById('winkelwagen-container');
    const cartErrorModal = document.getElementById('cartErrorModal');
    const cartErrorModalText = document.getElementById('cartErrorModalText');
    const cartSuccessModal = document.getElementById('cartSuccessModal');
    const cartSuccessModalText = document.getElementById('cartSuccessModalText');
    const removeConfirmationModal = document.getElementById('removeConfirmationModal');

    let itemKeyToRemove = null;
    let isSubmitting = false;

    // --- Helper Functies ---
    const getCartFromLocalStorage = () => {
        try {
            const cartString = localStorage.getItem('winkelwagen');
            return cartString ? JSON.parse(cartString) : {};
        } catch (e) { return {}; }
    };

    const saveCartToLocalStorage = (cart) => {
        try {
            localStorage.setItem('winkelwagen', JSON.stringify(cart));
        } catch (e) { showErrorModal("Kon winkelwagen niet opslaan."); }
    };

    const escapeHtml = (unsafe) => {
        if (typeof unsafe !== 'string') return '';
        return unsafe
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    };
    const showErrorModal = (message) => {
        if (cartErrorModal && cartErrorModalText) {
            cartErrorModalText.textContent = message;
            cartErrorModal.classList.remove('hidden');
        } else {
            alert(message);
        }
    };

    // --- Rendering (AANGEPAST) ---
    const renderCart = () => {
        if (!winkelwagenContainer) return;
        const cartItems = getCartFromLocalStorage();
        const hasItems = Object.keys(cartItems).length > 0;

        if (!hasItems) {
            winkelwagenContainer.innerHTML = `<div class="text-center p-8 bg-white rounded-lg shadow-md"><i class="fas fa-shopping-cart fa-3x text-gray-400 mb-4"></i><h2 class="text-xl font-semibold text-gray-700">Je winkelwagen is leeg</h2><p class="text-gray-500 mt-2">Voeg producten toe om te bestellen.</p><a href="product.view.php" class="inline-block mt-6 px-5 py-2 bg-[#8fe507] text-white font-semibold rounded-lg hover:bg-[#7bc906]">Verder winkelen</a></div>`;
            return;
        }

        winkelwagenContainer.innerHTML = `
            <form id="checkout-form" class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="lg:col-span-2 space-y-4" id="cart-item-list"></div>
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-3">Overzicht</h2>
                        <div class="flex justify-between items-center mb-4"><span class="text-gray-700">Subtotaal:</span><span id="total-price" class="font-semibold text-lg text-gray-800">€0,00</span></div>
                        <button type="submit" id="checkout-button" class="w-full mt-6 flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-[#8fe507] hover:bg-[#7bc906] disabled:opacity-50"><span class="button-text">Bestelling afronden</span><div class="spinner hidden ml-2" style="border: 3px solid rgba(255,255,255,0.3); width: 20px; height: 20px; border-radius: 50%; border-left-color: #fff; animation: spin 1s ease infinite;"></div></button>
                    </div>
                </div>
            </form>`;

        let cartItemListHTML = '';
        let totalPrice = 0;
        let allFilesOk = true;

        for (const itemKey in cartItems) {
            const item = cartItems[itemKey];
            const priceText = item.display_details?.price_text?.replace('€', '').replace(',', '.') || '0';
            const validItemPrice = parseFloat(priceText) || 0;
            totalPrice += validItemPrice * (item.quantity || 1);

            // ==================================================================
            // AANGEPASTE LOGICA: Toon nu optie_naam en keuze_naam
            // ==================================================================
            let optiesHTML = '';
            if (item.options && Object.keys(item.options).length > 0) {
                optiesHTML += '<dl  class="mt-2 space-y-1 text-xs text-gray-700 bg-gray-100 p-2 rounded-md">';
                for (const optieNaam in item.options) {
                    const keuzes = item.options[optieNaam];
                    optiesHTML += `
                        <div class="flex items-start gap-2">
                            <dt class="font-semibold text-gray-600 w-28 shrink-0">${escapeHtml(optieNaam)}:</dt>
                            <dd class="text-gray-800 break-word">${escapeHtml(keuzes.join(', '))}</dd>
                        </div>`;
                }
                optiesHTML += '</dl>';
            }
            // ==================================================================

            let fileHTML = '';
            if (item.file) {
                if (item.file.temp_file_path) {
                    fileHTML = `<div class="mt-3 border-t pt-3"><div class="bg-green-50 text-green-800 p-3 rounded-md flex items-center gap-3 text-sm"><i class="fas fa-check-circle fa-lg"></i><div><span class="font-semibold">Bestand geüpload:</span><span class="block truncate">${escapeHtml(item.file.name)}</span></div></div></div>`;
                } else {
                    allFilesOk = false;
                    fileHTML = `<div class="mt-3 border-t pt-3"><div class="bg-red-50 text-red-800 p-3 rounded-md flex items-center gap-3 text-sm"><i class="fas fa-exclamation-triangle fa-lg"></i><div><span class="font-semibold">Upload vereist:</span><span class="block">Verwijder dit item en voeg het opnieuw toe.</span></div></div></div>`;
                }
            }

            const detailPageLink = `/test_ph/klant/views/product_detail.view.php?id=${item.product_id || ''}`;
            cartItemListHTML += `<div class="bg-white rounded-lg shadow-md p-4 flex flex-col sm:flex-row gap-4"><div class="w-24 h-24 sm:w-20 sm:h-20 flex-shrink-0 overflow-hidden rounded-md border"><a href="${detailPageLink}"><img src="${item.display_details?.image_url || '/test_ph/uploads/default_image.jpg'}" alt="${escapeHtml(item.display_details?.name)}" class="w-full h-full object-cover"></a></div><div class="flex-grow"><div class="flex justify-between items-start"><a href="${detailPageLink}" class="hover:underline"><h3 class="text-md font-semibold text-gray-800">${escapeHtml(item.display_details?.name)}</h3></a><button class="remove-item-button text-gray-400 hover:text-red-500 ml-2" data-item-key="${itemKey}"><i class="fas fa-times"></i></button></div><p class="text-sm text-gray-600 mt-0.5">Prijs: €${validItemPrice.toFixed(2).replace('.', ',')}</p><div class="mt-2 flex items-center space-x-2"><label class="text-xs font-medium text-gray-700">Aantal:</label><div class="quantity-control flex items-center border rounded"><button type="button" class="quantity-button px-2 py-0.5" data-action="decrease" data-item-key="${itemKey}">-</button><input type="number" class="quantity-input w-10 text-center text-sm border-0" data-item-key="${itemKey}" value="${item.quantity || 1}" min="1"><button type="button" class="quantity-button px-2 py-0.5" data-action="increase" data-item-key="${itemKey}">+</button></div></div>${optiesHTML}${fileHTML}</div></div>`;
        }

        document.getElementById('cart-item-list').innerHTML = cartItemListHTML;
        document.getElementById('total-price').textContent = '€' + totalPrice.toFixed(2).replace('.', ',');

        const checkoutButton = document.getElementById('checkout-button');
        if (checkoutButton) {
            checkoutButton.disabled = !allFilesOk;
            checkoutButton.title = allFilesOk ? "" : "Een of meer vereiste bestanden zijn niet geüpload.";
        }

        attachEventListeners();
    };

    const handleCheckoutSubmit = async (e) => {
        e.preventDefault();
        if (isSubmitting) return;

        const checkoutButton = document.getElementById('checkout-button');
        if (checkoutButton?.disabled) { showErrorModal("Kan niet afrekenen. Een of meer vereiste bestanden ontbreken."); return; }

        isSubmitting = true;
        const buttonText = checkoutButton?.querySelector('.button-text');
        const spinner = checkoutButton?.querySelector('.spinner');
        if(buttonText) buttonText.textContent = 'Verwerken...';
        if(spinner) spinner.classList.remove('hidden');
        if(checkoutButton) checkoutButton.disabled = true;

        const cartItems = getCartFromLocalStorage();
        const cartMetadata = {};
        Object.keys(cartItems).forEach(key => {
            cartMetadata[key] = {
                product_id: cartItems[key].product_id,
                quantity: cartItems[key].quantity,
                options: cartItems[key].options, // Dit is nu het object met namen
                original_filename: cartItems[key].file?.name,
                temp_file_path: cartItems[key].file?.temp_file_path
            };
        });

        const formData = new FormData();
        formData.append('cart_metadata', JSON.stringify(cartMetadata));

        try {
            const response = await fetch('/test_ph/klant/logic/winkelwagen.logic.php', { method: 'POST', body: formData });
            const data = await response.json();
            if (data.status !== 'success') throw new Error(data.message);

            if(cartSuccessModalText) cartSuccessModalText.textContent = data.message;
            cartSuccessModal?.classList.remove('hidden');
            localStorage.removeItem('winkelwagen');
            window.updateCartCount();
            setTimeout(() => { window.location.href = `/test_ph/klant/views/bestelling_bevestiging.view.php?id=${data.order_id}`; }, 2000);

        } catch (error) {
            showErrorModal(`Fout: ${error.message}`);
            if(buttonText) buttonText.textContent = 'Afrekenen';
            if(spinner) spinner.classList.add('hidden');
            if(checkoutButton) checkoutButton.disabled = false;
            isSubmitting = false;
        }
    };

    const attachEventListeners = () => {
        const container = document.getElementById('winkelwagen-container');
        if (!container) return;
        container.querySelectorAll('.quantity-input').forEach(i => { i.addEventListener('change', handleQuantityChange); });
        container.querySelectorAll('.quantity-button').forEach(b => { b.addEventListener('click', handleQuantityButtonClick); });
        container.querySelectorAll('.remove-item-button').forEach(b => { b.addEventListener('click', handleRemoveItemClick); });
        container.querySelector('#checkout-form')?.addEventListener('submit', handleCheckoutSubmit);
    };

    const handleQuantityChange = (e) => {
        const input = e.target;
        let quantity = parseInt(input.value, 10);
        if (isNaN(quantity) || quantity < 1) { quantity = 1; input.value = quantity; }
        updateCartItemQuantity(input.dataset.itemKey, quantity);
    };

    const handleQuantityButtonClick = (e) => {
        const button = e.currentTarget;
        const itemKey = button.dataset.itemKey;
        const inputField = document.querySelector(`.quantity-input[data-item-key="${itemKey}"]`);
        if (!inputField) return;
        let quantity = parseInt(inputField.value, 10);
        if (button.dataset.action === 'increase') { quantity++; }
        else if (quantity > 1) { quantity--; }
        inputField.value = quantity;
        updateCartItemQuantity(itemKey, quantity);
    };

    const handleRemoveItemClick = (e) => {
        e.stopPropagation();
        e.preventDefault();
        itemKeyToRemove = e.currentTarget.dataset.itemKey;
        removeConfirmationModal?.classList.remove('hidden');
    };

    const updateCartItemQuantity = (itemKey, quantity) => {
        let cart = getCartFromLocalStorage();
        if (cart[itemKey]) {
            cart[itemKey].quantity = quantity;
            saveCartToLocalStorage(cart);
            window.updateCartCount();
            renderCart();
        }
    };

    const confirmRemoveItem = () => {
        if (!itemKeyToRemove) return;
        let cart = getCartFromLocalStorage();
        if (cart[itemKeyToRemove]) {
            delete cart[itemKeyToRemove];
            saveCartToLocalStorage(cart);
            window.updateCartCount();
            renderCart();
        }
        hideRemoveConfirmationModal();
    };

    const hideRemoveConfirmationModal = () => {
        itemKeyToRemove = null;
        removeConfirmationModal?.classList.add('hidden');
    };

    document.querySelector('#removeConfirmationModal .remove-confirm-button')?.addEventListener('click', confirmRemoveItem);
    document.querySelector('#removeConfirmationModal .remove-cancel-button')?.addEventListener('click', hideRemoveConfirmationModal);

    renderCart();
});