<div class="flex justify-between mb-6">
    <button
            type="button"
            @click="activeTab = steps[Math.max(0, getCurrentStepIndex() - 1)]"
            class="px-4 py-2 text-purple-700 hover:bg-purple-50 rounded-lg transition-colors duration-200 flex items-center group"
            :class="{'opacity-50 cursor-not-allowed': getCurrentStepIndex() === 0}"
            :disabled="getCurrentStepIndex() === 0"
    >
    <span class="mr-2 transition-colors duration-200 group-hover:text-purple-900">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </span>
        Vorige
    </button>
    <button
            type="button"
            @click="activeTab = steps[Math.min(steps.length - 1, getCurrentStepIndex() + 1)]"
            class="px-4 py-2 text-purple-700 hover:bg-purple-50 rounded-lg transition-colors duration-200 flex items-center group"
            :class="{'opacity-50 cursor-not-allowed': getCurrentStepIndex() === steps.length - 1}"
            :disabled="getCurrentStepIndex() === steps.length - 1"
    >
        Volgende
        <span class="ml-2 transition-colors duration-200 group-hover:text-purple-900">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </span>
    </button>
</div>
