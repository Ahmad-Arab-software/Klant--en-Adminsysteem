<!-- Media -->
<div x-show="activeTab === 'media'" class="bg-gray-50 p-6 rounded-lg border border-gray-100 shadow-inner transition-all duration-300">
    <div>
        <label class="block text-gray-700 font-medium mb-2 flex items-center">
  <span class="mr-2 transition-colors duration-200">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01.88-7.903 5 5 0 0110.24 1.2A4.5 4.5 0 0117.5 16H7z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v9m0 0l-3-3m3 3l3-3" />
    </svg>
  </span>
            Media (Afbeeldingen/Video's):
        </label>

        <div class="relative">
            <label for="media-upload" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 flex items-center cursor-pointer transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Upload Media
            </label>
            <input
                    type="file"
                    name="media[]"
                    id="media-upload"
                    class="hidden"
                    multiple
                    accept="image/*,video/mp4"
                    @change="handleFileUpload($event)"
            >
        </div>
        <div class="mt-4 flex flex-wrap gap-4">
            <template x-for="(file, index) in formData.media" :key="index">
                <div class="relative">
                    <template x-if="file.type.startsWith('image/')">
                        <img :src="URL.createObjectURL(file)" class="w-32 h-32 object-cover rounded-lg" />
                    </template>
                    <template x-if="file.type.startsWith('video/')">
                        <video :src="URL.createObjectURL(file)" class="w-32 h-32 object-cover rounded-lg" controls></video>
                    </template>
                    <button
                            @click="removeFile(index)"
                            class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full transform translate-x-1/2 -translate-y-1/2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>