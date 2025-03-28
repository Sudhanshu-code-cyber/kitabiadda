<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBook Reader</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <style>
        .carousel-item {
            transition: transform 0.5s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-4 text-center">eBook Title</h1>
        <p class="text-gray-600 text-center">By <strong>Author Name</strong></p>

        <div class="mt-4 flex justify-center gap-4">
            <button onclick="increaseFontSize()" class="bg-blue-500 text-white px-3 py-2 rounded">A+</button>
            <button onclick="decreaseFontSize()" class="bg-gray-500 text-white px-3 py-2 rounded">A-</button>
            <button onclick="toggleDarkMode()" class="bg-black text-white px-3 py-2 rounded">Dark Mode</button>
        </div>

        <!-- eBook Slider -->
        <div id="ebook-slider" class="relative w-full mt-6 overflow-hidden">
            <div class="flex transition-transform ease-in-out duration-500" id="carousel-container">
                <div class="w-full flex-shrink-0 p-6 text-lg leading-relaxed bg-gray-50 rounded" id="slide-1">
                    Page 1 content goes here...
                </div>
                <div class="w-full flex-shrink-0 p-6 text-lg leading-relaxed bg-gray-50 rounded" id="slide-2">
                    Page 2 content goes here...
                </div>
                <div class="w-full flex-shrink-0 p-6 text-lg leading-relaxed bg-gray-50 rounded" id="slide-3">
                    Page 3 content goes here...
                </div>
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button onclick="prevSlide()" class="bg-gray-500 text-white px-3 py-2 rounded">Previous</button>
            <button onclick="nextSlide()" class="bg-blue-500 text-white px-3 py-2 rounded">Next</button>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll("#carousel-container div");
        const totalSlides = slides.length;

        function updateSlidePosition() {
            document.getElementById("carousel-container").style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlidePosition();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlidePosition();
        }

        function increaseFontSize() {
            document.querySelectorAll('#carousel-container div').forEach(el => {
                let size = window.getComputedStyle(el).fontSize;
                el.style.fontSize = (parseInt(size) + 2) + 'px';
            });
        }

        function decreaseFontSize() {
            document.querySelectorAll('#carousel-container div').forEach(el => {
                let size = window.getComputedStyle(el).fontSize;
                el.style.fontSize = (parseInt(size) - 2) + 'px';
            });
        }

        function toggleDarkMode() {
            document.body.classList.toggle("bg-black");
            document.body.classList.toggle("text-white");
            document.querySelectorAll('#carousel-container div').forEach(el => {
                el.classList.toggle("bg-gray-800");
                el.classList.toggle("text-white");
            });
        }
    </script>
</body>

</html>