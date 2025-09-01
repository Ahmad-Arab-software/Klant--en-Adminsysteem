<!-- Productopties -->
<div x-show="activeTab === 'options'" class="bg-gray-50 p-6 rounded-lg border border-gray-100 shadow-inner transition-all duration-300">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h6a3 3 0 003-3v-6a3 3 0 00-3-3H5zm-1 2v6a1 1 0 011 1h6a1 1 0 011-1v-6a1 1 0 01-1-1H5a1 1 0 01-1 1zm0 2a1 1 0 011-1v4a1 1 0 01-1 1v-4zm3-1a1 1 0 011-1v1a1 1 0 01-1 1v-1zm3 0a1 1 0 011-1v1a1 1 0 01-1 1v-1zm3 0a1 1 0 011-1v1a1 1 0 01-1 1v-1z" clip-rule="evenodd" />
        </svg>
        Productopties
    </h3>
    <div id="product-opties" class="space-y-4">
        <!-- Option groups will be dynamically added here by JavaScript -->
    </div>
    <button type="button" id="add-optie" class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Nieuwe optie toevoegen</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addOptieBtn = document.getElementById('add-optie');
        const productOptiesContainer = document.getElementById('product-opties');
        let optieCount = 0;

        addOptieBtn.addEventListener('click', function() {
            const optieDiv = document.createElement('div');
            optieDiv.className = 'flex items-center gap-4';
            optieDiv.innerHTML = `



        `;

            productOptiesContainer.appendChild(optieDiv);

            // Voeg event listener toe aan de verwijderknop
            const deleteBtn = optieDiv.querySelector('button');
            deleteBtn.addEventListener('click', function() {
                optieDiv.remove();
            });

            optieCount++;
        });
    });
</script>