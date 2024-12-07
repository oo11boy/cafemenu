<section class="special-offers">
    <h2 class="section-title reyhaneh text-2xl mb-10">تخفیفات ویژه</h2>
    <div class="card-container-offer yekan">
        <?php
        $args = array(
            'post_type' => 'food_item',
            'meta_key' => 'discount_price', // فقط آیتم‌های دارای تخفیف
            'meta_value' => '!=', // نمایش همه محصولاتی که قیمت تخفیف‌دار دارند
            'meta_compare' => '!=', // چک می‌کند که مقدار تخفیف خالی نباشد
            'posts_per_page' => -1, // نمایش همه محصولات تخفیف‌دار
        );

        $discount_offers_query = new WP_Query($args);
   
        if ($discount_offers_query->have_posts()) {
            $has_posts = false; // متغیر کمکی برای بررسی اینکه آیا پست‌ها وجود دارند یا خیر
            while ($discount_offers_query->have_posts()) {
                $discount_offers_query->the_post();
                $food_title = get_the_title();
                $food_description = get_the_content();
                $food_image = get_the_post_thumbnail_url();
                $food_price = get_post_meta(get_the_ID(), 'food_price', true);
                $discount_price = get_post_meta(get_the_ID(), 'discount_price', true); // قیمت با تخفیف
                $discount_end_time = get_post_meta(get_the_ID(), 'discount_end_time', true); // زمان پایان تخفیف
                $food_categories = wp_get_post_terms(get_the_ID(), 'food_category');
                $category_ids = wp_list_pluck($food_categories, 'term_id');
                
                // چک می‌کنیم که قیمت تخفیف خالی نباشد و زمان تخفیف تمام نشده باشد
                if (!empty($discount_price)) {
                    // بررسی اینکه زمان تخفیف گذشته باشد یا نه
                    $current_time = current_time('timestamp');
                    $end_time = strtotime($discount_end_time);
        
                    if ($current_time > $end_time) {
                        // اگر زمان تخفیف گذشته بود، محصول نمایش داده نمی‌شود
                        continue;
                    }
                    ?>
                    <div class="recipe-card-1 cursor-pointer" data-price="<?php echo esc_html($discount_price); ?>" id="card" data-categories="<?php echo implode(' ', $category_ids); ?>">
                        <div id="card__image">
                            <img class="recipe-card-image object-cover" src="<?php echo esc_url($food_image ? $food_image : get_theme_image_url('dimg.png')); ?>" 
                            alt="<?php echo esc_attr($food_title); ?>" />
                        </div>
        
                        <div class="recipe-details-container" id="card__info">
                            <div class="recipe-info" id="car__info--title">
                                <h3><?php echo esc_html($food_title); ?></h3>
                                <span class="hidden">
                                    <?php echo esc_html($food_description) ?>
                                </span>
                                <div class="recipe-overview">
                                    <p class="recipe-price flex flex-col">
                                        <span class="line-through text-red-500"><?php echo esc_attr($food_price); ?> تومان</span> <!-- قیمت قبلی -->
                                        <span class="text-green-500"><?php echo esc_attr($discount_price); ?> تومان</span> <!-- قیمت تخفیف‌دار -->
                                    </p>
                                </div>
                            </div>
                        </div>
        
                        <div class="bg-[gray] rounded-lg p-1 card__actions absolute top-0 left-5 flex justify-between items-center mt-2">
                            <!-- دکمه + -->
                            <button
                                class="add-to-cart bg-[gray] text-white flex justify-center items-center text-2xl   h-[35px] w-[35px]  rounded-lg"
                                data-food-id="<?php echo esc_attr(get_the_ID()); ?>"
                                data-food-price="<?php echo esc_attr($discount_price); ?>"
                                data-food-title="<?php echo esc_attr($food_title); ?>"
                                data-food-image="<?php echo esc_attr($food_image); ?>">
                                <i class="fa fa-plus text-lg" aria-hidden="true"></i>
                            </button>
        
                            <!-- اینپوت تعداد و دکمه‌های + و - -->
                            <div class="quantity-input flex justify-center !items-center hidden items-center">
                                <button class="decrease bg-[gray] text-white flex justify-center items-center text-2xl h-[35px] w-[35px] rounded-lg">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </button>
                                <input type="number" id="quantity_<?php echo esc_attr(get_the_ID()); ?>" name="quantity" min="1" value="1" class="h-[35px] w-[35px] countcart rounded-lg bg-[#F7F8F9] flex justify-center items-center text-center" readonly>
                                <button class="increase bg-[gray] text-white flex justify-center items-center text-2xl h-[35px] w-[35px] rounded-lg">
                                    <i class="fa fa-plus text-lg" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                     $has_posts = true; // اگر حلقه اجرا شد، متغیر به true تغییر می‌کند
                } // پایان شرط بررسی تخفیف
            }
            wp_reset_postdata();
        } 
        if (!$has_posts) {
            echo '<p>هیچ محصول تخفیف‌داری یافت نشد.</p>'; // پیام بعد از اتمام حلقه در صورت عدم وجود پست
        }
        ?>
        
    </div>
</section>
