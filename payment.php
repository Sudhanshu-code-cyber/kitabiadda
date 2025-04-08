<?php
include_once "config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Options | Kitabi Adda</title>
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

        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Hero Section -->
            <section class="bg-primary-600 text-white py-16">
                <div class="container mx-auto px-4 text-center">
                    <h1 class="text-4xl md:text-5xl font-bold font-serif mb-6">Payment Options</h1>
                    <p class="text-xl max-w-3xl mx-auto">Secure and convenient payment methods for your book purchases</p>
                </div>
            </section>

            <!-- Payment Content -->
            <section class="py-12 bg-white">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <!-- Payment Methods -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Available Payment Methods
                            </h2>
                            <div class="space-y-6">
                                <!-- Credit/Debit Cards -->
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex items-start">
                                        <div class="bg-primary-100 p-3 rounded-lg mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold mb-2">Credit/Debit Cards</h3>
                                            <p class="text-gray-600 mb-4">We accept all major credit and debit cards including Visa, Mastercard, American Express, and RuPay.</p>
                                            <div class="flex flex-wrap gap-3">
                                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/visa/visa-original.svg" alt="Visa" class="h-8" />
                                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mastercard/mastercard-original.svg" alt="Mastercard" class="h-8" />
                                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apple/apple-original.svg" alt="American Express" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/RuPay.svg/1200px-RuPay.svg.png" alt="RuPay" class="h-8" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- UPI -->
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex items-start">
                                        <div class="bg-primary-100 p-3 rounded-lg mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold mb-2">UPI Payments</h3>
                                            <p class="text-gray-600 mb-4">Make instant payments using any UPI app like Google Pay, PhonePe, Paytm, BHIM, and more.</p>
                                            <div class="flex flex-wrap gap-3">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/2008px-Google_%22G%22_Logo.svg.png" alt="Google Pay" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/06/PhonePe_Logo.svg/2560px-PhonePe_Logo.svg.png" alt="PhonePe" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Paytm_logo.png/640px-Paytm_logo.png" alt="Paytm" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/BHIM_Logo.png/640px-BHIM_Logo.png" alt="BHIM" class="h-8" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Net Banking -->
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex items-start">
                                        <div class="bg-primary-100 p-3 rounded-lg mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold mb-2">Net Banking</h3>
                                            <p class="text-gray-600 mb-4">Transfer funds directly from your bank account. We support all major Indian banks.</p>
                                            <div class="flex flex-wrap gap-3">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/SBI-logo.svg/2560px-SBI-logo.svg.png" alt="SBI" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/HDFC_Bank_Logo.svg/2560px-HDFC_Bank_Logo.svg.png" alt="HDFC" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/ICICI_Bank_Logo.svg/2560px-ICICI_Bank_Logo.svg.png" alt="ICICI" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7d/Axis_Bank_logo.svg/2560px-Axis_Bank_logo.svg.png" alt="Axis" class="h-8" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Wallets -->
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex items-start">
                                        <div class="bg-primary-100 p-3 rounded-lg mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold mb-2">Mobile Wallets</h3>
                                            <p class="text-gray-600 mb-4">Pay quickly using your favorite mobile wallet apps.</p>
                                            <div class="flex flex-wrap gap-3">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Paytm_logo.png/640px-Paytm_logo.png" alt="Paytm" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5d/Mobikwik_new_logo.svg/2560px-Mobikwik_new_logo.svg.png" alt="MobiKwik" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/2008px-Google_%22G%22_Logo.svg.png" alt="Google Pay" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/06/PhonePe_Logo.svg/2560px-PhonePe_Logo.svg.png" alt="PhonePe" class="h-8" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- EMI -->
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex items-start">
                                        <div class="bg-primary-100 p-3 rounded-lg mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold mb-2">EMI Options</h3>
                                            <p class="text-gray-600 mb-4">Convert your payment into easy EMIs with our partner banks.</p>
                                            <div class="flex flex-wrap gap-3">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/SBI-logo.svg/2560px-SBI-logo.svg.png" alt="SBI" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/HDFC_Bank_Logo.svg/2560px-HDFC_Bank_Logo.svg.png" alt="HDFC" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/ICICI_Bank_Logo.svg/2560px-ICICI_Bank_Logo.svg.png" alt="ICICI" class="h-8" />
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7d/Axis_Bank_logo.svg/2560px-Axis_Bank_logo.svg.png" alt="Axis" class="h-8" />
                                            </div>
                                            <p class="text-sm text-gray-500 mt-3">* EMI options available on orders above ₹2,000. Interest rates and terms apply.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Payment Security
                            </h2>
                            <div class="bg-gray-50 rounded-xl p-6">
                                <div class="flex flex-col md:flex-row items-center">
                                    <div class="md:w-1/3 mb-6 md:mb-0 flex justify-center">
                                        <img src="https://www.ssl.com/wp-content/uploads/2021/03/ssl-secure-badge-blue.png" alt="SSL Secure" class="h-24">
                                    </div>
                                    <div class="md:w-2/3 md:pl-8">
                                        <h3 class="text-lg font-bold mb-3">Your Payments Are 100% Secure</h3>
                                        <p class="text-gray-600 mb-4">We use industry-standard encryption and security protocols to ensure your payment information is protected. All transactions are processed through PCI-DSS compliant payment gateways.</p>
                                        <ul class="list-disc pl-5 space-y-1 text-gray-600">
                                            <li>256-bit SSL encryption for all transactions</li>
                                            <li>PCI-DSS compliant payment processing</li>
                                            <li>No storage of sensitive payment data on our servers</li>
                                            <li>Verified by Visa and Mastercard SecureCode</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Section -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold font-serif mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Payment FAQs
                            </h2>
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>Is it safe to enter my card details on Kitabi Adda?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>Yes, it's completely safe. We use industry-standard 256-bit SSL encryption to protect your payment information. We don't store your full card details on our servers, and all transactions are processed through PCI-DSS compliant payment gateways.</p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>What should I do if my payment fails?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>If your payment fails, please:</p>
                                        <ol class="list-decimal pl-5 mt-2 space-y-1">
                                            <li>Check if you entered all card details correctly</li>
                                            <li>Ensure you have sufficient balance in your account</li>
                                            <li>Try using a different payment method</li>
                                            <li>Contact your bank to check if there are any restrictions</li>
                                        </ol>
                                        <p class="mt-2">If the problem persists, please contact our customer support team for assistance.</p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="flex justify-between items-center w-full p-4 text-left font-medium text-gray-800 hover:bg-gray-50 focus:outline-none">
                                        <span>Can I get a refund if I cancel my order?</span>
                                        <svg class="h-5 w-5 text-primary-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="px-4 pb-4 text-gray-600 hidden">
                                        <p>Yes, we offer refunds for cancelled orders as per our refund policy. The refund will be processed to the original payment method within 7-10 business days after cancellation. For digital products, refunds are only possible if the content hasn't been accessed or downloaded.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Need Help Section -->
                        <div class="bg-primary-50 rounded-xl p-8 text-center">
                            <h2 class="text-2xl font-bold font-serif mb-4">Need Help With Payment?</h2>
                            <p class="text-gray-700 mb-6">Our customer service team is available to assist you with any payment-related questions.</p>
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
    </script>
</body>

</html>