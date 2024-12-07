<section class="special-offers">
    <h2 class="section-title reyhaneh text-2xl mb-10">تخفیفات</h2>
    <div class="card-container-offer yekan">
        <?php
        $args = array(
            'post_type' => 'food_item',
            'meta_key' => 'special_offer',
            'meta_value' => '1', // فقط آیتم‌های ویژه
            'posts_per_page' => -1, // نمایش همه پیشنهادهای ویژه
        );

        $special_offers_query = new WP_Query($args);
    
        if ($special_offers_query->have_posts()) :
            while ($special_offers_query->have_posts()) : $special_offers_query->the_post();
                $food_description = get_the_content();
                $food_title = get_the_title();
                $food_description = get_the_content();
                $food_image = get_the_post_thumbnail_url();
                $food_price = get_post_meta(get_the_ID(), 'food_price', true);
                $food_categories = wp_get_post_terms(get_the_ID(), 'food_category');
                $category_ids = wp_list_pluck($food_categories, 'term_id');
            ?>
                <div class="recipe-card-1 cursor-pointer" data-price="<?php echo esc_html($food_price); ?>" id="card" data-categories="<?php echo implode(' ', $category_ids); ?>">
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
                                
                            <p class="recipe-price" data-raw-price="<?php echo esc_attr($food_price); ?>"></p>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
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
                      <div class="quantity-input  flex justify-center !items-center  hidden items-center">
    
    
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
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>هیچ پیشنهاد ویژه‌ای یافت نشد.</p>';
        endif;
        ?>
    </div>
</section>

<?php get_template_part('pages/infofoodmodal', name: 'single'); ?>

