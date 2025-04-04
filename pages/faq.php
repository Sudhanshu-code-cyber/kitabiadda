<?php
include_once "config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs | Kitabi Adda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Open Sans', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
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

        <main class="flex-grow">
            <!-- Hero Section -->
            <section class="bg-primary-600 text-white py-16">
                <div class="container mx-auto px-4 text-center">
                    <h1 class="text-4xl md:text-5xl font-bold font-serif mb-6">Frequently Asked Questions</h1>
                    <p class="text-xl max-w-3xl mx-auto">Find answers to common questions about Kitabi Adda</p>
                </div>
            </section>

            <!-- FAQ Content -->
            <section class="py-12 bg-white">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <!-- Search Bar -->
                        <div class="mb-12 relative">
                            <input type="text" placeholder="Search FAQs..." class="w-full py-4 px-6 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent">
                            <button class="absolute right-3 top-3 bg-primary-600 hover:bg-primary-700 text-white p-2 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>

                        <!-- FAQ Categories -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6">Browse by Category</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <a href="#account" class="bg-gray-50 hover:bg-primary-50 border border-gray-200 rounded-lg p-4 text-center transition">
                                    <div class="bg-primary-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Account</span>
                                </a>
                                <a href="#reading" class="bg-gray-50 hover:bg-primary-50 border border-gray-200 rounded-lg p-4 text-center transition">
                                    <div class="bg-primary-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Reading</span>
                                </a>
                                <a href="#subscriptions" class="bg-gray-50 hover:bg-primary-50 border border-gray-200 rounded-lg p-4 text-center transition">
                                    <div class="bg-primary-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Subscriptions</span>
                                </a>
                                <a href="#technical" class="bg-gray-50 hover:bg-primary-50 border border-gray-200 rounded-lg p-4 text-center transition">
                                    <div class="bg-primary-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Technical</span>
                                </a>
                                <a href="#community" class="bg-gray-50 hover:bg-primary-50 border border-gray-200 rounded-lg p-4 text-center transition">
                                    <div class="bg-primary-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Community</span>
                                </a>
                                <a href="#other" class="bg-gray-50 hover:bg-primary-50 border border-gray-200 rounded-lg p-4 text-center transition">
                                    <div class="bg-primary-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Other</span>
                                </a>
                            </div>
                        </div>

                        <!-- Account FAQs -->
                        <div id="account" class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Account Questions
                            </h2>
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>How do I create an account?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>Creating an account with Kitabi Adda is easy! Just click on the "Sign Up" button at the top right of any page. You'll need to provide your email address, create a password, and choose a username. After verifying your email, you'll have full access to all our features.</p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>I forgot my password. How can I reset it?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>To reset your password:</p>
                                        <ol class="list-decimal pl-5 mt-2 space-y-1">
                                            <li>Go to the login page</li>
                                            <li>Click on "Forgot Password"</li>
                                            <li>Enter the email address associated with your account</li>
                                            <li>Check your email for a password reset link</li>
                                            <li>Click the link and follow the instructions to create a new password</li>
                                        </ol>
                                        <p class="mt-2">If you don't see the email, please check your spam folder.</p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>Can I change my username?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>Yes, you can change your username once every 30 days. To change it:</p>
                                        <ol class="list-decimal pl-5 mt-2 space-y-1">
                                            <li>Go to your Account Settings</li>
                                            <li>Click on "Profile"</li>
                                            <li>Next to your username, click "Edit"</li>
                                            <li>Enter your new desired username</li>
                                            <li>Save your changes</li>
                                        </ol>
                                        <p class="mt-2">Note that your old username will become available for others to use after you change it.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reading FAQs -->
                        <div id="reading" class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Reading Questions
                            </h2>
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>How do I download books for offline reading?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>To download books for offline reading:</p>
                                        <ol class="list-decimal pl-5 mt-2 space-y-1">
                                            <li>Open the book you want to download</li>
                                            <li>Look for the download icon (downward arrow) in the top right corner</li>
                                            <li>Click the icon to download the book</li>
                                            <li>Once downloaded, you can access it from your "My Library" section even without internet</li>
                                        </ol>
                                        <p class="mt-2">Note: Downloads expire after 30 days and need to be refreshed. Some books may not be available for download due to publisher restrictions.</p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>What reading formats are supported?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>Kitabi Adda supports several reading formats:</p>
                                        <ul class="list-disc pl-5 mt-2 space-y-1">
                                            <li><strong>Web Reader:</strong> Read directly in your browser with adjustable font sizes and themes</li>
                                            <li><strong>Mobile Apps:</strong> Our iOS and Android apps provide the best reading experience</li>
                                            <li><strong>EPUB:</strong> Download books in EPUB format for compatible e-readers</li>
                                            <li><strong>PDF:</strong> Some books are available in PDF format</li>
                                        </ul>
                                        <p class="mt-2">You can change your preferred format in your Reading Settings.</p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>Can I highlight text and take notes?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>Yes! Kitabi Adda offers robust highlighting and note-taking features:</p>
                                        <ul class="list-disc pl-5 mt-2 space-y-1">
                                            <li>To highlight, simply select text and choose a highlight color</li>
                                            <li>To add a note, select text and click "Add Note"</li>
                                            <li>All your highlights and notes are saved in your "My Notebook" section</li>
                                            <li>You can organize notes by book, tag, or date</li>
                                            <li>Export your notes as PDF or text file</li>
                                        </ul>
                                        <p class="mt-2">Premium subscribers get unlimited highlights and advanced note organization features.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subscription FAQs -->
                        <div id="subscriptions" class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Subscription Questions
                            </h2>
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>What are the benefits of a premium subscription?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>Our premium subscription offers several benefits:</p>
                                        <ul class="list-disc pl-5 mt-2 space-y-1">
                                            <li>Unlimited access to our entire library of books</li>
                                            <li>Early access to new releases</li>
                                            <li>Unlimited highlights and notes</li>
                                            <li>Exclusive author interviews and events</li>
                                            <li>Priority customer support</li>
                                            <li>Ad-free reading experience</li>
                                            <li>Ability to download up to 20 books at a time for offline reading</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>How do I cancel my subscription?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>You can cancel your subscription at any time:</p>
                                        <ol class="list-decimal pl-5 mt-2 space-y-1">
                                            <li>Go to your Account Settings</li>
                                            <li>Select "Subscriptions"</li>
                                            <li>Click "Cancel Subscription"</li>
                                            <li>Follow the prompts to confirm cancellation</li>
                                        </ol>
                                        <p class="mt-2">Your subscription will remain active until the end of your current billing period. You'll receive a confirmation email once cancellation is complete.</p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>Do you offer student discounts?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>Yes! We offer a 50% discount for students currently enrolled in accredited institutions. To apply for the student discount:</p>
                                        <ol class="list-decimal pl-5 mt-2 space-y-1">
                                            <li>Go to our Student Discount page</li>
                                            <li>Verify your student status through our partner SheerID</li>
                                            <li>Once verified, you'll receive a discount code</li>
                                            <li>Apply this code when subscribing</li>
                                        </ol>
                                        <p class="mt-2">The discount is valid for up to 4 years or until graduation, whichever comes first. You'll need to re-verify your status annually.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Still Need Help Section -->
                        <div class="bg-primary-50 rounded-xl p-8 text-center">
                            <h2 class="text-2xl font-bold font-serif mb-4">Still need help?</h2>
                            <p class="text-gray-700 mb-6">Can't find the answer you're looking for? Our support team is happy to help.</p>
                            <a href="#" class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition">
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <?php include_once "includes/footer2.php"; ?>
    </div>

    <script>
        // Set current year in footer
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // FAQ accordion functionality
        document.querySelectorAll('.border-gray-200 button').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('svg');

                // Toggle content visibility
                content.classList.toggle('hidden');

                // Rotate icon
                if (content.classList.contains('hidden')) {
                    icon.classList.remove('rotate-180');
                } else {
                    icon.classList.add('rotate-180');
                }
            });
        });

        // Smooth scrolling for category links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>