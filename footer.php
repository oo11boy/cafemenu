<?php get_template_part('components/endfooter', name: 'single'); ?>

</div>

<div class="footer">
    <div class="fixed z-50 w-full h-16 max-w-lg -translate-x-1/2 bg-white border border-gray-200 rounded-full bottom-4 left-1/2 bg-gray-700 border-gray-600">
        <div class="grid h-full max-w-lg grid-cols-5 mx-auto">
            <!-- دکمه تب خانه -->
            <button id="tab-home" class="tab-button inline-flex flex-col items-center justify-center px-5 rounded-s-full hover:bg-gray-50 dark:hover:bg-gray-800 group" type="button">
                <svg class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>
                <span class="sr-only">Home</span>
            </button>
    
            <!-- دکمه تب بازی -->
            <button id="tab-game" class="tab-button inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group" type="button">
             
                    <i class="fa fa-gamepad w-5 text-2xl h-5 mb-1 text-gray-500 group-hover:text-blue-600" aria-hidden="true"></i>
                    <span class="sr-only">بازی</span>
           
            </button>

            <button id="tab-info" class="tab-button inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group" type="button">
            <i class="" aria-hidden="true"></i>
             <i class="fa fa-inbox w-5 text-2xl h-5 mb-1 text-gray-500 group-hover:text-blue-600" aria-hidden="true"></i>
             <span class="sr-only">درباره ما</span>
     </button>


     
     <button id="tab-test" class="tab-button inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group" type="button">
            <i class="" aria-hidden="true"></i>
             <i class="fa fa-inbox w-5 text-2xl h-5 mb-1 text-gray-500 group-hover:text-blue-600" aria-hidden="true"></i>
             <span class="sr-only">علاقه مندی </span>
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
<script>
 $(document).ready(function () {
    // زمانی که دکمه‌ها کلیک می‌شوند
    $(".tab-button").click(function () {
        // همه تب‌ها را مخفی کرده و انیمیشن را شروع می‌کنیم
        $(".tab-content").fadeOut(300, function () {
            $(this).removeClass("active-tab");
        });

        // شناسه دکمه کلیک شده را بگیرید
        var tabId = $(this).attr("id").replace("tab-", "");

        // تب مربوطه را نمایش دهید
        $("#content-" + tabId).fadeIn(300, function () {
            $(this).addClass("active-tab");
        });
    });

    // به طور پیش‌فرض، اولین تب را نمایش دهید
    $("#content-home").addClass("active-tab");
    $(".tab-content").hide();
    $("#content-home").show();
});

</script>

<?php wp_footer(); ?>
</body>
</html>
