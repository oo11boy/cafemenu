<?php
/*
Template Name: foodmodal
*/

    ?>




<div class="fixed z-[900] overflow-y-auto top-0 w-full left-0 hidden" id="modal">
  <div class="container-content yekan food-modal relative">
    <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2" onclick="toggleModal()"><i class="fas fa-times"></i> </button>

    <div>
      <div class="text-center flex justify-center food-container">
        <img class="w-44 mt-12 rounded-xl bg-white" src="" alt="Food Image">
      </div>
      <div class="bg-white p-5 pt-3 rounded-tl-[50px] fixed bottom-0 md:w-[650px]">
        <div class="flex justify-between mt-3">
          <span class="text-lg food-price">100000 تومن</span>
        </div>
        <div class="flex justify-between items-center mt-5 mb-4">
          <span class="font-bold text-xl food-title">برگر یونیکد</span>
        </div>
        <small class="food-description">لورم ایپسوم متن ساختگی...</small>
        <div class="mt-5">
   


        
        <div class=" bg-[gray] rounded-lg p-1 card__actions absolute top-0 left-5 flex justify-between items-center mt-2">
                  <!-- دکمه + -->
                  <button
                     class="add-to-cart bg-[gray] text-white flex justify-center items-center text-2xl   h-[35px] w-[35px]  rounded-lg"
                     data-food-id="<?php echo esc_attr(get_the_ID()); ?>"
                     data-food-price="<?php echo esc_attr($food_price); ?>"
                     data-food-title="<?php echo esc_attr($food_title); ?>"
                     data-food-image="<?php echo esc_attr($food_image); ?>">
                     <i class="fa fa-plus text-lg" aria-hidden="true"></i>
                  </button>

                  <!-- اینپوت تعداد و دکمه‌های + و - -->
                  <div class="quantity-input flex justify-center !items-center  hidden items-center">


                     <button
                        class="decrease bg-[gray] text-white flex justify-center items-center text-2xl   h-[35px] w-[35px]  rounded-lg">
                        <i class="fa fa-minus" aria-hidden="true"></i></button>

                     <input type="number" id="quantity_<?php echo esc_attr(get_the_ID()); ?>" name="quantity" min="1"
                        value="1"
                        class="h-[35px] w-[35px] countcart rounded-lg bg-[#F7F8F9] flex  justify-center items-center text-center"
                        readonly>
                     <button
                        class="increase bg-[gray] text-white flex justify-center items-center text-2xl   h-[35px] w-[35px]  rounded-lg">
                        <i class="fa fa-plus text-lg" aria-hidden="true"></i></button>

                  </div>
               </div>
          <div class=" text-center mt-10 mb-4">
            <a  id="tab-cart"  class="tab-button cursor-pointer  text-white px-5 py-2 bg-[#210F59] rounded-xl">مشاهده سفارشات</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



