<?php 

if (get_option('comments_visibility') === 'enabled') {
    ?>

<div class="spdiv">
<div class="chef-suggestion-title-container">
    <hr class="chef-suggestion-title-line">
    <span class="chef-suggestion-title-text reyhaneh text-2xl absolute top-0">نظرات</span>
    <button id="addcomment" class="chef-suggestion-add reyhaneh text-2xl h-[40px] w-[40px] flex justify-center items-center bg-[orange] text-white rounded-lg left-0 absolute">
        <ion-icon id="icon" name="add-outline"></ion-icon>
    </button>
</div>

<div id="commentForm" class="border yekan border-gray-300 p-4 rounded-lg max-w-xl mx-auto hidden opacity-0 transform translate-y-4 transition-all duration-500">
    <form id="comment-form">
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2" for="name">نام شما</label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-gray-500" id="name" type="text" placeholder="نام خود را وارد کنید">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2" for="comment">دیدگاه</label>
            <textarea rows="4" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-gray-500" id="comment" placeholder="نظرتان چیست؟"></textarea>
        </div>

        <div class="mb-4 flex justify-between items-center">
            <label class="block text-gray-700 font-medium mb-2">امتیاز</label>
            <div class="star-rating-container">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="button" id="submit-comment" class="bg-[orange] hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline">ثبت دیدگاه</button>
        </div>

        <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
    </form>
</div>



    
    <!-- Swiper -->
    <div class="swiper mySwiper">

        <div class="swiper-wrapper">
            <?php
            // گرفتن کامنت‌ها
            $comments = get_comments(array(

                'status' => 'approve' // فقط کامنت‌های تایید شده
            ));

            if ($comments) {
                foreach ($comments as $comment) {
                    ?>

<div class="swiper-slide">
    <div class="w-full text-right border border-gray-200 yekan group bg-white border border-solid border-gray-300 rounded-2xl p-3 transition-all duration-500 w-full hover:border-indigo-600 cursor-pointer">
        <div class="flex items-center mb-2 gap-2 text-amber-500 transition-all duration-500 group-hover:text-indigo-600 swiper-slide-active:text-indigo-600">
            <?php
            $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true)); // دریافت امتیاز کامنت
            for ($i = 0; $i < 5; $i++) { // برای پنج ستاره
                if ($i < $rating) { // اگر شماره ستاره کمتر از امتیاز باشد، پررنگ شود
                    echo '<svg class="w-5 h-5 text-amber-500" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z" fill="currentColor"/></svg>';
                } else { // اگر شماره ستاره بیشتر از امتیاز باشد، کمرنگ نمایش داده شود
                    echo '<svg class="w-5 h-5 text-gray-300" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z" fill="currentColor"/></svg>';
                }
            }
            ?>
        </div>
        
        <p class="text-[12px] text-gray-500 leading-2 h-16 transition-all duration-500 mb-9 group-hover:text-gray-800">
            <?php echo $comment->comment_content; ?>
        </p>
        
        <div class="flex items-center gap-5">
            <img class="rounded-full !w-[50px] !h-[50px] object-cover"
                src="https://www.pngall.com/wp-content/uploads/5/User-Profile-PNG-Image.png" alt="avatar" />
            <div class="grid gap-1">
                <h5 class="text-gray-900 text-[11px] font-medium transition-all duration-500 group-hover:text-indigo-600 swiper-slide-active:text-indigo-600">
                    <?php echo $comment->comment_author; ?>
                </h5>

                <span class="text-sm leading-6 text-gray-500">
                    <?php 
                    $comment_date = get_comment_date(); // تاریخ کامنت
                    echo $comment_date;
                    ?>
                </span>
            </div>
        </div>
    </div>
</div>

                    <?php
                }
            } else {
                echo '<p>هیچ نظری یافت نشد.</p>';
            }
            ?>

        </div>

    </div>

</div>


<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: "auto",
        autoplay: {
            delay: 3000, // مدت زمان بین هر تغییر اسلاید (۵۰۰۰ میلی‌ثانیه = ۵ ثانیه)
        },
        spaceBetween: 10,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>

<?php } ?>