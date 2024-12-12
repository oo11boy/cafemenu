<div class="pt-[3%] pb-[23%]">
<div id="cart-items" class="cart-container    rounded-lg mt-2  mx-auto ">
<div class="flex w-full mb-2 bg-gray-200 border rounded-md p-2 reyhaneh justify-between items-center">
    <p class="text-3xl text-black"><?php echo esc_html(get_option('cafe_name')); ?></p>
    <img class="w-[50px] h-[50px] rounded-full"   src="<?php echo esc_url(get_option('cafe_logo')); ?>"
        alt="Default avatar">
</div> 
<!-- پیغام سبد خرید خالی -->
    <div id="empty-cart-message" class=" text-center text-lg text-gray-500">

    <div class="h-[55vh] flex-col flex justify-center gap-2 items-center w-full">
        
   <i class="fa fa-2x text-gray-400 fa-shopping-cart" aria-hidden="true"></i>
   <p class="text-gray-400   yekan" >سبد سفارشات شما خالی است! </p>
 
   </div>
    </div>
    <div id="cart-list" class="flex max-h-[55vh]  overflow-auto flex-col gap-4">

  
    
    </div>
    <div class="mt-6 yekan text-center text-lg font-semibold text-gray-700">
        <p>جمع کل: <span id="total-price">0</span></p>
    </div>
</div>

<!-- دکمه ثبت درخواست گارسون -->
<button class="mt-4   w-full p-4 reyhaneh bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
    درخواست گارسون
</button>
</div>


