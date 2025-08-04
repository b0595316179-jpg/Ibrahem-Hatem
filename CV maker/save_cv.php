<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional CV Maker</title>
    <!-- Tailwind CSS CDN for modern styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- CDN for html2canvas (to convert HTML to canvas image) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- CDN for jsPDF (to create PDF from canvas image) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
        /* Style for the CV preview area */
        .cv-preview {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            line-height: 1.6;
            color: #333;
            min-height: 800px; /* Simulate a page height */
        }
        .cv-preview h2 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.5rem;
        }
        .cv-preview h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .cv-preview p {
            margin-bottom: 0.5rem;
        }
        .cv-preview ul {
            list-style-type: disc;
            margin-left: 1.25rem;
            margin-bottom: 0.5rem;
        }
        .cv-preview ul li {
            margin-bottom: 0.25rem;
        }
        .cv-section {
            margin-bottom: 1.5rem;
        }
        .cv-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .cv-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .cv-header p {
            color: #4b5563;
            font-size: 1rem;
        }
    </style>
</head>
<body class="flex flex-col lg:flex-row items-start justify-center min-h-screen p-4 gap-6">

    <!-- CV Input Form -->
    <div class="bg-white p-8 rounded-xl shadow-lg w-full lg:w-1/2 max-w-2xl overflow-y-auto max-h-[95vh]">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">CV Maker</h1>

        <!-- Personal Information -->
        <div class="mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="fullName" class="block text-gray-700 text-sm font-bold mb-2">Full Name:</label>
                    <input type="text" id="fullName" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="John Doe">
                </div>
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" id="email" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="john.doe@example.com">
                </div>
                <div>
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                    <input type="tel" id="phone" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="+1234567890">
                </div>
                <div>
                    <label for="linkedin" class="block text-gray-700 text-sm font-bold mb-2">LinkedIn Profile:</label>
                    <input type="url" id="linkedin" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="https://linkedin.com/in/johndoe">
                </div>
                <div class="md:col-span-2">
                    <label for="portfolio" class="block text-gray-700 text-sm font-bold mb-2">Portfolio/Website:</label>
                    <input type="url" id="portfolio" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="https://johndoe.com">
                </div>
                <div class="md:col-span-2">
                    <label for="summary" class="block text-gray-700 text-sm font-bold mb-2">Summary/Objective:</label>
                    <textarea id="summary" rows="4" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="A brief summary of your professional goals and experience..."></textarea>
                </div>
            </div>
        </div>

        <!-- Education Section -->
        <div class="mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Education</h2>
            <div id="educationContainer">
                <!-- Education entries will be added here by JS -->
            </div>
            <button id="addEducationBtn" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Add Education</button>
        </div>

        <!-- Work Experience Section -->
        <div class="mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Work Experience</h2>
            <div id="experienceContainer">
                <!-- Experience entries will be added here by JS -->
            </div>
            <button id="addExperienceBtn" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Add Experience</button>
        </div>

        <!-- Skills Section -->
        <div class="mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Skills</h2>
            <div id="skillsContainer">
                <!-- Skills categories will be added here by JS -->
            </div>
            <button id="addSkillCategoryBtn" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Add Skill Category</button>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
            <button id="saveCVBtn" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out flex items-center justify-center">
                Save CV Data
            </button>
            <button id="loadCVBtn" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out flex items-center justify-center">
                Load CV Data
            </button>
            <button id="downloadPDFBtn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out flex items-center justify-center">
                Download PDF
            </button>
        </div>
    </div>

    <!-- CV Preview Area -->
    <div class="w-full lg:w-1/2 max-w-2xl p-4">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">CV Preview</h2>
        <div id="cvPreview" class="cv-preview">
            <!-- CV content will be rendered here -->
            <div class="text-center text-gray-500 py-10">
                <p>Your CV will appear here as you fill out the form.</p>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="spinner"></div>
        <p class="text-white ml-4 text-lg">Processing...</p>
    </div>

    <!-- Message Box for alerts -->
    <div id="messageBox" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl text-center">
            <p id="messageText" class="text-gray-800 text-lg mb-4"></p>
            <button id="messageBoxCloseBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">OK</button>
        </div>
    </div>

    <script>
        // --- DOM Elements ---
        const fullNameInput = document.getElementById('fullName');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const linkedinInput = document.getElementById('linkedin');
        const portfolioInput = document.getElementById('portfolio');
        const summaryTextarea = document.getElementById('summary');

        const educationContainer = document.getElementById('educationContainer');
        const addEducationBtn = document.getElementById('addEducationBtn');
        const experienceContainer = document.getElementById('experienceContainer');
        const addExperienceBtn = document.getElementById('addExperienceBtn');
        const skillsContainer = document.getElementById('skillsContainer');
        const addSkillCategoryBtn = document.getElementById('addSkillCategoryBtn');

        const cvPreview = document.getElementById('cvPreview');
        const saveCVBtn = document.getElementById('saveCVBtn');
        const loadCVBtn = document.getElementById('loadCVBtn');
        const downloadPDFBtn = document.getElementById('downloadPDFBtn');

        const loadingSpinner = document.getElementById('loadingSpinner');
        const messageBox = document.getElementById('messageBox');
        const messageText = document.getElementById('messageText');
        const messageBoxCloseBtn = document.getElementById('messageBoxCloseBtn');

        // --- CV Data Model ---
        let cvData = {
            personal: {
                fullName: '',
                email: '',
                phone: '',
                linkedin: '',
                portfolio: '',
                summary: ''
            },
            education: [],
            experience: [],
            skills: [] // Each skill object: { category: 'Programming Languages', items: ['JavaScript', 'Python'] }
        };

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
         * Debounces a function call.
         * @param {Function} func The function to debounce.
         * @param {number} delay The delay in milliseconds.
         * @returns {Function} The debounced function.
         */
        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        // --- CV Data Management ---

        /**
         * Gathers all data from the form and updates the cvData object.
         */
        function gatherCVData() {
            cvData.personal.fullName = fullNameInput.value.trim();
            cvData.personal.email = emailInput.value.trim();
            cvData.personal.phone = phoneInput.value.trim();
            cvData.personal.linkedin = linkedinInput.value.trim();
            cvData.personal.portfolio = portfolioInput.value.trim();
            cvData.personal.summary = summaryTextarea.value.trim();

            // Education
            cvData.education = [];
            document.querySelectorAll('.education-entry').forEach(entry => {
                cvData.education.push({
                    institution: entry.querySelector('[name="institution"]').value.trim(),
                    degree: entry.querySelector('[name="degree"]').value.trim(),
                    major: entry.querySelector('[name="major"]').value.trim(),
                    startDate: entry.querySelector('[name="eduStartDate"]').value.trim(),
                    endDate: entry.querySelector('[name="eduEndDate"]').value.trim()
                });
            });

            // Experience
            cvData.experience = [];
            document.querySelectorAll('.experience-entry').forEach(entry => {
                cvData.experience.push({
                    jobTitle: entry.querySelector('[name="jobTitle"]').value.trim(),
                    company: entry.querySelector('[name="company"]').value.trim(),
                    startDate: entry.querySelector('[name="expStartDate"]').value.trim(),
                    endDate: entry.querySelector('[name="expEndDate"]').value.trim(),
                    responsibilities: entry.querySelector('[name="responsibilities"]').value.trim()
                });
            });

            // Skills
            cvData.skills = [];
            document.querySelectorAll('.skill-category-entry').forEach(categoryEntry => {
                const categoryName = categoryEntry.querySelector('[name="skillCategory"]').value.trim();
                const skillItems = categoryEntry.querySelector('[name="skillItems"]').value.split(',').map(s => s.trim()).filter(s => s !== '');
                if (categoryName || skillItems.length > 0) {
                    cvData.skills.push({
                        category: categoryName,
                        items: skillItems
                    });
                }
            });

            updateCVPreview(); // Update preview after gathering data
        }

        /**
         * Populates the form fields with data from the cvData object.
         */
        function populateFormWithCVData() {
            fullNameInput.value = cvData.personal.fullName || '';
            emailInput.value = cvData.personal.email || '';
            phoneInput.value = cvData.personal.phone || '';
            linkedinInput.value = cvData.personal.linkedin || '';
            portfolioInput.value = cvData.personal.portfolio || '';
            summaryTextarea.value = cvData.personal.summary || '';

            // Clear existing dynamic sections
            educationContainer.innerHTML = '';
            experienceContainer.innerHTML = '';
            skillsContainer.innerHTML = '';

            // Populate Education
            cvData.education.forEach(edu => addEducationField(edu));
            if (cvData.education.length === 0) addEducationField(); // Add one empty if none exist

            // Populate Experience
            cvData.experience.forEach(exp => addExperienceField(exp));
            if (cvData.experience.length === 0) addExperienceField(); // Add one empty if none exist

            // Populate Skills
            cvData.skills.forEach(skill => addSkillCategoryField(skill));
            if (cvData.skills.length === 0) addSkillCategoryField(); // Add one empty if none exist

            updateCVPreview();
        }

        // --- Dynamic Form Field Generation ---

        /**
         * Adds a new education input field set.
         * @param {Object} [data={}] Optional initial data for the fields.
         */
        function addEducationField(data = {}) {
            const div = document.createElement('div');
            div.className = 'education-entry p-4 mb-4 border border-gray-200 rounded-lg bg-gray-50 relative';
            div.innerHTML = `
                <button type="button" class="remove-btn absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-xl">&times;</button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Institution:</label>
                        <input type="text" name="institution" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="University Name" value="${data.institution || ''}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Degree:</label>
                        <input type="text" name="degree" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Bachelor of Science" value="${data.degree || ''}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Major:</label>
                        <input type="text" name="major" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Computer Science" value="${data.major || ''}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                        <input type="month" name="eduStartDate" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="${data.startDate || ''}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
                        <input type="month" name="eduEndDate" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="${data.endDate || ''}">
                    </div>
                </div>
            `;
            educationContainer.appendChild(div);
            div.querySelector('.remove-btn').addEventListener('click', () => {
                div.remove();
                gatherCVData(); // Update data and preview after removal
            });
            div.querySelectorAll('input, textarea').forEach(input => input.addEventListener('input', debounce(gatherCVData, 300)));
        }

        /**
         * Adds a new experience input field set.
         * @param {Object} [data={}] Optional initial data for the fields.
         */
        function addExperienceField(data = {}) {
            const div = document.createElement('div');
            div.className = 'experience-entry p-4 mb-4 border border-gray-200 rounded-lg bg-gray-50 relative';
            div.innerHTML = `
                <button type="button" class="remove-btn absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-xl">&times;</button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Job Title:</label>
                        <input type="text" name="jobTitle" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Software Engineer" value="${data.jobTitle || ''}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Company:</label>
                        <input type="text" name="company" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Tech Solutions Inc." value="${data.company || ''}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                        <input type="month" name="expStartDate" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="${data.startDate || ''}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">End Date (or Present):</label>
                        <input type="month" name="expEndDate" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="${data.endDate || ''}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Responsibilities (comma-separated or bullet points):</label>
                        <textarea name="responsibilities" rows="4" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Developed web applications, Managed databases, Collaborated with team...">${data.responsibilities || ''}</textarea>
                    </div>
                </div>
            `;
            experienceContainer.appendChild(div);
            div.querySelector('.remove-btn').addEventListener('click', () => {
                div.remove();
                gatherCVData(); // Update data and preview after removal
            });
            div.querySelectorAll('input, textarea').forEach(input => input.addEventListener('input', debounce(gatherCVData, 300)));
        }

        /**
         * Adds a new skill category input field set.
         * @param {Object} [data={}] Optional initial data for the fields.
         */
        function addSkillCategoryField(data = {}) {
            const div = document.createElement('div');
            div.className = 'skill-category-entry p-4 mb-4 border border-gray-200 rounded-lg bg-gray-50 relative';
            div.innerHTML = `
                <button type="button" class="remove-btn absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-xl">&times;</button>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Skill Category:</label>
                        <input type="text" name="skillCategory" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g., Programming Languages" value="${data.category || ''}">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Skills (comma-separated):</label>
                        <input type="text" name="skillItems" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g., JavaScript, Python, SQL" value="${(data.items || []).join(', ')}">
                    </div>
                </div>
            `;
            skillsContainer.appendChild(div);
            div.querySelector('.remove-btn').addEventListener('click', () => {
                div.remove();
                gatherCVData(); // Update data and preview after removal
            });
            div.querySelectorAll('input, textarea').forEach(input => input.addEventListener('input', debounce(gatherCVData, 300)));
        }

        // Add initial empty fields
        addEducationField();
        addExperienceField();
        addSkillCategoryField();

        // --- CV Preview Rendering ---

        /**
         * Renders the CV data into the preview area.
         */
        function updateCVPreview() {
            let html = '';

            // Personal Information
            if (cvData.personal.fullName) {
                html += `
                    <div class="cv-header">
                        <h1>${cvData.personal.fullName}</h1>
                        <p>${cvData.personal.email ? `Email: ${cvData.personal.email}` : ''}
                           ${cvData.personal.phone ? ` | Phone: ${cvData.personal.phone}` : ''}
                           ${cvData.personal.linkedin ? ` | <a href="${cvData.personal.linkedin}" target="_blank" class="text-blue-600 hover:underline">LinkedIn</a>` : ''}
                           ${cvData.personal.portfolio ? ` | <a href="${cvData.personal.portfolio}" target="_blank" class="text-blue-600 hover:underline">Portfolio</a>` : ''}
                        </p>
                    </div>
                `;
            }

            if (cvData.personal.summary) {
                html += `
                    <div class="cv-section">
                        <h2>Summary</h2>
                        <p>${cvData.personal.summary.replace(/\n/g, '<br>')}</p>
                    </div>
                `;
            }

            // Education
            if (cvData.education.length > 0 && cvData.education.some(edu => edu.institution)) {
                html += `
                    <div class="cv-section">
                        <h2>Education</h2>
                        ${cvData.education.map(edu => `
                            <div>
                                <h3>${edu.degree} ${edu.major ? `- ${edu.major}` : ''}</h3>
                                <p>${edu.institution} ${edu.startDate || edu.endDate ? `(${edu.startDate} - ${edu.endDate})` : ''}</p>
                            </div>
                        `).join('')}
                    </div>
                `;
            }

            // Work Experience
            if (cvData.experience.length > 0 && cvData.experience.some(exp => exp.jobTitle)) {
                html += `
                    <div class="cv-section">
                        <h2>Work Experience</h2>
                        ${cvData.experience.map(exp => `
                            <div>
                                <h3>${exp.jobTitle} at ${exp.company}</h3>
                                <p>${exp.startDate} - ${exp.endDate || 'Present'}</p>
                                ${exp.responsibilities ? `
                                    <ul>
                                        ${exp.responsibilities.split('\n').filter(line => line.trim() !== '').map(line => `<li>${line.trim()}</li>`).join('')}
                                    </ul>
                                ` : ''}
                            </div>
                        `).join('')}
                    </div>
                `;
            }

            // Skills
            if (cvData.skills.length > 0 && cvData.skills.some(skillCat => skillCat.category || skillCat.items.length > 0)) {
                html += `
                    <div class="cv-section">
                        <h2>Skills</h2>
                        ${cvData.skills.map(skillCat => `
                            <p><strong>${skillCat.category}:</strong> ${skillCat.items.join(', ')}</p>
                        `).join('')}
                    </div>
                `;
            }

            cvPreview.innerHTML = html || `
                <div class="text-center text-gray-500 py-10">
                    <p>Your CV will appear here as you fill out the form.</p>
                </div>
            `;
        }

        // --- Event Listeners for Form Inputs (Debounced for performance) ---
        const formInputs = document.querySelectorAll('input, textarea');
        formInputs.forEach(input => {
            input.addEventListener('input', debounce(gatherCVData, 300));
        });

        // --- Event Listeners for Add Buttons ---
        addEducationBtn.addEventListener('click', () => {
            addEducationField();
            gatherCVData(); // Update data model and preview
        });
        addExperienceBtn.addEventListener('click', () => {
            addExperienceField();
            gatherCVData(); // Update data model and preview
        });
        addSkillCategoryBtn.addEventListener('click', () => {
            addSkillCategoryField();
            gatherCVData(); // Update data model and preview
        });

        // --- Server Interaction Functions ---

        /**
         * Saves the current CV data to the server.
         */
        saveCVBtn.addEventListener('click', async () => {
            gatherCVData(); // Ensure cvData is up-to-date
            showLoadingSpinner();
            try {
                const response = await fetch('save_cv.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(cvData),
                });
                const result = await response.json();
                if (result.status === 'success') {
                    showMessageBox(`CV data saved successfully! File: ${result.filePath}`);
                } else {
                    showMessageBox(`Failed to save CV data: ${result.message || 'Unknown error'}`);
                }
            } catch (error) {
                console.error('Error saving CV data:', error);
                showMessageBox('An error occurred while saving CV data to the server.');
            } finally {
                hideLoadingSpinner();
            }
        });

        /**
         * Loads CV data from the server.
         */
        loadCVBtn.addEventListener('click', async () => {
            showLoadingSpinner();
            try {
                // For simplicity, we'll try to load a default file or the last saved one.
                // In a real app, you'd have a way to select which CV to load.
                const response = await fetch('load_cv.php');
                const result = await response.json();

                if (result.status === 'success' && result.data) {
                    cvData = result.data;
                    populateFormWithCVData(); // Populate form and update preview
                    showMessageBox('CV data loaded successfully!');
                } else {
                    showMessageBox(`Failed to load CV data: ${result.message || 'No data found or unknown error'}`);
                }
            } catch (error) {
                console.error('Error loading CV data:', error);
                showMessageBox('An error occurred while loading CV data from the server.');
            } finally {
                hideLoadingSpinner();
            }
        });

        /**
         * Generates a PDF of the CV preview directly in the browser.
         */
        downloadPDFBtn.addEventListener('click', async () => {
            gatherCVData(); // Ensure cvData is up-to-date
            showLoadingSpinner();

            try {
                // Use html2canvas to render the cvPreview div into a canvas
                const canvas = await html2canvas(cvPreview, {
                    scale: 2, // Increase scale for better resolution in PDF
                    useCORS: true // Important if you have images from external sources
                });

                const imgData = canvas.toDataURL('image/png');
                const pdf = new window.jspdf.jsPDF('p', 'mm', 'a4'); // 'p' for portrait, 'mm' for millimeters, 'a4' for A4 size

                const imgWidth = 210; // A4 width in mm
                const pageHeight = 297; // A4 height in mm
                const imgHeight = canvas.height * imgWidth / canvas.width;
                let heightLeft = imgHeight;

                let position = 0;

                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                pdf.save('your_cv.pdf');
                showMessageBox('PDF generated and download started!');

            } catch (error) {
                console.error('Error generating PDF:', error);
                showMessageBox('An error occurred while generating the PDF. Ensure the CV preview is visible and not empty.');
            } finally {
                hideLoadingSpinner();
            }
        });


        // --- Initial Load ---
        // Populate form with initial empty fields and render empty preview
        populateFormWithCVData();
        messageBoxCloseBtn.addEventListener('click', hideMessageBox);

    </script>
</body>
</html>