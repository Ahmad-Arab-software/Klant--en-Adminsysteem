<!-- Progress bar -->
<div class="w-full mb-8">
    <div class="relative pt-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-medium text-purple-600" x-text="'Stap ' + (getCurrentStepIndex() + 1) + ' van ' + steps.length"></span>
            <span class="text-xs font-medium text-purple-600" x-text="Math.round(((getCurrentStepIndex() + 1) / steps.length) * 100) + '%'"></span>
        </div>
        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-purple-100">
            <div
                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-600 transition-all duration-500 ease-in-out"
                :style="'width: ' + (((getCurrentStepIndex() + 1) / steps.length) * 100) + '%'"
            ></div>
        </div>
        <div class="flex justify-between">
            <template x-for="(step, index) in steps" :key="index">
                <div class="text-xs" :class="{'text-purple-700 font-bold': activeTab === step, 'text-gray-500': activeTab !== step}">
                    <span x-text="index === 0 ? 'Basis' : index === 1 ? 'Specs' : index === 2 ? 'Media' : 'Opties'"></span>
                </div>
            </template>
        </div>
    </div>
</div>