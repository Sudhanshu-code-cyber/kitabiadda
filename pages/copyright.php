<?php
include_once "config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copyright Information | Your Company</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    <div class="min-h-screen mt-28 flex flex-col">
        <!-- Header -->
       
        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-12">
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="text-center mb-10">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Copyright Information</h1>
                        <div class="w-20 h-1 bg-primary-500 mx-auto"></div>
                    </div>

                    <div class="space-y-8">
                        <!-- Copyright Notice Section -->
                        <section>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                Copyright Notice
                            </h2>
                            <p class="text-gray-600 leading-relaxed">
                                © <span id="current-year"></span> YourBrand. All rights reserved. The content, organization, graphics, design, and other matters related to this site are protected under applicable copyrights, trademarks, and other proprietary (including but not limited to intellectual property) rights.
                            </p>
                        </section>

                        <!-- Permissions Section -->
                        <section>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd" />
                                </svg>
                                Permissions
                            </h2>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                You may view, download, and print pages from the website for your personal use, subject to the restrictions set out below and elsewhere in these terms of use.
                            </p>
                            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                                <li>You must not republish material from this website without permission</li>
                                <li>You must not sell, rent, or sub-license material from the website</li>
                                <li>You must not reproduce, duplicate, or copy material for commercial purposes</li>
                                <li>You must not redistribute content without express written consent</li>
                            </ul>
                        </section>

                        <!-- Fair Use Section -->
                        <section>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Fair Use
                            </h2>
                            <p class="text-gray-600 leading-relaxed">
                                The fair use of a copyrighted work for purposes such as criticism, comment, news reporting, teaching, scholarship, or research is not an infringement of copyright. If you wish to use copyrighted material for purposes beyond fair use, you must obtain permission from the copyright owner.
                            </p>
                        </section>

                        <!-- DMCA Section -->
                        <section>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                </svg>
                                DMCA Compliance
                            </h2>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                We respect the intellectual property rights of others. If you believe that your work has been copied in a way that constitutes copyright infringement, please provide our copyright agent with the following information:
                            </p>
                            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                                <li>A physical or electronic signature of the copyright owner</li>
                                <li>Identification of the copyrighted work claimed to have been infringed</li>
                                <li>Identification of the material that is claimed to be infringing</li>
                                <li>Your contact information including address, telephone number, and email</li>
                                <li>A statement that you have a good faith belief that use of the material is not authorized</li>
                            </ul>
                        </section>

                        <!-- Contact Section -->
                        <section class="bg-primary-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                Contact Information
                            </h2>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                For copyright-related inquiries, please contact our designated agent:
                            </p>
                            <div class="bg-white rounded-md p-4 shadow-sm">
                                <p class="text-gray-700"><span class="font-medium">Copyright Agent:</span> Legal Department</p>
                                <p class="text-gray-700"><span class="font-medium">Email:</span> copyright@yourbrand.com</p>
                                <p class="text-gray-700"><span class="font-medium">Phone:</span> (123) 456-7890</p>
                                <p class="text-gray-700"><span class="font-medium">Address:</span> 123 Business Ave, Suite 100, City, ST 12345</p>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <?php include_once "includes/footer2.php"; ?>
    </div>

    <script>
        // Set current year in copyright notices
        document.getElementById('current-year').textContent = new Date().getFullYear();
        document.getElementById('footer-year').textContent = new Date().getFullYear();
    </script>
</body>

</html>