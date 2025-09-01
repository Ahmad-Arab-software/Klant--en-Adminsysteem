<!-- Tab navigation -->
<div class="flex flex-wrap mb-4 border-b border-gray-200 overflow-x-auto">
    <button
            type="button"
            @click="activeTab = 'basic'"
            :class="{'bg-purple-100 text-purple-700 font-semibold border-b-2 border-purple-700': activeTab === 'basic', 'hover:bg-gray-100': activeTab !== 'basic'}"
            class="px-4 py-3 rounded-t-lg flex items-center transition-colors duration-200 whitespace-nowrap group"
    >
        <span class="mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
        </span>
        Basisinformatie
    </button>

    <button
            type="button"
            @click="activeTab = 'specs'"
            :class="{'bg-purple-100 text-purple-700 font-semibold border-b-2 border-purple-700': activeTab === 'specs', 'hover:bg-gray-100': activeTab !== 'specs'}"
            class="px-4 py-3 rounded-t-lg flex items-center transition-colors duration-200 whitespace-nowrap group"
    >
  <span class="mr-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6M9 10h6m-7 5h8" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2H8a2 2 0 00-2 2v2H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2h-2V4a2 2 0 00-2-2z" />
    </svg>
  </span>
        Specificaties
    </button>


    <button
            type="button"
            @click="activeTab = 'media'"
            :class="{'bg-purple-100 text-purple-700 font-semibold border-b-2 border-purple-700': activeTab === 'media', 'hover:bg-gray-100': activeTab !== 'media'}"
            class="px-4 py-3 rounded-t-lg flex items-center transition-colors duration-200 whitespace-nowrap group"
    >
        <span class="mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
            </svg>
        </span>
        Media
    </button>

    <button
            type="button"
            @click="activeTab = 'options'"
            :class="{'bg-purple-100 text-purple-700 font-semibold border-b-2 border-purple-700': activeTab === 'options', 'hover:bg-gray-100': activeTab !== 'options'}"
            class="px-4 py-3 rounded-t-lg flex items-center transition-colors duration-200 whitespace-nowrap group"
    >
    <span class="mr-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
      </svg>
    </span>
        Productopties
    </button>
</div>