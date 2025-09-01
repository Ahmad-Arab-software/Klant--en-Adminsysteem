<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <title>Nieuw Product Toevoegen</title>
    <!--    MADE BY AHMAD-->

</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
<div class="container mx-auto py-8 px-4 max-w-5xl">
    <!-- New product form with card effect -->
    <div class="bg-white p-8 shadow-2xl rounded-xl mb-8 border border-purple-100 transform transition-all duration-300 hover:shadow-purple-100">
        <h2 class="text-3xl font-bold text-purple-700 mb-6 flex items-center">
            <span class="invisible group-hover:visible transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-purple-700" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 01-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
            </span>
            Nieuw Product Toevoegen
        </h2>

        <form
                action="index.php?page=producten"
                method="POST"
                enctype="multipart/form-data"
                x-data="{
                activeTab: 'basic',
                steps: ['basic', 'specs', 'media', 'options'],
                getCurrentStepIndex() {
                    return this.steps.indexOf(this.activeTab);
                },
                formData: {
                    categorie: '',
                    prijs: '',
                    naam: '',
                    beschrijving: '',
                    requirements: '',
                    allowed_file_types: [],
                    product_videos: [],
                    media: [],
                    options: [],
                },
                handleFileUpload(event) {
                    this.formData.media = Array.from(event.target.files);
                },
                removeFile(index) {
                    this.formData.media.splice(index, 1);
                    const dt = new DataTransfer();
                    this.formData.media.forEach(file => dt.items.add(file));
                    document.getElementById('media-upload').files = dt.files;
                }
            }"
                class="space-y-6"
        >
            <?php include 'views/form_components/progress_bar.php'; ?>
            <?php include 'views/form_components/tab_navigation.php'; ?>
            <?php include 'views/form_components/navigation_buttons.php'; ?>

            <?php include 'views/form_components/basic_info.php'; ?>
            <?php include 'views/form_components/specifications.php'; ?>
            <?php include 'views/form_components/media_section.php'; ?>
            <?php include 'views/form_components/product_options.php'; ?>

            <?php include 'views/form_components/submit_button.php'; ?>
        </form>
    </div>
</div>
</body>
</html>