 <style>
     /* Hide scrollbar (Optional) */
     .scrollbar-hide::-webkit-scrollbar {
         display: none;
     }

     .scrollbar-hide {
         -ms-overflow-style: none;
         scrollbar-width: none;
     }
 </style>

 <div class="fixed top-16 w-full bg-white shadow z-30 px-2 py-3">
     <div class=" flex justify-center gap-4 items-center">
         <a href="index.php" class="py-3 px-6 bg-[#B3D8A8] text-gray-700 font-semibold rounded-full ">
             Home
         </a>
         <a href="filter.php?hide" class="py-3 px-6 bg-[#B3D8A8] text-gray-700 font-semibold rounded-full ">
             All
         </a>

         <div class="overflow-x-auto whitespace-nowrap scrollbar-hide flex gap-5 ml-4">
             <?php
                $catcalling = $connect->query("SELECT * FROM category");
                while ($cat = $catcalling->fetch_array()):
                    if (isset($_GET['filter'])):
                        $filter = $_GET['filter'];
                        if ($filter == $cat['cat_title']):
                ?>
                         <a href="filter.php?filter=<?= $cat['cat_title']; ?>" class="py-3 hover:scale-105 px-6 bg-blue-300 text-gray-700 font-semibold rounded-full">
                             <?= $cat['cat_title']; ?>
                         </a>
                     <?php else: ?>
                         <a href="filter.php?filter=<?= $cat['cat_title']; ?>" class="py-3 hover:scale-105 px-6 bg-gray-100 text-gray-700 font-semibold rounded-full hover:bg-gray-200">
                             <?= $cat['cat_title']; ?>
                         </a>
                     <?php endif; ?>
                 <?php else : ?>
                     <a href="filter.php?filter=<?= $cat['cat_title']; ?>" class="py-3 hover:scale-105 px-6 bg-gray-100 text-gray-700 font-semibold rounded-full hover:bg-gray-200">
                         <?= $cat['cat_title']; ?>
                     </a>

             <?php endif;
                endwhile; ?>
         </div>
     </div>
 </div>