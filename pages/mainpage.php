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

<form action="" class="relative my-4">
    <input placeholder="جستجو..." class="w-full  py-4 pr-16 rounded-3xl bg-[#e8e8e8]" type="text">
    <i class="fa fa-search absolute right-6 text-[#848484] inset-y-[25%] text-3xl" aria-hidden="true"></i>
</form>

<div class="relative">
    <img class="rounded-xl" src="<?php echo get_theme_image_url('foodbg.jpg'); ?>" alt="" srcset="">
    <span class="absolute top-20 z-50 right-5 text-white text-3xl">خوش‌مزه‌ترین لحظات <br> در کنار ما</span>
</div>




<?php get_template_part('components/foodselect', name: 'single'); ?>



<?php get_footer(); ?>