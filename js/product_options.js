// Product options logic - separated file

let optieIndex = 0;
document.addEventListener('DOMContentLoaded', function() { // DOMContentLoaded to ensure elements are loaded
    const productOptionsContainer = document.getElementById('product-opties');
    if (productOptionsContainer) {

        // Initial Option Group - Option 1 - with one Keuze
        const initialOptieGroup = document.createElement('div');
        initialOptieGroup.className = 'optie-group border p-4 rounded-lg';
        initialOptieGroup.innerHTML = `
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
        productOptionsContainer.appendChild(initialOptieGroup);
        attachOptionListeners(initialOptieGroup, 0); // Attach listeners to initial option group

        // Add Option Button Event Listener
        const addOptieButton = document.getElementById('add-optie');
        if (addOptieButton) {
            addOptieButton.addEventListener('click', function() {
                optieIndex++;
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
                productOptionsContainer.appendChild(optieGroup);
                attachOptionListeners(optieGroup, optieIndex); // Attach listeners to new option group
            });
        }

        // Function to attach event listeners to an option group
        function attachOptionListeners(optieGroup, index) {
            optieGroup.querySelector('.remove-optie').addEventListener('click', () => optieGroup.remove());
            optieGroup.querySelector('.add-keuze').addEventListener('click', function() {
                const keuzesContainer = this.previousElementSibling;
                const newKeuze = document.createElement('div');
                newKeuze.className = 'keuze flex gap-2';
                newKeuze.innerHTML = `
                    <input type="text" name="keuze[${index}][]" class="border rounded flex-1 p-2" placeholder="Keuze (bijv. Mat papier)" required>
                    <button type="button" class="remove-keuze text-red-500 hover:text-red-700">×</button>
                `;
                newKeuze.querySelector('.remove-keuze').addEventListener('click', () => newKeuze.remove());
                keuzesContainer.appendChild(newKeuze);
            });
        }
    }
});