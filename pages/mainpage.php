<?php
/*
Template Name: mainpage
*/
get_header();
?>

<?php get_template_part('components/header', 'single'); ?>

<div class="flex reyhaneh justify-between items-center">
    <p class="text-3xl">منو کافه یونیکد</p>
    <img class="w-[80px] h-[80px] rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
        alt="Default avatar">
</div>

<form action="" method="post" class="relative my-4 yekan">
 
    <input id="search-input" placeholder="جستجو..." class="w-full focus:outline-none py-4 pr-16 rounded-3xl bg-[#e8e8e8]" type="text">
    <i class="fa fa-search absolute right-6 text-[#848484] inset-y-[23%] text-2xl" aria-hidden="true"></i>
    <div id="suggestions-container" class="absolute max-h-[50vh] overflow-y-auto w-full bg-white mt-2 rounded-xl p-4 border-2 border-gray-300  shadow-lg z-[90]">
    <h2>نتایج:</h2>
    </div>
</form>


<div class="relative">
    <img class="rounded-xl" src="<?php echo get_theme_image_url('foodbg.jpg'); ?>" alt="" srcset="">
   <div class="absolute poster flex flex-col h-[100%] justify-between py-8 top-0  z-50 right-5">
    
   <span class=" text-white sm:text-3xl reyhaneh">خوش‌مزه‌ترین لحظات <br> در کنار ما</span>
<p class="cursor-pointer z-50 right-5 text-center text-white sm:text-xl border rounded-xl vazir sm:text-lg">اطلاعات رستوران</p>


   </div>
   </div>


   <?php get_template_part('components/waitermodal', name: 'single'); ?>



<?php get_template_part('components/foodselect', name: 'single'); ?>



<?php get_footer(); ?>