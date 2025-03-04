<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadRainbowSell Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function navigateToDetails() {
            const subject = document.getElementById("subject").value;
            if (subject) {
                window.location.href = `insertbook_details.php?subject=${subject}`;
            }
        }
    </script>
</head>

<body class="bg-[#FBFFE4]">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-xl mt-10">
        <h1 class="text-3xl font-bold mb-6">Sell Your Books</h1>

        <form action="submit.php" method="post" class="space-y-4">
            <div>
                <label for="subject" class="block text-lg font-semibold">Select Subject:</label>
                <select id="subject" name="subject" class="w-full p-3 border border-gray-300 rounded-lg" onchange="navigateToDetails()">
                    <option value="">Choose a subject...</option>
                    <option value="Science">Science</option>
                    <option value="Physics">Physics</option>
                    <option value="Chemistry">Chemistry</option>
                    <option value="Biology">Biology</option>
                    <option value="Botany">Botany</option>
                    <option value="Zoology">Zoology</option>
                    <option value="Art">Art</option>
                    <option value="SocialScience">Social Science</option>
                </select>
            </div>
            
        </form>
        
    </div>
</body>

</html>
