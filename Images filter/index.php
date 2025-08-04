<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Filter App</title>
    <!-- Tailwind CSS CDN for easy styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background */
        }
        /* Custom styles for the loading spinner */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #3b82f6; /* Blue spinner */
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Hide canvas initially */
        #filteredCanvas {
            display: none;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-4xl">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Image Filter App</h1>

        <!-- File Upload Section -->
        <div class="mb-6 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition duration-300 ease-in-out">
            <label for="imageUpload" class="cursor-pointer text-blue-600 font-semibold text-lg">
                Upload an Image
                <input type="file" id="imageUpload" accept="image/*" class="hidden">
            </label>
            <p class="text-gray-500 text-sm mt-2">PNG, JPG, GIF up to 5MB</p>
        </div>

        <!-- Image Display and Canvas Section -->
        <div class="flex flex-col md:flex-row gap-6 mb-8">
            <div class="flex-1 flex flex-col items-center justify-center bg-gray-100 rounded-lg p-4 min-h-[200px] md:min-h-[400px]">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Original Image</h2>
                <img id="originalImage" src="https://placehold.co/400x300/e0e0e0/ffffff?text=Upload+Image" alt="Original Image" class="max-w-full h-auto rounded-lg shadow-md object-contain max-h-[350px]">
            </div>
            <div class="flex-1 flex flex-col items-center justify-center bg-gray-100 rounded-lg p-4 min-h-[200px] md:min-h-[400px]">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Filtered Image</h2>
                <canvas id="filteredCanvas" class="max-w-full h-auto rounded-lg shadow-md object-contain max-h-[350px]"></canvas>
                <!-- Placeholder for when canvas is not ready or image not loaded -->
                <div id="canvasPlaceholder" class="text-gray-500 text-center py-10">
                    <p>Your filtered image will appear here.</p>
                    <p>Upload an image to start.</p>
                </div>
            </div>
        </div>

        <!-- Filter Controls Section -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg shadow-inner">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Apply Filters</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                <button id="grayscaleBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Grayscale</button>
                <button id="sepiaBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Sepia</button>
                <button id="invertBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Invert</button>
                <button id="greenOverlayBtn" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Green Overlay</button>
                <button id="resetBtn" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out col-span-full sm:col-span-1">Reset</button>
            </div>

            <!-- Brightness Control -->
            <div class="mb-4">
                <label for="brightnessSlider" class="block text-gray-700 text-sm font-bold mb-2">Brightness: <span id="brightnessValue">0</span></label>
                <input type="range" id="brightnessSlider" min="-100" max="100" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            </div>

            <!-- Contrast Control -->
            <div class="mb-4">
                <label for="contrastSlider" class="block text-gray-700 text-sm font-bold mb-2">Contrast: <span id="contrastValue">0</span></label>
                <input type="range" id="contrastSlider" min="-100" max="100" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <button id="downloadBtn" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out flex items-center justify-center">
                Download Image
            </button>
            <button id="saveToServerBtn" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out flex items-center justify-center">
                Save to Server (PHP)
            </button>
        </div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="spinner"></div>
            <p class="text-white ml-4 text-lg">Applying filter...</p>
        </div>

        <!-- Message Box for alerts -->
        <div id="messageBox" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl text-center">
                <p id="messageText" class="text-gray-800 text-lg mb-4"></p>
                <button id="messageBoxCloseBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">OK</button>
            </div>
        </div>

    </div>

    <script>
        // Get DOM elements
        const imageUpload = document.getElementById('imageUpload');
        const originalImage = document.getElementById('originalImage');
        const filteredCanvas = document.getElementById('filteredCanvas');
        const ctx = filteredCanvas.getContext('2d');
        const canvasPlaceholder = document.getElementById('canvasPlaceholder');

        const grayscaleBtn = document.getElementById('grayscaleBtn');
        const sepiaBtn = document.getElementById('sepiaBtn');
        const invertBtn = document.getElementById('invertBtn');
        const greenOverlayBtn = document.getElementById('greenOverlayBtn');
        const resetBtn = document.getElementById('resetBtn');

        const brightnessSlider = document.getElementById('brightnessSlider');
        const brightnessValueDisplay = document.getElementById('brightnessValue');
        const contrastSlider = document.getElementById('contrastSlider');
        const contrastValueDisplay = document.getElementById('contrastValue');

        const downloadBtn = document.getElementById('downloadBtn');
        const saveToServerBtn = document.getElementById('saveToServerBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const messageBox = document.getElementById('messageBox');
        const messageText = document.getElementById('messageText');
        const messageBoxCloseBtn = document.getElementById('messageBoxCloseBtn');

        let currentImage = null; // Stores the original Image object
        let originalImageData = null; // Stores the ImageData of the original image
        let currentFilter = 'none'; // Tracks the currently applied filter
        let currentBrightness = 0;
        let currentContrast = 0;

        // --- Utility Functions ---

        /**
         * Displays a custom message box instead of alert().
         * @param {string} message The message to display.
         */
        function showMessageBox(message) {
            messageText.textContent = message;
            messageBox.classList.remove('hidden');
        }

        /**
         * Hides the custom message box.
         */
        function hideMessageBox() {
            messageBox.classList.add('hidden');
        }

        /**
         * Shows the loading spinner.
         */
        function showLoadingSpinner() {
            loadingSpinner.classList.remove('hidden');
        }

        /**
         * Hides the loading spinner.
         */
        function hideLoadingSpinner() {
            loadingSpinner.classList.add('hidden');
        }

        /**
         * Clamps a value between a minimum and maximum.
         * @param {number} value The value to clamp.
         * @param {number} min The minimum allowed value.
         * @param {number} max The maximum allowed value.
         * @returns {number} The clamped value.
         */
        function clamp(value, min, max) {
            return Math.min(Math.max(value, min), max);
        }

        // --- Image Loading and Drawing ---

        /**
         * Draws the current image onto the canvas.
         * If originalImageData is available, it redraws the original image.
         * Otherwise, it draws the currentImage object.
         */
        function drawImageOnCanvas() {
            if (!currentImage) {
                console.warn("No image loaded to draw.");
                return;
            }

            // Set canvas dimensions to match the image
            filteredCanvas.width = currentImage.width;
            filteredCanvas.height = currentImage.height;

            // Clear the canvas and draw the original image
            ctx.clearRect(0, 0, filteredCanvas.width, filteredCanvas.height);
            ctx.drawImage(currentImage, 0, 0, currentImage.width, currentImage.height);

            // Store the original pixel data for reset functionality
            originalImageData = ctx.getImageData(0, 0, filteredCanvas.width, filteredCanvas.height);

            // Show canvas and hide placeholder
            filteredCanvas.style.display = 'block';
            canvasPlaceholder.classList.add('hidden');
        }

        /**
         * Handles image file selection.
         * @param {Event} event The file input change event.
         */
        imageUpload.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                showMessageBox('Please upload a valid image file (PNG, JPG, GIF).');
                return;
            }

            showLoadingSpinner();

            const reader = new FileReader();
            reader.onload = (e) => {
                currentImage = new Image();
                currentImage.onload = () => {
                    originalImage.src = e.target.result; // Display original image
                    drawImageOnCanvas(); // Draw on canvas for filtering
                    resetFilters(); // Reset all filters when new image is loaded
                    hideLoadingSpinner();
                };
                currentImage.onerror = () => {
                    hideLoadingSpinner();
                    showMessageBox('Could not load the image. Please try another file.');
                };
                currentImage.src = e.target.result;
            };
            reader.onerror = () => {
                hideLoadingSpinner();
                showMessageBox('Error reading the file.');
            };
            reader.readAsDataURL(file);
        });

        // --- Filter Application Logic ---

        /**
         * Applies a specific filter to the image on the canvas.
         * This function reads pixel data, applies transformations, and puts it back.
         * @param {string} filterType The type of filter to apply (e.g., 'grayscale', 'sepia').
         */
        function applyFilter(filterType) {
            if (!originalImageData) {
                showMessageBox('Please upload an image first.');
                return;
            }

            showLoadingSpinner();

            // Use setTimeout to allow the loading spinner to render before heavy processing
            setTimeout(() => {
                // Always start from the original image data for consistent results
                const imageData = new ImageData(
                    new Uint8ClampedArray(originalImageData.data),
                    originalImageData.width,
                    originalImageData.height
                );
                const pixels = imageData.data;
                const numPixels = pixels.length / 4; // Each pixel has R, G, B, A

                for (let i = 0; i < numPixels; i++) {
                    const idx = i * 4;
                    let r = pixels[idx];
                    let g = pixels[idx + 1];
                    let b = pixels[idx + 2];
                    const a = pixels[idx + 3]; // Alpha channel

                    // Apply filter specific logic
                    switch (filterType) {
                        case 'grayscale':
                            const avg = (r + g + b) / 3;
                            r = g = b = avg;
                            break;
                        case 'sepia':
                            const newR_sepia = (r * 0.393) + (g * 0.769) + (b * 0.189);
                            const newG_sepia = (r * 0.349) + (g * 0.686) + (b * 0.168);
                            const newB_sepia = (r * 0.272) + (g * 0.534) + (b * 0.131);
                            r = newR_sepia;
                            g = newG_sepia;
                            b = newB_sepia;
                            break;
                        case 'invert':
                            r = 255 - r;
                            g = 255 - g;
                            b = 255 - b;
                            break;
                        case 'greenOverlay':
                            // Emphasize green, slightly reduce red/blue
                            r = clamp(r * 0.7, 0, 255);
                            g = clamp(g * 1.3, 0, 255); // Boost green significantly
                            b = clamp(b * 0.7, 0, 255);
                            break;
                        // No default, as brightness/contrast are applied separately
                    }

                    // Apply brightness and contrast after the main filter
                    // Brightness
                    if (currentBrightness !== 0) {
                        r = clamp(r + currentBrightness, 0, 255);
                        g = clamp(g + currentBrightness, 0, 255);
                        b = clamp(b + currentBrightness, 0, 255);
                    }

                    // Contrast
                    if (currentContrast !== 0) {
                        const factor = (259 * (currentContrast + 255)) / (255 * (259 - currentContrast));
                        r = clamp(factor * (r - 128) + 128, 0, 255);
                        g = clamp(factor * (g - 128) + 128, 0, 255);
                        b = clamp(factor * (b - 128) + 128, 0, 255);
                    }

                    // Update pixel data
                    pixels[idx] = r;
                    pixels[idx + 1] = g;
                    pixels[idx + 2] = b;
                    pixels[idx + 3] = a; // Keep alpha channel unchanged
                }

                ctx.putImageData(imageData, 0, 0);
                currentFilter = filterType; // Update the current filter state
                hideLoadingSpinner();
            }, 10); // Small delay to allow UI to update
        }

        /**
         * Resets all filters and draws the original image.
         */
        function resetFilters() {
            if (currentImage) {
                drawImageOnCanvas(); // Redraw original image
                currentFilter = 'none';
                currentBrightness = 0;
                currentContrast = 0;
                brightnessSlider.value = 0;
                brightnessValueDisplay.textContent = 0;
                contrastSlider.value = 0;
                contrastValueDisplay.textContent = 0;
            } else {
                showMessageBox('No image to reset.');
            }
        }

        // --- Event Listeners for Filter Buttons ---
        grayscaleBtn.addEventListener('click', () => applyFilter('grayscale'));
        sepiaBtn.addEventListener('click', () => applyFilter('sepia'));
        invertBtn.addEventListener('click', () => applyFilter('invert'));
        greenOverlayBtn.addEventListener('click', () => applyFilter('greenOverlay'));
        resetBtn.addEventListener('click', resetFilters);

        // --- Brightness and Contrast Sliders ---
        brightnessSlider.addEventListener('input', (event) => {
            currentBrightness = parseInt(event.target.value);
            brightnessValueDisplay.textContent = currentBrightness;
            // Reapply the current filter (or none) to include brightness
            applyFilter(currentFilter);
        });

        contrastSlider.addEventListener('input', (event) => {
            currentContrast = parseInt(event.target.value);
            contrastValueDisplay.textContent = currentContrast;
            // Reapply the current filter (or none) to include contrast
            applyFilter(currentFilter);
        });

        // --- Download Functionality ---
        downloadBtn.addEventListener('click', () => {
            if (!currentImage) {
                showMessageBox('Please upload an image to download.');
                return;
            }
            try {
                const dataURL = filteredCanvas.toDataURL('image/png'); // Get image as PNG data URL
                const a = document.createElement('a');
                a.href = dataURL;
                a.download = 'filtered_image.png'; // Suggested filename
                document.body.appendChild(a); // Append to body to make it clickable
                a.click(); // Programmatically click the link to trigger download
                document.body.removeChild(a); // Clean up
            } catch (error) {
                console.error("Error downloading image:", error);
                showMessageBox('Failed to download image. Please try again.');
            }
        });

        // --- Save to Server (PHP) Functionality ---
        saveToServerBtn.addEventListener('click', async () => {
            if (!currentImage) {
                showMessageBox('Please upload an image to save.');
                return;
            }

            showLoadingSpinner();
            try {
                const dataURL = filteredCanvas.toDataURL('image/png');
                // Extract base64 data part (remove "data:image/png;base64,")
                const base64Image = dataURL.split(',')[1];

                const response = await fetch('upload.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ imageData: base64Image }),
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showMessageBox(`Image saved successfully to: ${result.filePath}`);
                } else {
                    showMessageBox(`Failed to save image: ${result.message || 'Unknown error'}`);
                }
            } catch (error) {
                console.error('Error saving image to server:', error);
                showMessageBox('An error occurred while saving the image to the server.');
            } finally {
                hideLoadingSpinner();
            }
        });

        // --- Message Box Close Button ---
        messageBoxCloseBtn.addEventListener('click', hideMessageBox);

    </script>
</body>
</html>