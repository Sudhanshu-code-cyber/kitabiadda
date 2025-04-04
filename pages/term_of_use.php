<?php
include_once "config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Use - KitabiAdda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .terms-section {
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

        .highlight {
            background-color: #E8F5F2;
            padding: 2px 4px;
            border-radius: 3px;
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
                    <h2 class="text-xl font-bold text-[#3D8D7A] mb-6">Terms of Use</h2>
                    <nav class="space-y-3">
                        <a href="#introduction" class="block nav-link pl-4 py-2 text-gray-700 active">Introduction</a>
                        <a href="#accounts" class="block nav-link pl-4 py-2 text-gray-700">User Accounts</a>
                        <a href="#content" class="block nav-link pl-4 py-2 text-gray-700">Content Policy</a>
                        <a href="#purchases" class="block nav-link pl-4 py-2 text-gray-700">Purchases</a>
                        <a href="#prohibited" class="block nav-link pl-4 py-2 text-gray-700">Prohibited Uses</a>
                        <a href="#intellectual" class="block nav-link pl-4 py-2 text-gray-700">Intellectual Property</a>
                        <a href="#termination" class="block nav-link pl-4 py-2 text-gray-700">Termination</a>
                        <a href="#disclaimer" class="block nav-link pl-4 py-2 text-gray-700">Disclaimer</a>
                        <a href="#liability" class="block nav-link pl-4 py-2 text-gray-700">Liability</a>
                        <a href="#changes" class="block nav-link pl-4 py-2 text-gray-700">Changes</a>
                        <a href="#governing" class="block nav-link pl-4 py-2 text-gray-700">Governing Law</a>
                        <a href="#contact" class="block nav-link pl-4 py-2 text-gray-700">Contact Us</a>
                    </nav>
                </div>
            </div>

            <!-- Terms Content -->
            <div class="lg:w-3/4">
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <h1 class="text-3xl font-bold text-[#3D8D7A] mb-6">Terms of Use</h1>
                    <p class="text-gray-600 mb-8">Last updated: June 15, 2023</p>

                    <!-- Introduction -->
                    <section id="introduction" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">1. Introduction</h2>
                        <p class="text-gray-700 mb-4">Welcome to KitabiAdda ("we," "our," or "us"). These Terms of Use govern your access to and use of our website, mobile application, and services (collectively, the "Service").</p>
                        <p class="text-gray-700">By accessing or using the Service, you agree to be bound by these Terms. If you disagree with any part of these Terms, you may not access the Service.</p>
                    </section>

                    <!-- User Accounts -->
                    <section id="accounts" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">2. User Accounts</h2>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">a. Account Creation</h3>
                        <p class="text-gray-700 mb-4">To access certain features of the Service, you may need to create an account. You agree to:</p>
                        <ul class="list-disc pl-6 space-y-2 text-gray-700 mb-4">
                            <li>Provide accurate, current, and complete information</li>
                            <li>Maintain and promptly update your account information</li>
                            <li>Maintain the security of your password</li>
                            <li>Accept all risks of unauthorized access</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">b. Account Responsibilities</h3>
                        <p class="text-gray-700">You are responsible for all activities that occur under your account. You must notify us immediately of any unauthorized use of your account.</p>
                    </section>

                    <!-- Content Policy -->
                    <section id="content" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">3. Content Policy</h2>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">a. User Content</h3>
                        <p class="text-gray-700 mb-4">You may be able to submit content including reviews, comments, and messages ("User Content"). You retain ownership of your User Content, but by submitting it, you grant us a worldwide, non-exclusive, royalty-free license to use, reproduce, modify, publish, and display your User Content.</p>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">b. Content Standards</h3>
                        <p class="text-gray-700">User Content must not:</p>
                        <ul class="list-disc pl-6 space-y-2 text-gray-700">
                            <li>Contain unlawful, abusive, or obscene material</li>
                            <li>Infringe any intellectual property rights</li>
                            <li>Contain viruses or malicious code</li>
                            <li>Promote illegal activities</li>
                            <li>Be misleading or false</li>
                        </ul>
                    </section>

                    <!-- Purchases -->
                    <section id="purchases" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">4. Purchases</h2>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">a. Orders</h3>
                        <p class="text-gray-700 mb-4">All book purchases are subject to availability. We reserve the right to refuse or cancel any order for any reason.</p>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">b. Pricing</h3>
                        <p class="text-gray-700 mb-4">Prices are subject to change without notice. We are not responsible for typographical errors regarding price or product information.</p>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-6">c. Payments</h3>
                        <p class="text-gray-700">You agree to pay all charges incurred by your account, including applicable taxes. Payment must be made through our approved payment methods.</p>
                    </section>

                    <!-- Prohibited Uses -->
                    <section id="prohibited" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">5. Prohibited Uses</h2>
                        <p class="text-gray-700 mb-4">You may not use the Service:</p>

                        <ul class="list-disc pl-6 space-y-2 text-gray-700">
                            <li>For any unlawful purpose</li>
                            <li>To solicit others to perform unlawful acts</li>
                            <li>To violate any regulations, rules, or laws</li>
                            <li>To harass, abuse, or harm others</li>
                            <li>To submit false or misleading information</li>
                            <li>To upload viruses or malicious code</li>
                            <li>To collect personal information of others</li>
                            <li>To interfere with the Service's security features</li>
                            <li>For any obscene or immoral purpose</li>
                            <li>To compete with our business</li>
                        </ul>
                    </section>

                    <!-- Intellectual Property -->
                    <section id="intellectual" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">6. Intellectual Property</h2>
                        <p class="text-gray-700 mb-4">The Service and its original content, features, and functionality are owned by KitabiAdda and are protected by international copyright, trademark, and other intellectual property laws.</p>
                        <p class="text-gray-700">Our trademarks may not be used in connection with any product or service without our prior written consent.</p>
                    </section>

                    <!-- Termination -->
                    <section id="termination" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">7. Termination</h2>
                        <p class="text-gray-700 mb-4">We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach these Terms.</p>
                        <p class="text-gray-700">Upon termination, your right to use the Service will immediately cease. All provisions of these Terms which should survive termination shall survive, including ownership provisions, warranty disclaimers, and limitations of liability.</p>
                    </section>

                    <!-- Disclaimer -->
                    <section id="disclaimer" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">8. Disclaimer</h2>
                        <p class="text-gray-700 mb-4">Your use of the Service is at your sole risk. The Service is provided "AS IS" and "AS AVAILABLE." We disclaim all warranties of any kind, whether express or implied, including but not limited to merchantability, fitness for a particular purpose, and non-infringement.</p>
                        <p class="text-gray-700">We do not warrant that the Service will be uninterrupted, secure, or error-free, that defects will be corrected, or that the Service is free of viruses or other harmful components.</p>
                    </section>

                    <!-- Liability -->
                    <section id="liability" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">9. Limitation of Liability</h2>
                        <p class="text-gray-700 mb-4">In no event shall KitabiAdda, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from:</p>

                        <ul class="list-disc pl-6 space-y-2 text-gray-700 mb-4">
                            <li>Your access to or use of or inability to access or use the Service</li>
                            <li>Any conduct or content of any third party on the Service</li>
                            <li>Any content obtained from the Service</li>
                            <li>Unauthorized access, use, or alteration of your transmissions or content</li>
                        </ul>

                        <p class="text-gray-700">This limitation applies whether the alleged liability is based on contract, tort, negligence, strict liability, or any other basis.</p>
                    </section>

                    <!-- Changes -->
                    <section id="changes" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">10. Changes to Terms</h2>
                        <p class="text-gray-700 mb-4">We reserve the right, at our sole discretion, to modify or replace these Terms at any time. We will provide notice of material changes through our Service or by other means.</p>
                        <p class="text-gray-700">By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms.</p>
                    </section>

                    <!-- Governing Law -->
                    <section id="governing" class="terms-section mb-12">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">11. Governing Law</h2>
                        <p class="text-gray-700 mb-4">These Terms shall be governed and construed in accordance with the laws of India, without regard to its conflict of law provisions.</p>
                        <p class="text-gray-700">Any disputes arising under or in connection with these Terms shall be subject to the exclusive jurisdiction of the courts located in Bangalore, India.</p>
                    </section>

                    <!-- Contact -->
                    <section id="contact" class="terms-section">
                        <h2 class="text-2xl font-bold text-[#3D8D7A] mb-4">12. Contact Us</h2>
                        <p class="text-gray-700">If you have any questions about these Terms, please contact us:</p>

                        <ul class="list-disc pl-6 space-y-2 text-gray-700 mt-4">
                            <li><strong>Email:</strong> legal@kitabiadda.com</li>
                            <li><strong>Address:</strong> KitabiAdda, 123 Book Street, Bangalore, India - 560001</li>
                            <li><strong>Phone:</strong> +91 80 1234 5678</li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </main>

   
    <?php include_once "includes/footer2.php";?>

    <script>
        // Highlight active section in sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.terms-section');
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