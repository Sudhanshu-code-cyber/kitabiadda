<?php
include_once "config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - KitabiAdda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .policy-section {
            scroll-margin-top: 100px;
        }

        .nav-link:hover {
            color: #3D8D7A;
        }

        .nav-link.active {
            color: #3D8D7A;
            font-weight: 600;
            border-left: 3px solid #3D8D7A;
        }
    </style>
</head>

<body class="bg-[#FBFFE4]">
    <!-- Navigation -->
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <!-- Main Content -->
    <main class="container mx-auto mt-28 px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Sidebar Navigation -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-32">
                    <h2 class="text-xl font-bold text-[#3D8D7A] mb-6">Privacy Policy</h2>
                    <nav class="space-y-3">
                        <a href="#introduction" class="block nav-link pl-4 py-2 text-gray-700 active">Introduction</a>
                        <a href="#data-collection" class="block nav-link pl-4 py-2 text-gray-700">Data We Collect</a>
                        <a href="#data-use" class="block nav-link pl-4 py-2 text-gray-700">How We Use Data</a>
                        <a href="#data-sharing" class="block nav-link pl-4 py-2 text-gray-700">Data Sharing</a>
                        <a href="#data-security" class="block nav-link pl-4 py-2 text-gray-700">Data Security</a>
                        <a href="#user-rights" class="block nav-link pl-4 py-2 text-gray-700">Your Rights</a>
                        <a href="#cookies" class="block nav-link pl-4 py-2 text-gray-700">Cookies</a>
                        <a href="#changes" class="block nav-link pl-4 py-2 text-gray-700">Policy Changes</a>
                        <a href="#contact" class="block nav-link pl-4 py-2 text-gray-700">Contact Us</a>
                    </nav>
                </div>
            </div>

            <!-- Policy Content -->
            <div class="lg:w-3/4">
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <h1 class="text-3xl font-bold text-[#3D8D7A] mb-6">Privacy Policy</h1>
                    <p class="text-gray-600 mb-8">Last updated: June 15, 2023</p>

                    <!-- Introduction -->
                    <section id="introduction" class="policy-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">1. Introduction</h2>
                        <p class="text-gray-700 mb-4">Welcome to KitabiAdda ("we," "our," or "us"). We are committed to protecting your privacy and ensuring the security of your personal information.</p>
                        <p class="text-gray-700">This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our website, mobile application, and services (collectively, the "Service"). Please read this policy carefully. By accessing or using our Service, you agree to the terms of this Privacy Policy.</p>
                    </section>

                    <!-- Data Collection -->
                    <section id="data-collection" class="policy-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">2. Data We Collect</h2>
                        <p class="text-gray-700 mb-4">We collect several types of information from and about users of our Service:</p>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">a. Personal Information</h3>
                        <ul class="list-disc pl-6 space-y-2 text-gray-700 mb-4">
                            <li>Name, email address, phone number</li>
                            <li>Account credentials (username and password)</li>
                            <li>Payment information (for purchases)</li>
                            <li>Profile information (reading preferences, wishlists)</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">b. Usage Data</h3>
                        <ul class="list-disc pl-6 space-y-2 text-gray-700 mb-4">
                            <li>IP address, browser type, device information</li>
                            <li>Pages visited, time spent, navigation paths</li>
                            <li>Search queries, book views, interactions</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">c. Cookies and Tracking Technologies</h3>
                        <p class="text-gray-700">We use cookies and similar tracking technologies to track activity on our Service. See our <a href="#cookies" class="text-[#3D8D7A] hover:underline">Cookies section</a> for more information.</p>
                    </section>

                    <!-- Data Use -->
                    <section id="data-use" class="policy-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">3. How We Use Data</h2>
                        <p class="text-gray-700 mb-4">We use the information we collect for various purposes:</p>

                        <ul class="list-disc pl-6 space-y-2 text-gray-700">
                            <li>To provide and maintain our Service</li>
                            <li>To notify you about changes to our Service</li>
                            <li>To allow you to participate in interactive features</li>
                            <li>To provide customer support</li>
                            <li>To gather analysis to improve our Service</li>
                            <li>To monitor usage of our Service</li>
                            <li>To detect, prevent, and address technical issues</li>
                            <li>To provide personalized book recommendations</li>
                            <li>To process transactions and send order confirmations</li>
                            <li>To communicate with you about products, services, and promotions</li>
                        </ul>
                    </section>

                    <!-- Data Sharing -->
                    <section id="data-sharing" class="policy-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">4. Data Sharing</h2>
                        <p class="text-gray-700 mb-4">We may share your information in the following situations:</p>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">a. Service Providers</h3>
                        <p class="text-gray-700 mb-4">We may employ third-party companies and individuals to facilitate our Service ("Service Providers"), provide the Service on our behalf, perform Service-related services, or assist us in analyzing how our Service is used.</p>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">b. Business Transfers</h3>
                        <p class="text-gray-700 mb-4">If we are involved in a merger, acquisition, or asset sale, your Personal Data may be transferred.</p>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">c. Legal Requirements</h3>
                        <p class="text-gray-700">We may disclose your information if required to do so by law or in response to valid requests by public authorities.</p>
                    </section>

                    <!-- Data Security -->
                    <section id="data-security" class="policy-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">5. Data Security</h2>
                        <p class="text-gray-700 mb-4">We implement appropriate technical and organizational measures to protect your personal data:</p>

                        <ul class="list-disc pl-6 space-y-2 text-gray-700">
                            <li>Encryption of sensitive data in transit and at rest</li>
                            <li>Regular security assessments and testing</li>
                            <li>Access controls and authentication measures</li>
                            <li>Employee training on data protection</li>
                        </ul>

                        <p class="text-gray-700 mt-4">However, no method of transmission over the Internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>
                    </section>

                    <!-- User Rights -->
                    <section id="user-rights" class="policy-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">6. Your Rights</h2>
                        <p class="text-gray-700 mb-4">Depending on your location, you may have certain rights regarding your personal data:</p>

                        <ul class="list-disc pl-6 space-y-2 text-gray-700">
                            <li><strong>Access:</strong> Request copies of your personal data</li>
                            <li><strong>Rectification:</strong> Request correction of inaccurate data</li>
                            <li><strong>Erasure:</strong> Request deletion of your personal data</li>
                            <li><strong>Restriction:</strong> Request restriction of processing</li>
                            <li><strong>Objection:</strong> Object to our processing of your data</li>
                            <li><strong>Portability:</strong> Request transfer of your data</li>
                            <li><strong>Withdraw Consent:</strong> Withdraw consent at any time</li>
                        </ul>

                        <p class="text-gray-700 mt-4">To exercise these rights, please contact us using the information in the <a href="#contact" class="text-[#3D8D7A] hover:underline">Contact Us</a> section.</p>
                    </section>

                    <!-- Cookies -->
                    <section id="cookies" class="policy-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">7. Cookies</h2>
                        <p class="text-gray-700 mb-4">We use cookies and similar tracking technologies to track activity on our Service.</p>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">a. Types of Cookies</h3>
                        <ul class="list-disc pl-6 space-y-2 text-gray-700 mb-4">
                            <li><strong>Essential Cookies:</strong> Necessary for the website to function</li>
                            <li><strong>Preference Cookies:</strong> Remember your preferences</li>
                            <li><strong>Analytics Cookies:</strong> Help us understand usage patterns</li>
                            <li><strong>Marketing Cookies:</strong> Used to track advertising effectiveness</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">b. Managing Cookies</h3>
                        <p class="text-gray-700">You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, some parts of our Service may not function properly.</p>
                    </section>

                    <!-- Policy Changes -->
                    <section id="changes" class="policy-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">8. Policy Changes</h2>
                        <p class="text-gray-700 mb-4">We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.</p>
                        <p class="text-gray-700">We will let you know via email and/or a prominent notice on our Service prior to the change becoming effective and update the "last updated" date at the top of this Privacy Policy.</p>
                    </section>

                    <!-- Contact -->
                    <section id="contact" class="policy-section">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">9. Contact Us</h2>
                        <p class="text-gray-700 mb-4">If you have any questions about this Privacy Policy, please contact us:</p>

                        <ul class="list-disc pl-6 space-y-2 text-gray-700">
                            <li><strong>Email:</strong> privacy@kitabiadda.com</li>
                            <li><strong>Address:</strong> KitabiAdda, 123 Book Street, Bangalore, India - 560001</li>
                            <li><strong>Phone:</strong> +91 80 1234 5678</li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
  <?php include_once "includes/footer2.php";?>
    <script>
        // Highlight active section in sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.policy-section');
            const navLinks = document.querySelectorAll('.nav-link');

            window.addEventListener('scroll', function() {
                let current = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;

                    if (pageYOffset >= (sectionTop - 200)) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>

</html>