<?php
/*
Template Name: foodmodal
*/
get_header()
    ?>




<div class="fixed z-[120] overflow-y-auto top-0 w-full left-0 hidden" id="modal">
  <div class="container-content yekan food-modal relative">
    <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2" onclick="toggleModal()"><i class="fas fa-times"></i> </button>

    <div>
      <div class="text-center flex justify-center food-container">
        <img class="w-44 mt-12 rounded-xl" src="" alt="Food Image">
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
        
          <div class=" text-center mt-10 mb-4">
            <a  id="open-modal" class=" cursor-pointer  text-white px-5 py-2 bg-[#210F59] rounded-xl">ثبت سفارش</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



