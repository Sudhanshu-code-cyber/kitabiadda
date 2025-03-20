<?php include_once "config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<style>
    /* Hide scrollbar for Webkit browsers (Chrome, Safari, Edge) */
    #bookScroll::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for Firefox */
    #bookScroll {
        scrollbar-width: none;
    }

    /* Container styling for smooth scrolling */
    #bookScroll {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    /* Same styles for the second carousel */
    #bookScroll2::-webkit-scrollbar {
        display: none;
    }

    #bookScroll2 {
        scrollbar-width: none;
    }

    #bookScroll2 {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    #bookScroll3::-webkit-scrollbar {
        display: none;
    }

    #bookScroll3 {
        scrollbar-width: none;
    }

    #bookScroll3 {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
</style>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <!-- body section -->

    <!-- First Carousel -->
    <div id="default-carousel" class="relative mt-30 w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative z-5 h-56 overflow-hidden md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="assets/images/download.webp"
                    class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>

            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="assets/images/download.webp"
                    class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>

            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="assets/images/download.webp"
                    class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>


             <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="assets/images/download.webp"
                    class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Other Items here ... -->
        </div>

        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                data-carousel-slide-to="0"></button>
            <!-- Other indicators here ... -->
        </div>

        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    <!-- Add this script to activate the first carousel -->
    <script>
        const prevButton = document.querySelector('[data-carousel-prev]');
        const nextButton = document.querySelector('[data-carousel-next]');
        const items = document.querySelectorAll('[data-carousel-item]');
        const indicators = document.querySelectorAll('[data-carousel-slide-to]');

        let currentIndex = 0;

        // Function to show the current slide
        function showSlide(index) {
            items.forEach((item, i) => {
                item.classList.add('hidden');
                if (i === index) {
                    item.classList.remove('hidden');
                }
            });
            indicators.forEach((indicator, i) => {
                if (i === index) {
                    indicator.setAttribute('aria-current', 'true');
                } else {
                    indicator.setAttribute('aria-current', 'false');
                }
            });
        }

        // Event listeners for the carousel controls
        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % items.length;
            showSlide(currentIndex);
        });

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + items.length) % items.length;
            showSlide(currentIndex);
        });

        // Event listeners for the carousel indicators
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentIndex = index;
                showSlide(currentIndex);
            });
        });

        // Initialize the carousel
        showSlide(currentIndex);
    </script>

    <!-- Book Sets Section for New Books -->
   
    <?php include_once "includes/newRelease.php";?>

    <!-- Book Sets Section for Old Books (Second Carousel) -->
   <?php include_once "includes/oldBook.php";?>



<!-- Book Sets Section for Old Books (Third Carousel) -->
<?php include_once "includes/e-Book.php";?>

<?php
include_once "includes/footer2.php";
?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>