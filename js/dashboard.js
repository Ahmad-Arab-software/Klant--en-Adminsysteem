document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('delete-confirm-modal');
    if (deleteModal) {
        const modalOrderIdSpan = document.getElementById('modal-order-id');
        const modalFormOrderIdInput = document.getElementById('modal-form-order-id');
        const modalFormCsrfInput = document.getElementById('modal-form-csrf-token');
        const cancelButton = document.getElementById('cancel-delete-button');

        document.body.addEventListener('click', function(event) {
            const deleteButton = event.target.closest('.delete-order-button');
            if (deleteButton) {
                event.preventDefault();
                const orderId = deleteButton.dataset.orderId;
                const csrfToken = deleteButton.dataset.csrfToken;
                modalOrderIdSpan.textContent = orderId;
                modalFormOrderIdInput.value = orderId;
                modalFormCsrfInput.value = csrfToken;
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
            }

            const printButton = event.target.closest('.print-order-button');
            if (printButton) {
                event.preventDefault();
                const data = printButton.dataset;

                let productsHtml = '<tr><td colspan="2">Geen producten gevonden.</td></tr>';
                try {
                    const productDetails = JSON.parse(data.printDetailsJson);
                    if (Array.isArray(productDetails) && productDetails.length > 0) {
                        productsHtml = '';
                        productDetails.forEach(item => {
                            let optionsHtml = 'Geen specifieke opties';
                            if (item.gekozen_opties) {
                                try {
                                    const options = JSON.parse(item.gekozen_opties);
                                    if (options && typeof options === 'object' && Object.keys(options).length > 0) {
                                        optionsHtml = '<ul style="margin:0; padding-left: 15px; list-style-type: disc;">';
                                        for (const [key, value] of Object.entries(options)) {
                                            const optionName = `Optie (ID: ${String(key).replace(/_/g, ' ')})`;
                                            const optionValue = Array.isArray(value) ? value.join(', ') : value;
                                            optionsHtml += `<li><strong>${escapeHtml(optionName)}:</strong> ${escapeHtml(optionValue)}</li>`;
                                        }
                                        optionsHtml += '</ul>';
                                    }
                                } catch (e) { /* JSON parse error voor opties, negeer */ }
                            }

                            productsHtml += `
                                    <tr style="background-color: #f9f9f9;">
                                        <td colspan="2" style="padding: 10px; border-bottom: 2px solid #ccc;">
                                            <strong style="font-size: 1.1em;">${escapeHtml(item.product_naam || 'Onbekend Product')}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Aantal</th>
                                        <td>${escapeHtml(item.aantal || 'N/A')}</td>
                                    </tr>
                                    <tr>
                                        <th>Specificaties</th>
                                        <td>${optionsHtml}</td>
                                    </tr>
                                `;
                        });
                    }
                } catch (e) {
                    console.error("Fout bij parsen van product details JSON:", e);
                }

                const printContent = `
                        <html>
                        <head>
                            <title>Details Order ${escapeHtml(data.orderId)}</title>
                            <style>
                                body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
                                h1, h2 { color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; }
                                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                                th, td { border: 1px solid #ddd; padding: 12px; text-align: left; vertical-align: top; word-break: break-word; }
                                th { background-color: #f2f2f2; font-weight: bold; width: 150px; }
                                ul { margin: 0; padding-left: 20px; }
                                li { margin-bottom: 5px; }
                            </style>
                        </head>
                        <body>
                            <h1>Details Order #${escapeHtml(data.orderId)}</h1>
                            <h2>Algemene Informatie</h2>
                            <table>
                                <tr><th>Order ID</th><td>${escapeHtml(data.orderId)}</td></tr>
                                <tr><th>Klant E-mail</th><td>${escapeHtml(data.klantEmail)}</td></tr>
                                <tr><th>Besteld Op</th><td>${escapeHtml(data.besteldOp)}</td></tr>
                            </table>

                            <h2>Producten</h2>
                            <table>
                                ${productsHtml}
                            </table>
                        </body>
                        </html>
                    `;
                const printWindow = window.open('', '_blank');
                printWindow.document.write(printContent);
                printWindow.document.close();
                printWindow.onload = function() {
                    printWindow.focus();
                    printWindow.print();
                };
            }
        });

        if (cancelButton) {
            cancelButton.addEventListener('click', () => {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
            });
        }

        deleteModal.addEventListener('click', (event) => {
            if (event.target === deleteModal) {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
            }
        });
    }

    function escapeHtml(unsafe) {
        if (typeof unsafe !== 'string') {
            if (unsafe === null || unsafe === undefined) return '';
            try { unsafe = String(unsafe); } catch (e) { return ''; }
        }
        return unsafe
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

});