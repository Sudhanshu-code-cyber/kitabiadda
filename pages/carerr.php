<?php
include_once "../config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers at KitabiAdda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .benefit-card:hover {
            background-color: #E8F5F2;
        }

        .apply-btn:hover .arrow {
            transform: translateX(3px);
        }

        .tab-active {
            border-bottom: 3px solid #3D8D7A;
            color: #3D8D7A;
        }
    </style>
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/headear.php"; ?>
    <?php include_once "../includes/subheader.php"; ?>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r mt-28 from-[#B3D8A8] to-[#3D8D7A] text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Join the KitabiAdda Team</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Help us build the future of reading and book discovery</p>
            <a href="#open-positions" class="bg-white text-[#3D8D7A] px-6 py-3 rounded-md font-medium hover:bg-gray-100 transition inline-block">
                View Open Positions
            </a>
        </div>
    </section>

    <!-- Why Join Us -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#3D8D7A] mb-4">Why Work at KitabiAdda?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We're building a passionate team of book lovers and tech enthusiasts to revolutionize how people discover and share books.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Benefit 1 -->
                <div class="benefit-card bg-gray-50 p-8 rounded-xl transition duration-300">
                    <div class="text-[#3D8D7A] text-4xl mb-4">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Book-First Culture</h3>
                    <p class="text-gray-600">Free books, reading time during work hours, and regular book club meetings.</p>
                </div>

                <!-- Benefit 2 -->
                <div class="benefit-card bg-gray-50 p-8 rounded-xl transition duration-300">
                    <div class="text-[#3D8D7A] text-4xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Collaborative Team</h3>
                    <p class="text-gray-600">Work with passionate book lovers who value creativity and innovation.</p>
                </div>

                <!-- Benefit 3 -->
                <div class="benefit-card bg-gray-50 p-8 rounded-xl transition duration-300">
                    <div class="text-[#3D8D7A] text-4xl mb-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Growth Opportunities</h3>
                    <p class="text-gray-600">We invest in your development with training, conferences, and mentorship.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-16 bg-[#E8F5F2]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#3D8D7A] mb-4">Our Core Values</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">These principles guide everything we do at KitabiAdda</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Value 1 -->
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="h-16 w-16 bg-[#3D8D7A] text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Passion for Books</h3>
                    <p class="text-gray-600 text-sm">We genuinely love books and believe in their power to transform lives.</p>
                </div>

                <!-- Value 2 -->
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="h-16 w-16 bg-[#3D8D7A] text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lightbulb text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Innovative Thinking</h3>
                    <p class="text-gray-600 text-sm">We challenge conventions to create better book discovery experiences.</p>
                </div>

                <!-- Value 3 -->
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="h-16 w-16 bg-[#3D8D7A] text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-hands-helping text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Community Focus</h3>
                    <p class="text-gray-600 text-sm">We build for and with our community of readers and authors.</p>
                </div>

                <!-- Value 4 -->
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="h-16 w-16 bg-[#3D8D7A] text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-gem text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Integrity</h3>
                    <p class="text-gray-600 text-sm">We're honest, transparent, and ethical in all our dealings.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Open Positions -->
    <section class="py-16 bg-white" id="open-positions">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#3D8D7A] mb-4">Open Positions</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Join our team and help shape the future of book discovery</p>
            </div>

            <!-- Job Categories Tabs -->
            <div class="flex justify-center mb-8 border-b border-gray-200">
                <button class="tab-btn px-6 py-3 font-medium text-gray-600 hover:text-[#3D8D7A] transition tab-active" data-category="all">
                    All Positions
                </button>
                <button class="tab-btn px-6 py-3 font-medium text-gray-600 hover:text-[#3D8D7A] transition" data-category="tech">
                    Technology
                </button>
                <button class="tab-btn px-6 py-3 font-medium text-gray-600 hover:text-[#3D8D7A] transition" data-category="content">
                    Content
                </button>
                <button class="tab-btn px-6 py-3 font-medium text-gray-600 hover:text-[#3D8D7A] transition" data-category="business">
                    Business
                </button>
            </div>

            <!-- Job Listings -->
            <div class="grid md:grid-cols-2 gap-6 job-list">
                <!-- Job 1 -->
                <div class="job-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm transition duration-300" data-category="tech">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-[#3D8D7A]">Frontend Developer</h3>
                            <div class="flex items-center mt-1">
                                <span class="text-gray-500 text-sm mr-3"><i class="fas fa-map-marker-alt mr-1"></i> Remote</span>
                                <span class="text-gray-500 text-sm"><i class="fas fa-briefcase mr-1"></i> Full-time</span>
                            </div>
                        </div>
                        <span class="bg-[#E8F5F2] text-[#3D8D7A] text-xs font-semibold px-3 py-1 rounded-full">Tech</span>
                    </div>
                    <p class="text-gray-600 mb-4">We're looking for a skilled Frontend Developer to help build beautiful, responsive interfaces for our book discovery platform.</p>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">React</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">JavaScript</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">Tailwind CSS</span>
                    </div>
                    <a href="apply.php?position=frontend-developer" class="apply-btn inline-flex items-center text-[#3D8D7A] font-medium">
                        Apply Now <span class="arrow ml-1 transition">→</span>
                    </a>
                </div>

                <!-- Job 2 -->
                <div class="job-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm transition duration-300" data-category="content">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-[#3D8D7A]">Content Editor</h3>
                            <div class="flex items-center mt-1">
                                <span class="text-gray-500 text-sm mr-3"><i class="fas fa-map-marker-alt mr-1"></i> Bangalore</span>
                                <span class="text-gray-500 text-sm"><i class="fas fa-briefcase mr-1"></i> Full-time</span>
                            </div>
                        </div>
                        <span class="bg-[#E8F5F2] text-[#3D8D7A] text-xs font-semibold px-3 py-1 rounded-full">Content</span>
                    </div>
                    <p class="text-gray-600 mb-4">We need a passionate Content Editor to curate book recommendations, edit blog content, and maintain our editorial standards.</p>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">Editing</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">Publishing</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">SEO</span>
                    </div>
                    <a href="apply.php?position=content-editor" class="apply-btn inline-flex items-center text-[#3D8D7A] font-medium">
                        Apply Now <span class="arrow ml-1 transition">→</span>
                    </a>
                </div>

                <!-- Job 3 -->
                <div class="job-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm transition duration-300" data-category="business">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-[#3D8D7A]">Partnerships Manager</h3>
                            <div class="flex items-center mt-1">
                                <span class="text-gray-500 text-sm mr-3"><i class="fas fa-map-marker-alt mr-1"></i> Delhi</span>
                                <span class="text-gray-500 text-sm"><i class="fas fa-briefcase mr-1"></i> Full-time</span>
                            </div>
                        </div>
                        <span class="bg-[#E8F5F2] text-[#3D8D7A] text-xs font-semibold px-3 py-1 rounded-full">Business</span>
                    </div>
                    <p class="text-gray-600 mb-4">Build relationships with publishers, authors, and booksellers to expand our network and create value for our community.</p>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">Business Dev</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">Publishing</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">Negotiation</span>
                    </div>
                    <a href="apply.php?position=partnerships-manager" class="apply-btn inline-flex items-center text-[#3D8D7A] font-medium">
                        Apply Now <span class="arrow ml-1 transition">→</span>
                    </a>
                </div>

                <!-- Job 4 -->
                <div class="job-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm transition duration-300" data-category="tech">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-[#3D8D7A]">UX Designer</h3>
                            <div class="flex items-center mt-1">
                                <span class="text-gray-500 text-sm mr-3"><i class="fas fa-map-marker-alt mr-1"></i> Remote</span>
                                <span class="text-gray-500 text-sm"><i class="fas fa-briefcase mr-1"></i> Full-time</span>
                            </div>
                        </div>
                        <span class="bg-[#E8F5F2] text-[#3D8D7A] text-xs font-semibold px-3 py-1 rounded-full">Tech</span>
                    </div>
                    <p class="text-gray-600 mb-4">Design intuitive, book-loving experiences that help readers discover their next favorite book.</p>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">UI/UX</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">Figma</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">User Research</span>
                    </div>
                    <a href="apply.php?position=ux-designer" class="apply-btn inline-flex items-center text-[#3D8D7A] font-medium">
                        Apply Now <span class="arrow ml-1 transition">→</span>
                    </a>
                </div>
            </div>

            <div class="text-center mt-8">
                <p class="text-gray-600 mb-4">Don't see your dream job? We're always looking for talented people.</p>
                <a href="mailto:careers@kitabiadda.com" class="inline-block bg-[#3D8D7A] text-white px-6 py-3 rounded-md font-medium hover:bg-[#2c6b5b] transition">
                    Send Us Your Resume
                </a>
            </div>
        </div>
    </section>

    <!-- Life at KitabiAdda -->
    <section class="py-16 bg-[#E8F5F2]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#3D8D7A] mb-4">Life at KitabiAdda</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">See what makes our workplace special</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="rounded-lg overflow-hidden h-48">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Team meeting" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
                <div class="rounded-lg overflow-hidden h-48">
                    <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Office library" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
                <div class="rounded-lg overflow-hidden h-48">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Team event" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
                <div class="rounded-lg overflow-hidden h-48">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Workspace" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
            </div>
        </div>
    </section>
    <?php include_once "../includes/footer2.php"; ?>


    <script>
        // Job filtering functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const jobCards = document.querySelectorAll('.job-card');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Update active tab
                    tabButtons.forEach(btn => btn.classList.remove('tab-active'));
                    this.classList.add('tab-active');

                    const category = this.getAttribute('data-category');

                    // Filter jobs
                    jobCards.forEach(card => {
                        if (category === 'all' || card.getAttribute('data-category') === category) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>