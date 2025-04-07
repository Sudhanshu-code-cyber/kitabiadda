<?php include_once "../config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Information | Kitabi Adda</title>
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
    <?php include_once "../includes/header.php"; ?>
    <?php include_once "../includes/subheader.php"; ?>
    <div class="min-h-screen mt-28 flex flex-col">
        <!-- Header -->


        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Hero Section -->
            <section class="bg-primary-600 text-white py-16">
                <div class="container mx-auto px-4 text-center">
                    <h1 class="text-4xl md:text-5xl font-bold font-serif mb-6">Shipping Information</h1>
                    <p class="text-xl max-w-3xl mx-auto">Everything you need to know about our shipping policies and delivery options</p>
                </div>
            </section>

            <!-- Shipping Content -->
            <section class="py-12 bg-white">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <!-- Shipping Options -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                                Shipping Options & Delivery Times
                            </h2>
                            <div class="bg-gray-50 rounded-xl p-6">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Time</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Standard Shipping</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">3-5 business days</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">Free on orders over ₹500</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">Yes</td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Express Shipping</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">1-2 business days</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">₹150</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">Yes</td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">International Shipping</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">7-14 business days</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">₹500+ (varies by country)</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">Yes</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="mt-4 text-sm text-gray-500">* Delivery times are estimates and may vary based on location and other factors.</p>
                            </div>
                        </div>

                        <!-- Shipping Policies -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Shipping Policies
                            </h2>
                            <div class="space-y-6">
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-bold mb-3">Processing Time</h3>
                                    <p class="text-gray-600">All orders are processed within 1-2 business days (excluding weekends and holidays) after receiving your order confirmation email. You will receive another notification when your order has shipped.</p>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-bold mb-3">International Shipping</h3>
                                    <p class="text-gray-600">We currently ship to over 50 countries worldwide. Please note we are not responsible for any customs and taxes applied to your order. All fees imposed during or after shipping are the responsibility of the customer (tariffs, taxes, etc.).</p>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-bold mb-3">Shipping Restrictions</h3>
                                    <p class="text-gray-600">Some books may be restricted from shipping to certain countries due to publisher restrictions. If this applies to your order, we will notify you immediately and provide a refund for the affected items.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tracking & Support -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Tracking & Support
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-bold mb-3">Tracking Your Order</h3>
                                    <p class="text-gray-600 mb-4">Once your order is shipped, you'll receive a tracking number via email. You can track your order using our tracking portal:</p>
                                    <a href="#" class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-md transition">Track Your Order</a>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-bold mb-3">Shipping Support</h3>
                                    <p class="text-gray-600 mb-4">Need help with your shipment? Our customer service team is available to assist you with any shipping-related questions.</p>
                                    <a href="#" class="inline-block bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 rounded-md transition">Contact Support</a>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Section -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Shipping FAQs
                            </h2>
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>Do you offer free shipping?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>Yes! We offer free standard shipping on all orders over ₹500 within India. For orders below ₹500, a flat shipping fee of ₹50 applies. International orders have variable shipping costs based on destination.</p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>What if my package is lost or damaged?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>In the rare event that your package is lost or damaged during transit, please contact our customer service team within 14 days of delivery. We'll work with the shipping carrier to resolve the issue and arrange for a replacement or refund as appropriate.</p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>Can I change my shipping address after ordering?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>You can change your shipping address within 1 hour of placing your order by contacting our customer service team. After this window, we cannot guarantee address changes as orders move quickly to processing. If the order has already shipped, you may need to coordinate with the shipping carrier directly.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Need Help Section -->
                        <div class="bg-primary-50 rounded-xl p-8 text-center">
                            <h2 class="text-2xl font-bold font-serif mb-4">Need Help With Shipping?</h2>
                            <p class="text-gray-700 mb-6">Our customer service team is available to answer any questions about your order's shipping status.</p>
                            <div class="flex flex-col sm:flex-row justify-center gap-4">
                                <a href="#" class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition">
                                    Contact Support
                                </a>
                                <a href="tel:+18005551234" class="inline-block border border-primary-600 text-primary-600 hover:bg-primary-50 font-medium py-3 px-6 rounded-lg transition">
                                    Call Us: +1 (800) 555-1234
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php include_once "../includes/footer2.php"; ?>
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
    </script>
</body>

</html>