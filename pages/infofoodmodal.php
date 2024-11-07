<?php
/*
Template Name: foodmodal
*/
get_header()
    ?>




<div class="fixed z-[999] overflow-y-auto top-0 w-full left-0 hidden" id="modal">
<div class="container-content yekan food-modal relative">
<button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2" onclick="toggleModal()"><i class="fas fa-times"></i> </button>

<div>
      <div class="text-center flex justify-center food-container">
        <img class="w-44 mt-12" src="<?php echo get_theme_image_url('burger1.png'); ?>" alt="Burger">
      </div>
      <div class="bg-white p-5 pt-3 rounded-tl-[50px] fixed bottom-0 md:w-[650px]">
        <div class="flex justify-between mt-3">
          <span class="text-lg">100000 تومن</span>
          <div class="flex items-center justify-between w-16 px-2 py-1 bg-[#210F59] rounded-lg">
            <img class="w-4" src="<?php echo get_theme_image_url('star.png'); ?>" alt="star">
            <span class="text-white rounded-lg text-lg">4.8</span>
          </div>
        </div>
        <div class="flex justify-between items-center mt-5 mb-4">
          <span class="font-bold text-xl peyda">برگر یونیکد</span>
          <div>
            <span>+</span>
            <span class="font-bold">1</span>
            <span>-</span>
          </div>
        </div>
        <small class="iransans">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون رایتابهای زیادی در شصاد.</small>
        <div class="mt-5">
          <h5 class="text-lg font-bold">اضافه:</h5>
          <div class="flex justify-between mt-5">
            <div class="bg-slate-100 rounded-xl relative">
              <img class="w-20" src="<?php echo get_theme_image_url('stake1.png'); ?>" alt="Burger">
              <span class="absolute -bottom-1 -right-1">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
              </span>
            </div>
            <div class="bg-slate-100 rounded-xl relative">
              <img class="w-20" src="<?php echo get_theme_image_url('stake1.png'); ?>" alt="Burger">
              <span class="absolute -bottom-1 -right-1">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
              </span>
            </div>
            <div class="bg-slate-100 rounded-xl relative">
              <img class="w-20" src="<?php echo get_theme_image_url('stake1.png'); ?>" alt="Burger">
              <span class="absolute -bottom-1 -right-1">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
              </span>
            </div>
          </div>
          <div class=" text-center mt-10 mb-4">
            <a class="text-white px-5 py-2 bg-[#210F59] rounded-xl">ثبت سفارش</a>
          </div>
        </div>
      </div>
    </div>
</div>
</div>


