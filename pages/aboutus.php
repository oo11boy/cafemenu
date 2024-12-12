
<div class="w-full pt-3 yekan">
    <div class="relative w-full h-[250px]">
        <!-- نمایش تصویر کافه از تنظیمات -->
        <img class="w-full h-full object-cover rounded-xl"
            src="<?php echo esc_url(get_option('cafe_image')); ?>" alt="کافه تصویر">
        <!-- لوگوی کافه از تنظیمات -->
        <img class="rounded-full imglogoinfo absolute -bottom-[25%] border-2 border-white right-[40%] w-[130px] h-[130px] object-cover"
            src="<?php echo esc_url(get_option('cafe_logo')); ?>" alt="لوگوی کافه">
    </div>
    <!-- نام کافه به زبان فارسی -->
    <h3 class="mt-20 text-center yekan text-2xl w-full"><?php echo esc_html(get_option('cafe_name')); ?></h3>
    <!-- نام کافه به زبان انگلیسی -->
    <h3 class="text-center yekan text-xl w-full"><?php echo esc_html(get_option('cafe_name_en')); ?></h3>
    <div class="flex informationpage flex-wrap mt-4 justify-between w-full">
        <!-- نمایش شماره تماس -->
        <a href="tel:<?php echo esc_attr(get_option('cafe_phone')); ?>" class="w-[49%] rounded-xl text-center bg-[#1f9d7e] text-[white] p-4 text-lg">
            <i class="fa fa-phone text-2xl mb-2" aria-hidden="true"></i>
            <div>ارتباط با ما</div>
        </a>
        <!-- نمایش لینک اینستاگرام -->
        <a href="<?php echo esc_url(get_option('cafe_instagram')); ?>" class="w-[49%] rounded-xl text-center bg-[#1f9d7e] text-[white] p-4 text-lg">
            <i class="fa fa-camera-retro text-2xl mb-2"></i>
            <div>اینستاگرام</div>
        </a>
    </div>

    <div class="mt-4 mapaddress bg-[#1f9d7e] w-full items-center rounded-xl text-white flex justify-between p-4">
        <!-- آدرس کافه -->

        <?php
 $tol=get_option('cafe_latitude');
 $arz=get_option('cafe_longitude')
 ?>
 <p class="text-sm"><?php echo esc_html(get_option('cafe_address')); ?></p>
        <a target="_blank" href="<?php echo "https://www.google.com/maps?q=$tol,$arz" ?>" class="border flex items-center gap-2 border-[#F8EEDA] py-1 px-2 text-sm">
            <i class="fa fa-map-marker text-[#F8EEDA]" aria-hidden="true"></i> مشاهده روی نقشه
</a>
    </div>


    <div class="mt-4 mapaddress bg-[#1f9d7e] w-full items-center rounded-xl text-white flex justify-between p-4">
        <p class="text-sm"><?php echo esc_html(get_option('cafe_description')); ?></p>
  
   
    </div>
</div>

<?php get_template_part('components/waitermodal', 'single'); ?>

<div class="h-[120px] flex justify-center items-start  mt-2 w-full">
    <a target="_blank" href="https://unicodewebdesign.com" class="reyhaneh text-gray-200 ">طراحی توسط تیم برنامه نویسی یونیکد</a>
</div>