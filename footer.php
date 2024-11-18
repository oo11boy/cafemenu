<?php get_template_part('components/endfooter', name: 'single'); ?>

</div>

<div class="footer">
    <div class="fixed z-50 w-full h-16 max-w-lg -translate-x-1/2 bg-white border border-gray-200 rounded-full bottom-4 left-1/2 bg-gray-700 border-gray-600">
        <div class="grid h-full max-w-lg grid-cols-5 mx-auto">
            <!-- دکمه تب خانه -->
            <button id="tab-home" class="tab-button  mt-[0]  inline-flex flex-col items-center justify-center px-5  group" type="button">
             
                    <i class="fa fa-home w-full text-2xl h-5 mb-1 text-gray-300 group-hover:text-blue-600" aria-hidden="true"></i>
                    <span class="w-full iransans text-[12px] pt-2 text-gray-300 group-hover:text-blue-600">منو</span>
           
           
            </button>
    
            <!-- دکمه تب بازی -->
            <button id="tab-game" class="tab-button mt-[0]  inline-flex flex-col items-center justify-center px-5  group" type="button">
             
                    <i class="fa fa-gamepad w-full text-2xl h-5 mb-1 text-gray-300 group-hover:text-blue-600" aria-hidden="true"></i>
                    <span class="w-full iransans text-[12px] pt-2 text-gray-300 group-hover:text-blue-600">بازی</span>
           
           
            </button>

       

            <div class="relative mt-[0] rounded-full border border-white bg-[#183D3D]  inline-flex flex-col items-center justify-center px-5  group" type="button">
    <i class="fa fa-shopping-cart w-5 text-2xl h-5 mb-1 text-white" aria-hidden="true"></i>
    <span class="sr-only">سبد خرید</span>
    <p id="cart-count" class="absolute top-1 left-12 text-[10px] w-6 h-6 flex justify-center items-center rounded-full bg-[green] text-white">0</p>
</div>

     
     <button id="tab-cart" class="tab-button mt-[0]  inline-flex flex-col items-center justify-center px-5  group" type="button">
            <i class="" aria-hidden="true"></i>
             <i class="fa  fa-list-alt w-full text-2xl h-5 mb-1 text-gray-300 group-hover:text-blue-600" aria-hidden="true"></i>
             <span class="w-full iransans text-[12px] pt-2 text-gray-300 group-hover:text-blue-600">سفارشات</span>
           
           
     </button>
     <button id="tab-info" class="tab-button mt-[0]  inline-flex flex-col items-center justify-center px-5  group" type="button">
            <i class="" aria-hidden="true"></i>
             <i class="fa fa-inbox w-full text-2xl h-5 mb-1 text-gray-300 group-hover:text-blue-600" aria-hidden="true"></i>
             <span class="w-full iransans text-[12px] pt-2 text-gray-300 group-hover:text-blue-600">درباره</span>
           
     </button>
        </div>
    </div>
</div>

<!-- استایل برای مخفی کردن تب‌ها -->
<style>
/* انیمیشن برای تغییر تب */
.tab-content {
    display: none;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.active-tab {
    display: block;
    opacity: 1;
}

</style>

<!-- اسکریپت jQuery برای مدیریت تب‌ها -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<?php wp_footer(); ?>
</body>
</html>
