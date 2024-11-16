<?php
/*
Template Name: aboutus
*/
get_header();
?>

<?php get_template_part('components/header', 'single'); ?>

<div class="w-full pt-3  yekan">
    <div class="relative  w-full h-[250px]">
        <img class="w-full h-full object-cover rounded-xl"
            src="https://cdn.topmenumarket.com/storage/provider/301/conversions/cover/image_582380011-logo.webp" alt="">
        <!-- logo -->
        <img class="rounded-full imglogoinfo absolute -bottom-[25%] border-2 border-white right-[40%] w-[130px] h-[130px] object-cover"
            src="https://cdn.topmenumarket.com/storage/provider/301/conversions/logo/108969740_image-logo.webp" alt="">
    </div>
    <h3 class="mt-20 text-center yekan text-2xl w-full">کافه رستوران یونیکد</h3>
    <h3 class=" text-center yekan text-xl w-full">Unicode Cafe Restourant</h3>
    <div class="flex informationpage flex-wrap  mt-4 justify-between w-full">
        <div class="w-[32%]  rounded-xl text-center bg-[#1f9d7e] text-[white] p-4  text-lg ">
            <i class="fa fa-phone text-2xl mb-2" aria-hidden="true"></i>
            <div>
                ارتباط با ما
            </div>
        </div>


        <div class="w-[32%]  rounded-xl text-center bg-[#1f9d7e] text-[white] p-4  text-lg ">
      
        <i class="fa fa-camera-retro text-2xl mb-2"></i>
        <div>

            اینستاگرام
        </div>
    </div>
    
    <div id="open-modal" class="w-[32%] rounded-xl text-center bg-[#1f9d7e] text-[white] p-4  text-lg ">
    <i class="fa fa-user-secret  text-2xl mb-2" aria-hidden="true"></i>
        <div>

         گارسون
        </div>
    </div>
    
    </div>


    <div class="mt-4 mapaddress bg-[#1f9d7e] w-full items-center rounded-xl text-white flex justify-between p-4">
        <p class="text-sm">کرمانشاه نوبهار سی متری روبروی بانک کشاورزی</p>
  
        <p class="border flex items-center gap-2 border-[#F8EEDA] py-1 px-2 text-sm">      <i class="fa fa-map-marker text-[#F8EEDA]" aria-hidden="true"></i> مشاهده روی نقشه </p>
  
       
    </div>


    <div class="mt-4 mapaddress bg-[#1f9d7e] w-full items-center rounded-xl text-white flex justify-between p-4">
        <p class="text-sm">کافه یونیکد یکی از بهترین کافه های سطح شهر است که به ارائه انواع نوشیدنی و غذاهای خوشمزه میپردازد.</p>
  
   
    </div>
   
</div>


<?php get_template_part('components/waitermodal', name: 'single'); ?>
<?php get_footer(); ?>